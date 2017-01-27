<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public function add(){
        if (!user_instance()->is_logoed_in()){
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
        if (!user_instance()->is_logoed_in()){
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

    public function read(){
        if (!rq('id')&&!rq('question_id')){
            return['status'=>0,'msg'=>'id ro question_id is required!'];
        }

        if (rq('id')){
            $answer_ins=$this->find(rq('id'));
            if (!$answer_ins){
                return['status'=>0,'msg'=>'id is not exists!'];
            }else{
                return['status'=>1,'data_answer'=>$answer_ins];
            }
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
        if (!user_instance()->is_logoed_in()){
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
        $vote=rq('vote')<=1?1:2;
        /*删除已投结果*/
        $answer_ins
            ->users()
            ->newPivotStatement()
            ->where('user_id','=',session('user_id'))
            ->where('answer_id','=',rq('id'))
            ->delete();

        $answer_ins
            ->users()
            ->attach(session('user_id'),['vote'=>$vote]);
        return ['status'=>1];
    }
}
