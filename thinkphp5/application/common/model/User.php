<?php
/**
 * Created by PhpStorm.
 * User: Amadeus
 * Date: 2017/11/24
 * Time: 17:00
 */

namespace app\common\model;


class User extends BaseModel
{
    /**
     * 添加用户
     * @param array $data
     * @return false|int
     */
    public function add($data = []){
        if(!is_array($data)){
            exception('传递的数据不是数组');
        }
        $data['status'] = 1;
        return $this->data($data)->allowField(true)
            ->save();
    }

    public function getUserByUsername($username){
        if(!$username){
            exception('用户名不合法');
        }
        $data = ['username' => $username];
        return $this->where($data)->find();

    }
}