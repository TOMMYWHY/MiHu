<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function add(){
        if (!user_instance()->is_logged_in()){
            return['status'=>0,'msg'=>'login is required!'];
        }

        if (!rq('content')){
            return['status'=>0,'msg'=>'content is  required!'];
        }

        if (
        (!rq('question_id')&&!rq('answer_id'))||
        (rq('question_id')&&rq('answer_id'))
        ){
            return['status'=>0,'msg'=>'answer_id or question_id is required!'];
        }

        if (rq('question_id')){
            $question_ins=question_instance()->find(rq('question_id'));
            if(!$question_ins){
                return['status'=>0,'msg'=>' question_id is not exists!'];
            }
            $this->question_id=rq('question_id');
        }
        if (rq('answer_id')){
            $answer_ins=answer_instance()->find(rq('answer_id'));
            if(!$answer_ins){
                return['status'=>0,'msg'=>' answer_id is not exists!'];
            }
            $this->answer_id=rq('answer_id');
        }
        if (rq('reply_to')){
            /*此处的的comment model还未被实例,所以只能使用this*/
            $target_comment=$this->find(rq('reply_to'));
            if (!$target_comment){
                return['status'=>0,'msg'=>' reply_to is not exists!'];
            }

            if ($target_comment->user_id==session('user_id')){
                return['status'=>0,'msg'=>' cannot reply to yourself!'];}
            $this->reply_to=rq('reply_to');
        }

        $this->content=rq('content');
        $this->user_id=session('user_id');

        return $this->save()?
            ['status'=>1,'id'=>$this->id]:
            ['status'=>0,'msg'=>'db insert failed!'];

    }

    public function read(){

        if (!rq('question_id')&&!rq('answer_id')){
            return ['status' => 0, 'msg' => ' question_id or answer_id is required!'];
        }

        if (rq('question_id')){
            $question_ins=question_instance()->with('user')->find(rq('question_id'));
            if (!$question_ins) {
                return ['status' => 0, 'msg' => ' question_id is not exists!'];
                }
            $data=$this->with('user')->where('question_id','=',rq('question_id'))->get();
            }
        if (rq('answer_id')){
            $answer_ins=answer_instance()->with('user')->find(rq('answer_id'));
            if (!$answer_ins) {
                return ['status' => 0, 'msg' => ' answer_id is not exists!'];
            }
            $data=$this->with('user')->where('answer_id','=',rq('answer_id'))->get();
        }
        $data=$data->keyBy('id');
        return['status'=>1,'data'=>$data];

    }

    public function remove(){
        if (!user_instance()->is_logged_in()){
            return['status'=>0,'msg'=>'login is required!'];
        }

        if (!rq('id')){
            return['status'=>0,'msg'=>'id is required!'];
        }

        $comment_ins=$this->find(rq('id'));
        if (!$comment_ins){
            return['status'=>0,'msg'=>'id is not exists!'];
        }

        if ($comment_ins->user_id!=session('user_id')){
            return['status'=>0,'msg'=>'permission denied!'];
        }

        $this->where('reply_to','=',rq('id'))->delete();
        return $comment_ins->delete()?
            ['status'=>1]:
            ['status'=>0,'msg'=>'db delete failed!'];
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
