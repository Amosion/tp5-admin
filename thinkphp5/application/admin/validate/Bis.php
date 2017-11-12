<?php
namespace app\admin\validate;
use think\Validate;
Class Bis extends Validate {
    protected $rule = [
        ['name', 'require|max:10', '名字必须传递|名字不能超过10字符'],
        ['parent_id', 'number'],
        ['id', 'number'],
        ['status', 'number|in:-1,0,1', '状态必须是数字|状态范围不合法'],
        ['listorder', 'number'],
    ];
    //场景设置
    protected $scene =[
        'add' => ['name', 'parent_id','id'],      //添加
        'listorder' => ['id', 'listorder'],  //排序
        'status' => ['status','id'],
    ];
}
