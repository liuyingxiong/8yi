<?php
namespace app\home\controller;

use app\common\logic\VerifyCodeLogic;
use sms\SendDemo;

class Index extends Base
{
    /**
     * 官网首页
     */
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 提示页面
     */
    public function prompt()
    {
        return $this->fetch();
    }

    /**
     * 临时测试
     *//*
    public function test()
    {
        //接受短信的手机号码
        $phone     = '15696109391';
        //短信内容(【签名】+短信内容)，系统提供的测试签名和内容，如需要发送自己的短信内容请在启瑞云平台申请签名和模板
        $content   = "已有新的订单【".rand(1000,9999)."】，请管理人员登录后台查看并安排人员送货";

        $sms = new SendDemo();
        $result = $sms->send($phone, "", $content);
        print_r($result );
    }*/
}
