<?php
/**
 * Created by PhpStorm.
 * User: Amadeus
 * Date: 2017/10/29
 * Time: 23:22
 */

namespace app\common\model;
use think\Model;

class Deal extends BaseModel
{
    /**
     * @param array $data
     * @return \think\Paginator
     */
    public function getNormalDeals($data = []){
        $data['status'] = 1;
        $order = ['id' => 'desc'];
        $result = $this->where($data)->order($order)->paginate();
        return $result;
    }
    /**
     * @param array $data
     * @return \think\Paginator
     */
    public function getNormalDealsByApply($data = []){
        $data['status'] = 0;
        $order = ['id' => 'desc'];
        $result = $this->where($data)->order($order)->paginate();
        return $result;
    }

}