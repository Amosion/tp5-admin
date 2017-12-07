<?php
/**
 * Created by PhpStorm.
 * User: Amadeus
 * Date: 2017/10/31
 * Time: 23:40
 */

namespace app\common\model;
use think\Model;

class BaseModel extends Model
{
    protected $autoWriteTimestamp = true;
    public function add($data){
        $data['status'] = 0;
        $this->save($data);
        return $this->id;
    }

    public function updateById($data,$id){
        return $this->allowField(true)->save($data,['id'=>$id]);
    }

}