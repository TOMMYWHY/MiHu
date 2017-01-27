<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//function is_logged_in(){
//    return session('user_id')?:false;
//}

/*封装*/
//    function user_obj(){
//        return new App\User;
//    }

Route::get('/',function (){
    return view('index');
});
/*
 * api
 * */
Route::any('api',function (){

    return ['version'=>0.1];
});

Route::any('api/signup',function (){
    return user_instance()->signup();
});
Route::any('api/login',function (){
    return user_instance()->login();
});
Route::any('api/logout',function (){
    return user_instance()->logout();
});
Route::any('api/test',function (){
    dd( user_instance()->is_logoed_in());
});
Route::any('api/user/exists',function (){
    return user_instance()->exists();
});
Route::any('api/user/change_password',function (){
    return user_instance()->change_password();
});
Route::any('api/user/reset_password',function (){
    return user_instance()->reset_password();
});
Route::any('api/user/validate_reset_password',function (){
    return user_instance()->validate_reset_password();
});
Route::any('api/user/read',function (){
    return user_instance()->read();
});



Route::any('api/question/add',function (){
    return question_instance()->add();
});
Route::any('api/question/change',function (){
    return question_instance()->change();
});
Route::any('api/question/remove',function (){
    return question_instance()->remove();
});
Route::any('api/question/read',function (){
    return question_instance()->read();
});

Route::any('api/answer/add',function (){
    return answer_instance()->add();
});
Route::any('api/answer/change',function (){
    return answer_instance()->change();
});
Route::any('api/answer/read',function (){
    return answer_instance()->read();
});
Route::any('api/answer/vote',function (){
    return answer_instance()->vote();
});

Route::any('api/comment/add',function (){
    return comment_instance()->add();
});
Route::any('api/comment/read',function (){
    return comment_instance()->read();
});
Route::any('api/comment/remove',function (){
    return comment_instance()->remove();
});

Route::any('api/timeline','CommonController@timeline');

Route::get('tpl/page/home',function (){
    return view('page/home');
});
Route::get('tpl/page/login',function (){
    return view('page/login');
});
Route::get('tpl/page/signup',function (){
    return view('page/signup');
});
Route::get('tpl/page/question_add',function (){
    return view('page/question_add');
});