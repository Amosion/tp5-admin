<?php
/**
 * Created by PhpStorm.
 * User: Amadeus
 * Date: 2017/11/2
 * Time: 23:36
 */

namespace app\admin\Controller;
use think\Controller;

class Deal extends Controller
{
    private $obj;
    public function _initialize(){
        $this->obj = model('Deal');
    }
    public function index(){
        $data = input('get.');
        $sdata = [];
        if(!empty($data['category_id'])){
            $sdata['category_id'] = $data['category_id'];
        }
        if(!empty($data['city_id'])){
            $sdata['city_id'] = $data['city_id'];
        }
        if(!empty($data['start_time']) && !empty($data['end_time']) && strtotime($data['end_time'])>strtotime($data['start_time'])){
            $sdata['create_time'] = [
                ['gt',strtotime($data['end_time'])],
                ['lt',strtotime($data['start_time'])]
            ];
        }
        if(!empty($data['name'])){
            $sdata['name'] = ['like','%'.$data['name'].'%'];
        }
        //获取一级城市数据
        $citys = model('City')->getNormalCitys();
        foreach ($citys as $city){
            $cityArrs[$city->id] = $city->name;
        }
        //获取一级栏目数据
        $categorys = model('Category')->getNormalCategoryByParentId();
        foreach ($categorys as $category){
            $categoryArrs[$category->id] = $category->name;
        }
        $deals = $this->obj->getNormalDeals($sdata);
        return $this->fetch('',[
            'citys' => $citys,
            'categorys'=> $categorys,
            'deals' => $deals,
            'category_id' => empty($data['category_id'])? '':$data['category_id'],
            'city_id' => empty($data['city_id'])? '':$data['city_id'],
            'name' => empty($data['name']) ? '' : $data['name'],
            'start_time' => empty($data['start_time']) ? '' : $data['start_time'],
            'end_time' => empty($data['end_time']) ? '' : $data['end_time'],
            'cityArrs' => $cityArrs,
            'categoryArrs' => $categoryArrs

        ]);
    }

    /**
     * 商品团购提交页面
     * @return mixed
     */
    public function apply(){
        $data = input('get.');
        $sdata = [];
        if(!empty($data['category_id'])){
            $sdata['category_id'] = $data['category_id'];
        }
        if(!empty($data['city_id'])){
            $sdata['city_id'] = $data['city_id'];
        }
        if(!empty($data['start_time']) && !empty($data['end_time']) && strtotime($data['end_time'])>strtotime($data['start_time'])){
            $sdata['create_time'] = [
                ['gt',strtotime($data['end_time'])],
                ['lt',strtotime($data['start_time'])]
            ];
        }
        if(!empty($data['name'])){
            $sdata['name'] = ['like','%'.$data['name'].'%'];
        }
        //获取一级城市数据
        $citys = model('City')->getNormalCitys();
        foreach ($citys as $city){
            $cityArrs[$city->id] = $city->name;
        }
        //获取一级栏目数据
        $categorys = model('Category')->getNormalCategoryByParentId();
        foreach ($categorys as $category){
            $categoryArrs[$category->id] = $category->name;
        }
        $deals = $this->obj->getNormalDealsByApply($sdata);
        return $this->fetch('',[
            'citys' => $citys,
            'categorys'=> $categorys,
            'deals' => $deals,
            'category_id' => empty($data['category_id'])? '':$data['category_id'],
            'city_id' => empty($data['city_id'])? '':$data['city_id'],
            'name' => empty($data['name']) ? '' : $data['name'],
            'start_time' => empty($data['start_time']) ? '' : $data['start_time'],
            'end_time' => empty($data['end_time']) ? '' : $data['end_time'],
            'cityArrs' => $cityArrs,
            'categoryArrs' => $categoryArrs

        ]);
    }

    public function status(){
        $data = input('get.');
        //validate
        $res = $this->obj->save(['status' => $data['status']], ['id' => $data['id']]);
        if($res){
            $this->success('状态更新成功');
        }else {
            $this->error('状态更新失败');
        }

    }
}