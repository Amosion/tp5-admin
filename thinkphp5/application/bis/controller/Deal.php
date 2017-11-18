<?php
/**
 * Created by PhpStorm.
 * User: Amadeus
 * Date: 2017/11/13
 * Time: 20:37
 */

namespace app\bis\controller;
use think\Controller;

class Deal extends Base
{
    private $obj;
    public function _initialize(){
        $this->obj = model('Deal');
    }
    /**
     * 团购列表
     * @return mixed
     */
    public function index()
    {
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
     * 团购添加页面逻辑
     * @return mixed
     */
    public function add()
    {

        $bisId = $this->getLoginUser()->bis_id;;
        if(request()->isPost()){
            $data = input('post.');
            //validate 验证

            //分店id为索引
            $location = model('BisLocation')->get($data['location_ids'][0]);
            $deals = [
                'name' => $data['name'],
                'city_id' => $data['city_id'],
                'image' => $data['image'],
                'category_id' => $data['category_id'],
                'se_category_id' => empty($data['se_category_id']) ? '' : implode(',', $data['se_category_id']),
                'location_ids' => empty($data['location_ids']) ? '' : implode(',', $data['location_ids']),
                'start_time' => strtotime($data['start_time']),
                'end_time' => strtotime($data['end_time']),
                'total_count' => $data['total_count'],
                'origin_price' => $data['origin_price'],
                'current_price' => $data['current_price'],
                'coupons_begin_time' => strtotime($data['coupons_begin_time']),
                'coupons_end_time' => strtotime($data['coupons_end_time']),
                'notes' => $data['notes'],
                'description' => $data['description'],
                'bis_account_id' => $this->getLoginUser()->id,
                'xpoint' => $location->xpoint,
                'ypoint' => $location->ypoint,

            ];
            $id = $this->obj->add($deals);
            if($id){
                $this->success('添加成功',url('deal/index'));
            }else{
                $this->error('添加失败');
            }
        }else {
            //获取一级城市数据
            $citys = model('City')->getNormalCitysByParentId();
            //获取一级栏目数据
            $categorys = model('Category')->getNormalCategoryByParentId();
            //获取地址数据
            $bislocations = model('BisLocation')->getNormalLocationByBisId($bisId);
            return $this->fetch('', [
                'citys' => $citys,
                'categorys' => $categorys,
                'bislocations' => $bislocations
            ]);
        }
    }

}