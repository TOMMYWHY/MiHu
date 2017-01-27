<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;


//use Request;

class User extends Model
{
    /*所传参数是否包含 username password*/
    public function has_username_and_password(){
        $username=rq('username');
        $password=rq('password');
        if (!($username&&$password)){
            return false;
        } else{
            return [$username,$password];
        }

    }

    public function signup (){
        /*获取传递的username password值*/
        $has_username_and_password=$this->has_username_and_password();
        if (!$has_username_and_password){
            return ['status' => 0, 'msg' => 'username and password are required!'];
        }else{
            $username=$has_username_and_password[0];
            $password=$has_username_and_password[1];
        }


        $user_exists=$this->where('username','=',$username)->exists();

//            dd($user_exists);
        /*查看以前是否注册过*/
        if ($user_exists) {
            return ['status' => 0, 'msg' => 'username is exist'];
        }

        /*将新用户 密码加密 并 储存*/

         $hashed_password=Hash::make($password);

//        dd($hashed_password);

        /*对于this的理解:
         *user model是个类。 类终将通过new被实例出来
         * this 指的就是将要被new出来的对象实例
         * 而user model的实例则是数据库中对应的一条数据
         * 所以 this身上挂载了 username password email phone 等成员变量。
         */
        $this->password=$hashed_password;
        $this->username=$username;
        if(!$this->save()){
            return ['status' => 0, 'msg' => 'data insert fail!'];
        }else{
            return ['status' => 1, 'msg' => 'signup success!', 'id'=>$this->username];
        }

    }

    public function login(){
        /*获取传递的username password值*/
        $has_username_and_password=$this->has_username_and_password();
        if (!$has_username_and_password){
            return ['status' => 0, 'msg' => 'username and password are required!'];
        }else{
            $username=$has_username_and_password[0];
            $password=$has_username_and_password[1];
        }
        /*比对数据库中的数据*/
        $user_instance=$this->where('username','=',$username)->first();
//        dd($user_instance);
        if(!$user_instance){
            return ['status' => 0, 'msg' => 'username is not exist!'];
        }
        /*密码解密*/
        $hashed_password =$user_instance->password;//数据库中密码
//        dd(Hash::check($password,$hashed_password));
        if (!Hash::check($password,$hashed_password)){
            return ['status' => 0, 'msg' => 'password is error!'];
        }else{
            session()->put('user_id',$user_instance->id);
            session()->put('username',$user_instance->username);
//            dd(session()->all());
            return ['status' => 1, 'msg' => 'welcome!',
                'id'=>$user_instance->id,
                'username'=>$user_instance->username];
        }

    }

    public function logout(){
        session()->forget('username');
        session()->forget('user_id');
//        return redirect('/');
        return ['status' => 1, 'msg' => 'see you!'];
    }

    public function is_logged_in(){
        return is_logged_in();
    }

    public function answers(){
        return $this
            ->belongsToMany('App\Answer')
            ->withPivot('vote') //注册vote这个字段
            ->withTimestamps();

    }

    public function change_password(){
       if (!$this->is_logged_in()){
           return err('login is required!');
       }

       if (!rq('old_password')||!rq('new_password')){
           return['status'=>0,'msg'=>'old_password & new_password are required!'];
       }

       $user=$this->find(session('user_id'));
       if (!Hash::check(rq('old_password'),$user->password)){
           return['status'=>0,'msg'=>'invalid old_password!'];
       }
       $user->password=bcrypt(rq('new_password'));
       return $user->save()?
//           ['status'=>1,'id'=>$user->id]
           suc(['id'=>$user->id]):
           err('db insert failed!');
//           ['status'=>0,'msg'=>'db insert failed!'];


   }

    public function reset_password(){


        if ($this->is_robot()){
            return err('max frequency reached');
        }

        if (!rq('phone')){
            return err('phone is required');
        }
        $user_ins=$this->where('phone','=',rq('phone'))->first();
//        dd($user_ins);
        if (!$user_ins){
            return err('invalid phone');
        }

        $captcha=$this->generate_captcha();

        $user_ins->phone_captcha=$captcha;
        if( $user_ins->save()){
            $this->send_sms();

            $this->update_robot_time();

            return suc();
        }else{
            return  err('db insert failed');}
    }

    public function send_sms(){
        return true;
    }

    /*生成随机数*/
    public function generate_captcha(){
        return rand(1000,9999);
    }

    public function validate_reset_password(){
        if ($this->is_robot(2)){
            return err('max frequency reached');
        }

        if (!rq('phone')||!rq('phone_captcha')||!rq('new_password')){
            return err('phone phone_captcha & new_password are required!');
        }

        $user_ins=$this->where([
            'phone'=>rq('phone'),
            'phone_captcha'=>rq('phone_captcha')
        ])->first();

        if (!$user_ins){
            return err('invalid phone or phone_captcha');
        }

        $user_ins->password= bcrypt(rq('new_password'));
        $this->update_robot_time();
        return $user_ins->save()?
            suc():
            err('db insert failed!');
    }

    public function is_robot($time=10){

        if (!session('last_sms_time')){
            return false;
        }
        $current_time=time();
        $last_active_time=session('last_sms_time');
        $elapsed=$current_time-$last_active_time;

       return !($elapsed>$time);
    }

    public function update_robot_time(){
        session()->set('last_sms_time',time());
    }

    public function read(){
        if (!rq('id')){
            return err('id is required!');
        }

        $get_info=['id','username','avatar_url','intro'];
        $user_ins=$this->find(rq('id'),$get_info);

//        dd($user_ins->toArray());
        $data=$user_ins->toArray();

        $answer_count=answer_instance()
                ->where('user_id',rq('id'))
                ->count();
        $question_count=question_instance()
            ->where('user_id',rq('id'))
            ->count();

        $data['answer_count']=$answer_count;
        $data['question_count']=$question_count;

        return suc($data);
        

    }

    public function exists(){
        return suc(['count'=>$this->where(rq())->count()]);
    }


}
