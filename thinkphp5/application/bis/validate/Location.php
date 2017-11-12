<?php
/**
 * Created by PhpStorm.
 * User: Amadeus
 * Date: 2017/11/8
 * Time: 23:57
 */
namespace app\bis\validate;
use think\Validate;
class Location extends Validate
{
    protected $rule = [
        'name' => 'require|max:25',
        'logo' => 'require',
        'city_id' => 'require',

    ];
    //场景设置
    protected $scene =[
        'add' => ['name','logo','city_id'],    //添加
    ];

}