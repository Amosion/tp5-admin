<?php
/**
 * Created by PhpStorm.
 * User: Amadeus
 * Date: 2017/11/2
 * Time: 23:36
 */

namespace app\admin\Controller;
use think\Controller;

class Bis extends Controller
{
    private $obj;
    public function _initialize(){
        $this -> obj = model('Bis');
    }

    /**
     * 商户入驻申请成功列表
     */
    public function index(){
        $bis = $this->obj->getBisByStatus(1);
        return $this->fetch('',[
            'bis' => $bis
        ]);

    }
    /**
     * 入驻申请列表
     */
    public function apply(){
        $bis = $this->obj->getBisByStatus();
        return $this->fetch('',[
            'bis' => $bis
        ]);

    }

    /**
     * 商家申请详情查看
     * @return mixed
     */
    public function detail(){
        $id = input('get.id');
        if(empty($id)){
            $this->error('id为空');
        }
        //获取一级城市数据
        $citys = model('City')->getNormalCitysByParentId();
        //获取一级栏目数据
        $categorys = model('Category')->getNormalCategoryByParentId();
        //获取商户数据
        $bisData = model('Bis')->get($id);
        $locationData= model('BisLocation')->get(['bis_id' => $id, 'is_main' => 1]);
        $accountData= model('BisAccount')->get(['bis_id' => $id, 'is_main' => 1]);

        return $this->fetch('',[
            'citys' => $citys,
            'categorys' => $categorys,
            'bisData' => $bisData,
            'locationData' => $locationData,
            'accountData' => $accountData
        ]);

    }

    /**
     * 修改状态
     */
    public function status(){
        $data = input('get.');

        $validate = validate('Bis');
        if(!$validate -> scene('status') -> check($data)) {
            $this -> error($validate->getError());
        }

        $res = $this->obj->save(['status' => $data['status']], ['id' => $data['id']]);
        $location = model('BisLocation')->save(['status' => $data['status']], ['bis_id' => $data['id'],'is_main' => 1]);
        $account = model('BisAccount')->save(['status' => $data['status']], ['bis_id' => $data['id'],'is_main' => 1]);
        if($res && $location && $account){
            $this->success('状态更新成功');
        }else {
            $this->error('状态更新失败');
        }
    }
}