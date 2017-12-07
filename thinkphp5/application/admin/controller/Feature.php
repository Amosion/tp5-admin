<?php
/**
 * Created by PhpStorm.
 * User: Amadeus
 * Date: 2017/11/20
 * Time: 21:00
 */
namespace app\admin\Controller;
use think\Controller;

class Feature extends Base
{
    private  $obj;
    public function _initialize() {
        $this->obj = model("Feature");
    }

    public function index(){
        //推荐位类别
        $types = config('feature.feature_type');
        $type = input('get.type',0, 'intval');
        //根据类型获取数据
        $results = $this->obj->getFeaturesByType($type);
        return $this->fetch('',[
            'types' => $types,
            'results' => $results
        ]);
    }

    public function add(){
        if(request()->isPost()) {
            $data = input('post.');
            //validate

            $id = $this->obj->add($data);
            if($id){
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
        }else {
            $types = config('feature.feature_type');
            return $this->fetch('', [
                'types' => $types
            ]);
        }
    }
}