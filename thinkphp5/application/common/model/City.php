<?php
/**
 * Created by PhpStorm.
 * User: Amadeus
 * Date: 2017/10/25
 * Time: 18:18
 */

namespace app\common\model;
use think\Model;

class City extends Model
{
    /**
     * 根据parent_id获取城市信息
     * @param int $parent_id
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getNormalCitysByParentId($parent_id = 0){
        $data = [
            'parent_id' => $parent_id,
            'status' => 1
        ];
        $order = [
           'id' =>'desc'
        ];
        return $this->where($data)->order($order)->select();

    }

    /**
     * 获取所有城市信息
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getNormalCitys(){
        $data = [
            'status' => 1,
            //'parent_id' => ['gt',0]
        ];
        $order = [
            'id' =>'desc'
        ];
        return $this->where($data)->order($order)->select();

    }

}