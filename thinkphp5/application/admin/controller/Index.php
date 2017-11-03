<?php
namespace app\admin\Controller;
use think\Controller;
class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    public function welcome(){
        //\PHPMailer\Email::sendMail('13266489928@163.com','邮件来了','我的邮件');
        //return '发送邮件成功';
        return "welcome to o2o";
    }
    public function test(){
        //print_r(\Map::getLngLat('北京昌平沙河地铁'));
        return;
    }
    public function map(){
        //return \Map::staticimage('北京昌平沙河地铁');

    }
}
