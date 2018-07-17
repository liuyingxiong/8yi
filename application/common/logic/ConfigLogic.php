<?php

namespace app\common\logic;

use app\common\model\Config;
use think\Model;

class ConfigLogic extends Model
{
    /**
     * 获取微信公众号access_token
     * @param $aid 微信公众号唯一ID
     * @param $secret 微信公众号密码
     */
    protected function getToken($aid,$secret)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$aid."&secret=".$secret;
        $arr = retCurl(1,$url);
        $arr = json_decode($arr,true);
        if($arr['access_token']){
            return $arr['access_token'];
        }else{
            $this->getToken($aid,$secret);
        }
    }

    /**
     * 外部获取微信公众号 ACCESS_TOKEN
     */
    public function getAccessToken()
    {
        // 获取微信config
        $config = new Config();
        $configToken = $config->where("name","wx_token") -> find();
        $val = json_decode($configToken['value'],true);
        if(empty($val['access_token']) || $val['end_time'] <= time()){
            $appId = empty($val['appid']) ? config("weixin.appid") : $val['appid'];
            $appSecret = empty($val['appsecret']) ? config("weixin.appsecret") : $val['appsecret'];
            $val['access_token'] = $this->getToken($appId,$appSecret);
            $val['end_time'] = time() + 6000;
            if(empty($configToken)){
                $data = [
                    'name' => 'wx_token',
                    'inc_type' => 'weixin',
                    'desc' => '微信公众开发获取用户授权AccessToken',
                    'value' => json_encode($val),
                ];
                $this->configAdd($data);
            }else{
                $this -> configUpdate(["value"=>json_encode($val)],"name","wx_token");
            }
        }
        return $val['access_token'];
    }

    /**
     * 增加数据
     * @param $data
     */
    public function configAdd($data)
    {
        if($data){
            $number = (new Config())->insert($data);
            if($number){
                return $number;
            }else{
                return false;
            }
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 条件修改数据
     * @param $data
     * @param $name 列表名
     * @param $value 条件
     */
    public function configUpdate($data,$name,$value)
    {
        $number =  (new Config()) -> where($name,$value)->update($data);
        if($number){
            return $number;
        }else{
            $this->configUpdate($data,$name,$value);
        }
    }

    /**
     * 账号密码登陆
     * @param $mobile
     * @param $pass
     */
    public function login($mobile,$pass)
    {
        $field = "id as uid,id_card,nickname,email,real_name,sex,age,photo,addtime，state";
        $where = [
            "mobile" => $mobile,
            "pass" => large(encry($pass)),
        ];
        $userInfo = (new Config()) -> field($field) -> where($where) -> find();
        if($userInfo){
            // 记录登陆日记
            return (new LoginLogLogic())->addLoginLog(1,$userInfo['uid'],date("Y-m-d H-i-s",time())."登陆","手机端");
        }
        return ['ret'=>0,"msg"=>"账号或者密码错误"];
    }
}