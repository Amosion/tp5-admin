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
     * 获取分店信息
     * @param int $status
     * @param int $is_main
     * @return \think\Paginator
     */
    public function getBisByStatus($status = 1,$is_main = 0){
        $data = [
            'status' => ['neq',-1],
			'is_main' => $is_main
        ];
        $order = [
            'id' =>'desc'
        ];
        return $this->where($data)->order($order)->paginate(5);
    }

    /**
     * 获取商户信息
     * @param $bisId
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getNormalLocationByBisId($bisId){
        $data = [
            'bis_id' => $bisId,
            'status' => 0
        ];
        $order = [
          'id' => 'desc'
        ];
        $result = $this->where($data)->order($order)->select();
        return $result;
    }

}