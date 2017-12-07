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

    /**
     * 根据分类 以及 城市来获取 商品数据
     * @param $categoryId
     * @param $cityId
     * @param int $limit
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getNormalDealByCategoryCityId($categoryId,$cityId,$limit=10){
        $data =[
            //'end_time' => ['gt', time()],
            'category_id' => $categoryId,
            'city_id' => $cityId,
            'status' => 1
        ];
        $order = [
            'id' => 'desc',
            'listorder' => 'desc'
        ];
        $result = $this->where($data)->order($order);
        if($limit){
            $result = $result->limit($limit);
        }
        return $result->select();
    }
}