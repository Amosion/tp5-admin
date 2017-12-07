<?php
namespace app\common\model;

use think\Model;

class Category extends Model
{
    protected $autoWriteTimestamp = true;
    public function add($data){

        $data['status'] = 1;
        //$data['create_time'] = time();
        return $this->save($data);
    }

    //获取一级分类
    public function getNormalFirstCategory(){
        $data = [
            'status' => 1,
            'parent_id' => 0,
        ];

        $order = [
            'id' => 'desc'
        ];
        return $this->where($data)->order($order)->select();

    }

    //获取二级分类
    public function getNormalFirstCategorys($parent_id = 0){
        $data = [
            'parent_id' => $parent_id,
            'status' => ['neq',-1]
        ];

        $order = [
          'listorder' => 'desc',
          'id' => 'desc'
        ];

        $result = $this->where($data)->order($order)->paginate();
        //echo $this -> getLastSql();
        return $result;
    }

    //根据parentId获取分类
    public function getNormalCategoryByParentId($parent_id = 0){
        $data = [
            'status' => 1,
            'parent_id' => $parent_id,
        ];

        $order = [
            'id' => 'desc'
        ];
        return $this->where($data)->order($order)->select();
    }

    //根据limit获取一级分类
    public function getNormalRecommendCategoryByParentId($id,$limit=5){
        $data = [
            'parent_id' => $id,
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

    //根据以上的一级分类获取二级分类
    public function getNormalCategoryIdParentId($ids){
        $data = [
            'parent_id' => ['in',implode(',',$ids)],
            'status' => 1
        ];
        $order =[
            'id' => 'desc',
            'listorder' => 'desc'
        ];
        return $this->where($data)->order($order)->select();
    }

}