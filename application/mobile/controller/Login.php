<?php
namespace app\mobile\controller;

use app\common\logic\ConfigLogic;

class Login extends Base
{
    /**
     *
     */
    public function index()
    {

    }

    /**
     * 登陆接口
     */
    public function login()
    {
        /*// 获取接收的数据
        $mobile = input("post.mobile") ? input("post.mobile") : false;
        $pass = input("post.password") ? input("post.password") : false;
        if($mobile && $pass){
            $ret = (new ConfigLogic()) -> login($mobile,$pass);
            return $ret;
        }
        return msgJson(0,"","账号或者密码错误");*/
    }
}
