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

}