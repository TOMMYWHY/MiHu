<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public function add(){
        if (!user_instance()->is_logged_in()){
            return['status'=>0,'msg'=>'login is required!'];
        }

        if (!(rq('content')&&rq('question_id'))){
            return['status'=>0,'msg'=>'content & question_id are required!'];
        }

        $question_ins=question_instance()->find(rq('question_id'));
//        dd($question_ins);
        if (!$question_ins){
            return['status'=>0,'msg'=>'question_id is not exists!'];
        }

        $answered=$this->where(['question_id'=>rq('question_id')],
                    ['user_id'=>session('user_id')])
                    ->count();

        if ($answered){
            return['status'=>0,'msg'=>'duplicate answers!'];
        }

        $this->user_id=session('user_id');
        $this->content=rq('content');
        $this->question_id=rq('question_id');

        return $this->save()?
            ['status'=>1,'id'=>$this->id]:
            ['status'=>0,'msg'=>'db insert failed!'];



    }

    public function change(){
        if (!user_instance()->is_logged_in()){
            return['status'=>0,'msg'=>'login is required!'];
        }
        if (!rq('id')||!rq('content')){
            return['status'=>0,'msg'=>'id&content are required!'];
        }

        $answer_ins=$this->find(rq('id'));
        if ($answer_ins->user_id!=session('user_id')){
            return ['status'=>0,'msg'=>'permission denied!'];
        }

        $answer_ins->content=rq('content');

//        return $this->save()?
        return $answer_ins->save()?
            ['status'=>1]:
            ['status'=>0,'msg'=>'db insert failed!'];

    }

    public function read_by_user_id($user_id){
        $user=user_instance()->find($user_id);
        if(!$user)
            return err('user not exists');
        $r= $this
            ->with('Question')
            ->where('user_id','=',$user_id)
            ->get()
            ->keyBy('id');
        return suc($r->toArray());
    }

    public function read(){
        if (!rq('id')&&!rq('question_id')&&!rq('user_id')){
            return['status'=>0,'msg'=>'id,user_id ro question_id is required!'];
        }

        if(rq('user_id')){
                $suer_id=rq('user_id')==='self'?
                    session('user_id'):
                    rq('user_id');
            return $this->read_by_user_id($suer_id);
        }

        if (rq('id')){
            $answer_ins=$this
                ->with('user')
                ->with('users')
                ->find(rq('id'));
//            dd($answer_ins->toArray());
            if (!$answer_ins)
                return['status'=>0,'msg'=>'id is not exists!'];
            else
                $answer_ins=$this->count_vote($answer_ins);
                return['status'=>1,'data'=>$answer_ins];

        }


        $question_ins=$this->find(rq('question_id'));
        if (!$question_ins){
            return['status'=>0,'msg'=>'question_id is not exists!'];
        }

        $answer_list=$this
            ->where('question_id','=',rq('question_id'))
            ->get()
            ->keyBy('id');
        return['status'=>1,'data_question_answer'=>$answer_list];
    }

    public function remove(){
        if (!user_instance()->is_logged_in()){
            return['status'=>0,'msg'=>'login is required!'];
        }
        if (!rq('id')){
            return['status'=>0,'msg'=>'id is required!'];
        }
        $answer_ins=$this->find(rq('id'));
        if (!$answer_ins){
            return['status'=>0,'msg'=>'id is not exists!'];
        }
        if ($answer_ins->user_id!=session('user_id')){
            return['status'=>0,'msg'=>'permission denied!'];
        }

        $this->delete();
        return $answer_ins->delete()?
            ['status'=>1]:
            ['status'=>0,'msg'=>'db delete failed!'];
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function users(){

        return $this
            ->belongsToMany('App\User')
            ->withPivot('vote') //注册vote这个字段
            ->withTimestamps();
        
    }

    public function vote(){
        if (!user_instance()->is_logged_in()){
            return['status'=>0,'msg'=>'login is required!'];
        }

        if(!rq('id')||!rq('vote')){
            return['status'=>0,'msg'=>'id & vote are required!'];
        }

        $answer_ins=$this->find(rq('id'));
        if (!$answer_ins){
            return['status'=>0,'msg'=>'id is not exists!'];
        }

        /*限制所传vote字符串长度*/
//        $vote=rq('vote')<=1?1:2;//
        $vote=rq('vote');
        if($vote!=1 && $vote!=2 && $vote!=3){
            return ['status'=>0,'msg'=>'invalid vote!'];
        }

        /*删除已投结果*/
        $answer_ins
            ->users()
            ->newPivotStatement()
            ->where('user_id','=',session('user_id'))
            ->where('answer_id','=',rq('id'))
            ->delete();

        if($vote==3)
            return ['status'=>1];

        $answer_ins
            ->users()
            ->attach(session('user_id'),['vote'=>$vote]);
        return ['status'=>1];
    }

    public function  question(){
        return $this->belongsTo('App\Question');
    }

    public function count_vote($answer_ins){
//        dd($answer_ins->users);
        $upvote_count=0;
        $downvote_count=0;
       foreach ( $answer_ins->users as $user){
           if($user->pivot->vote==1)
               $upvote_count++;
           else
               $downvote_count++;
       }
        $answer_ins->upvote_count=$upvote_count;
        $answer_ins->downvote_count=$downvote_count;
        return $answer_ins;

    }
}
