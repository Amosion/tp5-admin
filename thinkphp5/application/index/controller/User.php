<?php
/**
 * Created by PhpStorm.
 * User: Amadeus
 * Date: 2017/11/23
 * Time: 23:02
 */

namespace app\index\controller;
use think\Controller;
use think\Exception;

class User extends Controller
{
    private  $obj;
    public function _initialize() {
        $this->obj = model("User");
    }

    /**
     * 登录页面
     * @return mixed
     */
    public function login(){
        //获取session状态
        $user = session('o2o_user','','o2o');
        if($user && $user->id){
            $this->redirect('index/index');
        }
        return $this->fetch();
    }

    /**
     * 注册页面
     * @return mixed
     */
    public function register(){
       if(request()->isPost()) {
           $data = input('post.');
           //validate
           if(!captcha_check($data['verifycode'])){
               //验证码自动刷新待优化
               $this->error('验证码不正确');
           }
           if($data['password'] != $data['repassword']) {
               $this->error('两次输入的密码不一样');
           }
           // 自动生成 密码的加盐字符串
           $data['code'] = mt_rand(100,10000);
           $data['password'] = md5($data['password'].$data['code']);

           try{
               $res = $this->obj->add($data);
           }catch (\Exception $e){
               $this->error($e->getMessage());
           }
           if($res){
               $this->success('注册成功',url('user/login'));
           }else{
               $this->error('注册失败');
           }
       }else {
           return $this->fetch();
       }
    }

    /**
     * 登录验证
     */
    public function logincheck(){
        if(!request()->isPost()){
            $this->error('提交不合法');
        }
        $data = input('post.');
        //validate

        try{
            $user = $this->obj->getUserByUsername($data['username']);
        }catch (\Exception $e){
            $this->error($e->getMessage());
        }
        //判断用户是否存在
        if(!$user || $user->status != 1 ){
            $this->error('用户不存在');
        }
        //判断密码
        if(md5($data['password'].$user['code']) !== $user->password){
            $this->error('密码不正确');
        }
        //登录成功
        $this->obj->updateById(['last_login_time'=>time()], $user->id);
        //session
        session('o2o_user',$user,'o2o');
        $this->success('登录成功',url('index/index'));

    }

    /**
     * 退出登录
     */
    public function logout(){
        //消除session
        session(null,'o2o');
        $this->redirect('user/login');
    }
}