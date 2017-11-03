<?php
/**
 * Created by PhpStorm.
 * User: Amadeus
 * Date: 2017/10/25
 * Time: 20:17
 */

namespace app\api\controller;
use think\Controller;

class City extends Controller
{
    public function _initialize(){
        $this -> obj = model('City');
    }

    public function getCitysByParentId(){
        $id = input('post.id');
        if(!$id){
            $this->error('id不合法');
        }
        //通过id获取二级城市
        $citys = $this -> obj ->getNormalCitysByParentId($id);

        if(!$citys){
            return show(0,"error");
        }
        return show(1,"success",$citys);

    }

}