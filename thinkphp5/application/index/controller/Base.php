<?php
/**
 * Created by PhpStorm.
 * User: Amadeus
 * Date: 2017/11/26
 * Time: 12:19
 */

namespace app\index\controller;
use think\Controller;

class Base extends Controller
{
    public $city = '';
    public $account = '';
    public function _initialize(){
        //城市数据
        $citys = model('City')->getNormalCitys();

        //用户数据
        $this->getCity($citys);
        // 获取首页分类的数据
        $cats = $this->getRecommendCats();
        $this->assign('citys',$citys);
        $this->assign('city', $this->city);
        $this->assign('title','o2o');
        $this->assign('user',$this->getLoginUser());
        $this->assign('cats',$cats);
    }

    /**
     * @param $citys
     */
    public function getCity($citys){
        foreach ($citys as $city) {
            $city->toArray();
            if($city['is_default'] == 1) {
                $defaultuname = $city['uname'];
                break; // 终止foreach
            }
        }
        $defaultuname = $defaultuname ? $defaultuname : '';

        if(session('cityuname','','o2o') && !input('get.city')){
            $cityuname = session('cityuname','','o2o');
        }else {
            $cityuname = input('get.city', $defaultuname, 'trim');
            session('cityuname', $cityuname, 'o2o');
        }
        $this->city = model('City')->where(['uname'=>$cityuname])->find();
    }

    /**
     * 获取登陆用户
     * @return mixed|string
     */
    public function getLoginUser(){
        if($this->account){
            $this->account = session('o2o_user','','o2o');
        }
        return $this->account;
    }
    /**
     * 获取一级和二级分类数据|获取首页推荐当中的商品分类数据
     * @return array
     */
    public function getRecommendCats(){
        $parentId = $seCatsArr = $recomCats = [];
        //一级分类
        $cats = model('Category')->getNormalRecommendCategoryByParentId(0,5);
        foreach ($cats as $cat){
            $parentId[] = $cat->id;
        }
        //二级分类
        $seCats = model('Category')->getNormalCategoryIdParentId($parentId);
        foreach ($seCats as $seCat){
            $seCatsArr[$seCat->parent_id][] = [
                'id' => $seCat->id,
                'name' => $seCat->name
            ];
        }
        foreach ($cats as $cat){
            $recomCats[$cat->id] = [
                $cat->name, empty($seCatsArr[$cat->id])? [] : $seCatsArr[$cat->id]
            ];
        }
        return $recomCats;
    }
}