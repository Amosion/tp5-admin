<?php
/**
 * Created by PhpStorm.
 * User: Amadeus
 * Date: 2017/11/7
 * Time: 20:28
 */

namespace app\bis\controller;


class Location extends Base
{
    /**
     * @return mixed
     * 门店列表
     */
    public function index(){
		$bis = model('BisLocation')->getBisByStatus();
        return $this->fetch('',[
		    'bis' => $bis
        ]);
    }

    /**
     * @return mixed|void
     * 门店新增
     */
    public  function add(){
        if(request()->isPost()){
            $data = input('post.');
            $bisId = $this->getLoginUser()->bis_id;
            $data['cat'] = '';
            if(!empty($data['se_category_id'])) {
                $data['cat'] = implode('|', $data['se_category_id']);
            }
            //验证机制(
            $validate = validate('Location');
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());
            }
            //获取经纬度
            $Lnglat = \Map::getLnglat($data['address']);
            if(empty($Lnglat) || $Lnglat['status'] !=0 || $Lnglat['result']['precise'] !=1){
                $this->error('无法获取数据，或者匹配地址不准确');
            }
            //总店相关信息入库
            $locationData = [
                'bis_id' => $bisId,
                'name' => $data['name'],
                'tel' => $data['tel'],
                'contact' => $data['contact'],
                'category_id' => $data['category_id'],
                'category_path' => $data['category_id'].','.$data['cat'],
                'city_id' => $data['city_id'],
                'city_path' => empty($data['se_city_id']) ? $data['city_id']:$data['city_id'].','.$data['se_city_id'],
                'api_address' => $data['address'],
                'open_time' => $data['open_time'],
                'content' => empty($data['content']) ? '':$data['content'],
                'is_main' => 0,
                'xpoint' => empty($Lnglat['result']['location']['lng']) ? '':$Lnglat['result']['location']['lng'],
                'ypoint' => empty($Lnglat['result']['location']['lat']) ? '':$Lnglat['result']['location']['lat'],

            ];
            $locationId = model('BisLocation')->add($locationData);
            if($locationData){
                return $this->success('门店申请成功');
            }else{
                return $this->error('门店申请失败');
            }

        }else {
            //获取一级城市数据
            $citys = model('City')->getNormalCitysByParentId();
            //获取一级栏目数据
            $categorys = model('Category')->getNormalCategoryByParentId();
            return $this->fetch('', [
                'citys' => $citys,
                'categorys' => $categorys
            ]);
        }
    }

}