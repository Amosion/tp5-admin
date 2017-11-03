<?php
/**
 * Created by PhpStorm.
 * User: Amadeus
 * Date: 2017/11/2
 * Time: 23:36
 */

namespace app\admin\Controller;
use think\Controller;

class Bis extends Controller
{
    private $obj;
    public function _initialize(){
        $this -> obj = model('Bis');
    }

    /**
     * 入驻申请列表
     */
    public function apply(){
        $bis = $this->obj->getBisByStatus();
        return $this->fetch('',[
            'bis' => $bis
        ]);

    }
}