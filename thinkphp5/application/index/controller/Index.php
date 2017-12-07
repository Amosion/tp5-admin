<?php
namespace app\index\controller;
use think\Controller;

class Index extends Base
{
    public function index()
    {
        // 商品分类 数据-magic 推荐的数据
        $datas = model('Deal')->getNormalDealByCategoryCityId(1,$this->city->id);
        //huo qu 4 ge zi fenlei
        $meishicates =  model('Category')->getNormalRecommendCategoryByParentId(1,4);
        return $this->fetch('',[
            'datas' => $datas,
            'meishicates' => $meishicates,
            'controller' => 'ms'
        ]);
    }
}