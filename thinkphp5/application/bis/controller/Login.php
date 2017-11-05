<?php
namespace app\bis\controller;
use think\Controller;

class Login extends Controller
{
    public function index(){
        if(request()->isPost()){
            //登录逻辑
            //获取相关数据
            $data = input('post.');
            //通过用户名获取用户相关信息
            //严格判定
            $ret = model('BisAccount')->get(['username' => $data['username']]);

            if(!$ret || $ret->status != 1){
                $this->error('用户不存在');
            }
            if($ret->password != md5($data['password'].$ret->code)){
                $this->error('密码不正确');
            }
            model('BisAccount')->updateById(['last_login_time' => time()], $ret->id);
            //保存用户信息  bis是作用域
            session('bisAccount',$ret,'bis');
            return $this->success('登录成功',url('index/index'));

        }else{
            //获取session
            $account = session('bisAccount','','bis');
            if($account && $account->id){
                return $this->redirect(url('index/index'));
            }
            return $this->fetch();
        }
    }

    //退出登录
    public function logout(){
        session(null,'bis');
        return $this->redirect(url('login/index'));
    }

}