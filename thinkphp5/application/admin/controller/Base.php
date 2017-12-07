<?php
/**
 * Created by PhpStorm.
 * User: Amadeus
 * Date: 2017/11/21
 * Time: 19:49
 */

namespace app\admin\Controller;
use think\Controller;

class Base extends Controller
{
    /**
     * 修改状态
     */
    public function status(){
        $data = input('get.');
        //利用tp5 validate 去做严格检验  id  status

        if(empty($data['status'])){
            $this->error('status不合法');
        }
        if(empty($data['id'])){
            $this->error('id不合法');
        }
        //设置控制器
        $model = request()->controller();

        $res = model($model)->save(['status' => $data['status']],['id' => $data['id']]);
        if($res){
            $this->success('更新成功');
        }else{
            $this->error('更新失败');
        }
    }

    //排序功能
}