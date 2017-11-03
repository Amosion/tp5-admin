<?php
/**
 * Created by PhpStorm.
 * User: Amadeus
 * Date: 2017/10/26
 * Time: 14:23
 */

namespace app\api\controller;
use think\Controller;

class Category extends Controller
{
    public function _initialize(){
        $this -> obj = model('Category');
    }

    public function getCategoryByParentId(){
        $id = input('post.id',0,'intval');
        if(!$id){
            $this->error('id不合法');
        }
        //通过id获取二级城市
        $categorys = $this -> obj ->getNormalCategoryByParentId($id);

        if(!$categorys){
            return show(0,"error");
        }
        return show(1,"success",$categorys);

    }

}