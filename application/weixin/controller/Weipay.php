<?php
namespace app\weixin\controller;

use app\common\logic\OrderLogic;
use app\common\model\Order;
use sms\SendDemo;

class Weipay
{
    /**
     * 公众号支付
     * @param $openid string 会员唯一微信标示
     * @param $ip string 会员IP地址
     */
    public function jssdkweipay($openid,$out_trade_no,$money,$ip)
    {
        // 统一下单
        $wx_order = $this->unifiedOrder($openid,$out_trade_no,$money,$ip);
        $data = $chooseWXPay = [
            "timeStamp" => time(),                               // 支付签名时间戳，注意微信jssdk中的所有使用timestamp字段均为小写。但最新版的支付后台生成签名使用的timeStamp字段名需大写其中的S字符
            "nonceStr"  => getRandChar(32),              // 支付签名随机串，不长于 32 位
            "package"   => "prepay_id=".$wx_order['prepay_id'],  // 统一支付接口返回的prepay_id参数值，提交格式如：prepay_id=\*\*\*）
            "signType"  => "MD5",                                // 签名方式，默认为'SHA1'，使用新版支付需传入'MD5'
        ];
        $data['appId'] = config("weixin.appid");
        $chooseWXPay['paySign'] = $this->getSign($data);         // 支付签名
        return $chooseWXPay;
    }

    /**
     * 微信支付回调信息
     */
    public function notifyUrl()
    {
        // 获取返回的xml信息 并转换数组
        $fileContent = file_get_contents("php://input");
        $val = $this->Init($fileContent);

        // 数据
        $where = [
            'order_sn' => $val['out_trade_no'],  // 订单号
            'total' => $val['cash_fee']*1/100,         // 订单总价
        ];
        // 判断
        $orders = (new Order())->where($where)->find();
        if($orders){
            // 修改状态
            $data = [
                'delivery_state' => 1,
                'payment_state' => 1,
            ];
            $ret = (new OrderLogic())->modiOrderXitong($where,$data);
            if($ret){
                // 发送信息
                $start = mb_strlen($orders['address'],'utf-8')*1-10;
                $address = mb_substr($orders['address'], $start, 10, 'utf8');
                $txt = "已有新的订单[".$val['out_trade_no']."],支付金额[".$orders['total']."],送货地址[".$address."]";
                (new SendDemo())->send(config("smsname.admin_phone"),"",$txt);
                return $this->replyNotify();
            }
        }
        return "支付失败";
    }

    /**
     * 回复微信
     */
    private function replyNotify()
    {
        $data['return_code'] = 'SUCCESS';
        $data['return_msg'] = 'OK';
        $xml = $this->ToXml($data);
        return $xml;
    }

    /**
     * 统一下单
     * @param $openid string 用户唯一标示
     * @param $ip string     用户IP地址
     * @param $out_trade_no  string  订单号
     * @param 0  不必填   1  必填
     */
    private function unifiedOrder($openid,$out_trade_no,$money,$ip)
    {
        if($openid){
            $config = config("weixin");
            $data = [
                'appid' => $config['appid'],              // 公众账号ID
                'mch_id' => $config['mch_id'],            // 商户号
                'nonce_str' => getRandChar(32),   // 随机字符串
                'body' => $config['body'],                // 商品描述
                'out_trade_no' => $out_trade_no,          // 商户订单号
                'total_fee' => $money*100,                // 总金额    单位为分
                'spbill_create_ip' => $ip,                // 终端IP
                'notify_url' => "http://".$_SERVER['HTTP_HOST']."/weixin/Weipay/notifyUrl",  // 通知地址
                'trade_type' => $config['trade_type'],    // 交易类型
                'openid' => $openid,                      // 下单用户OPENID
            ];
            $data['sign'] = $this->getSign($data);        // 签名
            $xml = $this->ToXml($data);
            $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
            $ret = retCurl(2,$url,$xml);
            $ret = $this->Init($ret);
            return $ret;
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 支付签名
     * @param $data array
     * return string
     */
    private function getSign($data)
    {
        //签名步骤一：按字典序排序参数
        ksort($data);
        $stringA = $this->toUrlParams($data);
        //签名步骤二：在string后加入KEY
        $stringSignTemp = $stringA."&key=".config("weixin.key");
        //签名步骤三：MD5
        $sign = md5($stringSignTemp);
        //签名步骤四：所有字符转为大写
        $sign = strtoupper($sign);
        return $sign;
    }

     /*
      * 输出xml字符
      * @throws WxPayException
      */
     private function ToXml($data)
     {
         if(!is_array($data) || count($data) <= 0) {
             return ret(-1,"","数组数据异常！");
         }
         $xml = "<xml>";
         foreach ($data as $key=>$val) {
             if (is_numeric($val)){
                 $xml.="<".$key.">".$val."</".$key.">";
             }else{
                 $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
             }
         }
         $xml.="</xml>";
         return $xml;
     }

    /**
     * 将xml转为array
     * @param string $xml
     * throws WxPayException
     */
    private static function Init($xml)
    {
        libxml_disable_entity_loader(true);
        $xmlString = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $val = json_decode(json_encode($xmlString),true);
        return $val;
    }

    /*
     * 获取用户OPENID
     */
    public function getOpenid()
    {
        //获取code码
        $code = isset($_GET['code']) ? $_GET['code'] : false;
        if (!$code){
            //触发微信返回code码
            $baseUrl = urlencode('https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            $url = $this->__greateOauthUrlForCode($baseUrl);
            header("Location: ".$url);
            exit;
        }
        //获取openid
        $code = $_GET['code'];
        $openid = $this->getOpenidFromMp($code);
        return json_decode($openid,true);
    }

    /**
     * 构造获取code的url连接
     * @param $redirectUrl string 微信服务器回跳的url，需要url编码
     * @param $scope string  snsapi_base 不用授权   snsapi_userinfo 授权
     * return 返回构造好的url
     */
    private function __greateOauthUrlForCode($redirectUrl,$scope="snsapi_base")
    {
        $urlObj["appid"] = config("weixin.appid");
        $urlObj["redirect_uri"] = "$redirectUrl";
        $urlObj["response_type"] = "code";
        $urlObj["scope"] = $scope;
        $urlObj["state"] = "8yi2345"."#wechat_redirect";
        $bizString = $this->toUrlParams($urlObj);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
    }

    /**
     * 构造获取open和access_toke的url地址
     * @param $code string，微信跳转带回的code
     * return 请求的url
     */
    private function __CreateOauthUrlForOpenid($code)
    {
        $urlObj["appid"] = config("weixin.appid");
        $urlObj["secret"] = config("weixin.appsecret");
        $urlObj["code"] = $code;
        $urlObj["grant_type"] = "authorization_code";
        $bizString = $this->ToUrlParams($urlObj);
        return "https://api.weixin.qq.com/sns/oauth2/access_token?".$bizString;
    }

    /**
     * 通过code从工作平台获取openid机器access_token
     * @param $code string 微信跳转回来带上的code
     * return openid
     */
    private function GetOpenidFromMp($code)
    {
        $url = $this->__CreateOauthUrlForOpenid($code);
        return retCurl(1,$url);
        /*//初始化curl
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->curl_timeout);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        if(WxPayConfig::CURL_PROXY_HOST != "0.0.0.0"
            && WxPayConfig::CURL_PROXY_PORT != 0){
            curl_setopt($ch,CURLOPT_PROXY, WxPayConfig::CURL_PROXY_HOST);
            curl_setopt($ch,CURLOPT_PROXYPORT, WxPayConfig::CURL_PROXY_PORT);
        }
        //运行curl，结果以jason形式返回
        $res = curl_exec($ch);
        curl_close($ch);
        //取出openid
        $data = json_decode($res,true);
        $this->data = $data;
        $openid = $data['openid'];
        return $openid;*/
    }

    /**
     * 拼接签名字符串
     * @param $urlObj array
     * return 返回已经拼接好的字符串
     */
    private function toUrlParams($urlObj)
    {
        $buff = "";
        foreach ($urlObj as $k => $v)
        {
            if($k != "sign"){
                $buff .= $k . "=" . $v . "&";
            }
        }
        $buff = trim($buff, "&");
        return $buff;
    }
}
