<?php
/**
 * Created by PhpStorm.
 * User: Amadeus
 * Date: 2017/11/21
 * Time: 13:34
 */

namespace app\common\model;
use think\Model;

class Feature extends BaseModel
{
    /**
     * 根据类型获取列表数据
     * @param $type
     * @return \think\Paginator
     */
    public function getFeaturesByType($type){
        $data = [
            'type' => $type,
            'status' => ['neq',-1]
        ];
        $order = ['id' => 'desc'];
        return $this->where($data)->order($order)->paginate();
    }

}