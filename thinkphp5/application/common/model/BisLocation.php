<?php
/**
 * Created by PhpStorm.
 * User: Amadeus
 * Date: 2017/10/29
 * Time: 23:22
 */

namespace app\common\model;
use think\Model;

class BisLocation extends Model
{
    protected $autoWriteTimestamp = true;
    public function add($data){
        $data['status'] = 0;
        $this->save($data);
        return $this->id;
    }

}