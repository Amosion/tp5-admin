<?php
/**
 * Created by PhpStorm.
 * User: Amadeus
 * Date: 2017/11/5
 * Time: 23:50
 */

namespace app\bis\controller;
use think\Controller;

class Base extends Controller
{
    public function _initialize(){
        //判定用户是否登录
        $isLogin = $this->isLogin();
        if(!$isLogin){
            return $this->redirect(url('login/index'));
        }
    }

    //判定是否登录
    public function isLogin(){
        //获取session
        $user = $this->getLoginUser();
        if($user && $user->id){
            return true;
        }else{
            return false;
        }
   }

   //获取session
    public function getLoginUser(){
        $account = session('bisAccount','','bis');
        return $account;
    }

}