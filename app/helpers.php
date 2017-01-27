<?php
/**
 * Created by PhpStorm.
 * User: Tommy
 * Date: 16/11/11
 * Time: 下午11:05
 */

function is_logged_in(){
    return session('user_id')?:false;
}

function user_instance(){
    return new App\User;
}

function question_instance(){
    return new App\Question();
}

function answer_instance(){
    return new App\Answer();
}

function comment_instance(){
    return new App\Comment();
}

function rq($key=null,$default=null){
    if (!$key){
        return \Illuminate\Support\Facades\Request::all();
    }else{
        return Request::get($key,$default);
    }
}

function paginate($page=1,$limit=16){

    $limit=$limit?:16;
    $skip=($page?$page-1:0)*$limit;
    return[$limit,$skip];
}

function err($msg=null){
    return ['status'=>0,'msg'=>$msg];
}

function suc($data_to_merge=[]){
    $data=['status'=>1,'data'=>[]];
    if ($data_to_merge){
        $data['data']=array_merge($data['data'],$data_to_merge);
    }
    return $data;
}





