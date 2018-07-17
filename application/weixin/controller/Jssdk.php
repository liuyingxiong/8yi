<?php
namespace app\weixin\controller;

use app\common\logic\ConfigLogic;
use app\common\model\Config;

class Jssdk{
    private $appId;
    private $appSecret;
    private $jsApiList;

    public function __construct()
    {
        $config = config("weixin");
        $this->appId = $config['appid'];
        $this->appSecret = $config['appsecret'];
        $this->jsApiList = "'chooseWXPay','hideAllNonBaseMenuItem'";
    }

    /**
     * 微信接口配置
     * @param $debug true 开启调试 || false 关闭调试
     * @return array
     */
    public function getSignPackage()
    {
        $timestamp = time();                        // 生成签名的时间戳
        $nonceStr = $this->createNonceStr();        // 生成随机签名
        $jsapiTicket = $this->getJsApiTicket();     // 获取临时票据

        // 注意 URL 一定要动态获取，不能 hardcode.
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
        $signature = sha1($string);

        $signPackage = array(
            "appId"     => $this->appId,
            "timestamp" => $timestamp,
            "nonceStr"  => $nonceStr,
            "signature" => $signature,
            "jsApiList" => $this->jsApiList
        );
        return $signPackage;
    }

    /**
     * 生成签名的随机串
     * @param int $length
     * @return string
     */
    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /**
     * jsapi_ticket是公众号用于调用微信JS接口的临时票据
     * 时间7200秒
     * @return mixed
     */
    private function getJsApiTicket() {
        // 获取服务器上面的jsapi_ticket
        $configM = new Config();
        $ret = $configM->where("name","jsapi_ticket")->find();
        $ret = json_decode($ret['value'],true);
        if(!$ret || $ret['endtime'] < time()){
            $accessToken = $this->getAccessToken();
            // 如果是企业号用以下 URL 获取 ticket
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
            $res = json_decode(retCurl(1,$url),true);
            $ticket = $res['ticket'];
            if ($ticket) {
                $data = array(
                    'jsapi_ticket' => $ticket,
                    'endtime' => time()+7000,
                );
                if(!$ret){
                    $add = array(
                        "name"     => "jsapi_ticket",
                        "value"    => json_encode($data),
                        "inc_type" => "weixin",
                        "desc"     => "微信JSSDK接口jsapiTicket临时票据"
                    );
                    $configM->insert($add);
                }else{
                    $update = array(
                        "value"    => json_encode($data)
                    );
                    (new ConfigLogic())->configUpdate($update,"name","jsapi_ticket");
                }
            }
        } else {
            $ticket = $ret['jsapi_ticket'];
        }
        return $ticket;
    }

    /**
     * 获取AccessToken
     * 时间7200秒
     * @return mixed
     */
    private function getAccessToken() {
        $configM = new Config();
        $ret = $configM->where("name","access_token")->find();
        $ret = json_decode($ret['value'],true);
        if(!$ret || $ret['endtime'] < time()){
            // 如果是企业号用以下URL获取access_token
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
            //$res = json_decode($this->httpGet($url));
            $res = json_decode(retCurl(1,$url),true);
            $access_token = $res['access_token'];
            if ($access_token) {
                $data = array(
                    'access_token' => $access_token,
                    'endtime' => time()+7000,
                );
                if(!$ret){
                    $add = array(
                        "name"     => "access_token",
                        "value"    => json_encode($data),
                        "inc_type" => "weixin",
                        "desc"     => "微信JSSDK接口AccessToken"
                    );
                    $configM->insert($add);
                }else{
                    $update = array(
                        "value"    => json_encode($data)
                    );
                    (new ConfigLogic())->configUpdate($update,"name","access_token");
                }
            }
        } else {
            $access_token = $ret['access_token'];
        }
        return $access_token;
    }
}

