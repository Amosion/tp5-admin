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
        return "welcome to o2o";
    }
}
