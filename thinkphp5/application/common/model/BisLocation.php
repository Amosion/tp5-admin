<?php
/**
 * Created by PhpStorm.
 * User: Amadeus
 * Date: 2017/10/29
 * Time: 23:22
 */

namespace app\common\model;
use think\Model;

class BisLocation extends BaseModel
{
    
    /**
     * 通过状态获取商家数据
     *
     */
    public function getBisByStatus($status = 0,$is_main = 0){
        $data = [
            'status' => $status,
			'is_main' => $is_main
        ];
        $order = [
            'id' =>'desc'
        ];
        return $this->where($data)->order($order)->paginate(5);
    }

}