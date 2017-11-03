<?php
namespace app\bis\controller;

use app\common\model\BisAccount;
use think\Controller;
use think\Model;

class Register extends Controller
{
    public function index(){
        //获取一级城市数据
        $citys = model('City')->getNormalCitysByParentId();
        $categorys = model('Category')->getNormalCategoryByParentId();
        return $this->fetch('',[
           'citys' => $citys,
            'categorys' => $categorys
        ]);
    }

    public function add(){
        if(!request()->isPost()){
            $this->error('请求错误');
        }
        //获取表单的值
        $data = input('post.');
        //检验数据
        $validate = validate('Bis');
        if(!$validate->scene('add')->check($data)){
            $this->error($validate->getError());
        }

        //获取经纬度

        $Lnglat = \Map::getLnglat($data['address']);
        if(empty($Lnglat) || $Lnglat['status'] !=0 || $Lnglat['result']['precise'] !=1){
            //$this->error('无法获取数据，或者匹配地址不准确');
        }

        //判定提交用户是否存在
        $accountResult = model('BisAccount')->get(['username' => $data['username']]);
        if($accountResult){
            $this->error('该用户已存在');
        }

        //商户基本信息入库
        $bisData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'logo' => $data['logo'],
            'licence_logo' => $data['licence_logo'],
            'city_id' => $data['city_id'],
            'city_path' => empty($data['se_city_id']) ? $data['city_id']:$data['city_id'].','.$data['se_city_id'],
            'description' => empty($data['description']) ? '':$data['description'],
            'bank_info' => $data['bank_info'],
            'bank_name' => $data['bank_name'],
            'bank_user' => $data['bank_user'],
            'faren' => $data['faren'],
            'faren_tel' => $data['faren_tel'],
        ];
        $bisId = model('Bis')->add($bisData);
        //总店相关信息校验
        $data['cat'] = '';
        if(!empty($data['se_category_id'])){
            $data['cat'] = implode('|',$data['se_category_id']);
        }

        //总店相关信息入库
        $locationData = [
            'bis_id' => $bisId,
            'name' => $data['name'],
            'tel' => $data['tel'],
            'contact' => $data['contact'],
            'category_id' => $data['category_id'],
            'category_path' => $data['category_id'].','.$data['cat'],
            'city_id' => $data['city_id'],
            'city_path' => empty($data['se_city_id']) ? $data['city_id']:$data['city_id'].','.$data['se_city_id'],
            'address' => $data['address'],
            'open_time' => $data['open_time'],
            'content' => empty($data['content']) ? '':$data['content'],
            'is_main' => 1,//代表总店信息
            'xpoint' => empty($Lnglat['result']['location']['lng']) ? '':$Lnglat['result']['location']['lng'],
            'ypoint' => empty($Lnglat['result']['location']['lat']) ? '':$Lnglat['result']['location']['lat'],

        ];
        $locationId = model('BisLocation')->add($locationData);

        //账户相关信息校验
        //自动生成密码的校验字符串
        $data['code'] = mt_rand(100,10000);
        $accountData = [
            'bis_id' => $bisId,
            'username' => $data['username'],
            'code' => $data['code'],
            'password' => md5($data['password'].$data['code']),
            'is_main' => 1, //代表总管理员
        ];
        $accountId = model('BisAccount')->add($accountData);
        if(!$accountId){
            $this->error('申请失败');
        }

        //发送邮件
        $url = request()->domain().url('bis/register/waiting',['id' => $bisId]);
        $title = "O2O商家入驻申请";
        $content = "你提交的入驻申请需等待平台审核，你可以通过点击链接<a href='".$url."' target='_blank'>查看</a>查看审核状态";
        //\PHPMailer\Email::sendMail($data['email'],$title,$content);

        $this->success('申请成功',url('register/waiting',['id' => $bisId]));
    }

    public function waiting($id){
        if(empty($id)){
            $this->error('id为空');
        }
        $detail = model('Bis')->get($id);
        return $this->fetch('',[
            'detail' => $detail
        ]);
    }
}