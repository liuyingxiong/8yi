<?php
namespace app\weixin\controller;

use app\common\logic\ConfigLogic;
use app\common\logic\LoginLogLogic;
use app\common\model\User;
use think\Controller;

class Index extends Controller
{
    /**
     * 微信公众号服务器配置
     * 要修改微信公众号服务器配置的时候直接注释第一行就行了
     */
    public function index()
    {
        return msgJson("-1","","接口关闭");
        // 获取微信服务器传的参数
        $signature = $_GET['signature'];  // 微信加密签名，signature结合了开发者填写的token参数和请求中的timestamp参数、nonce参数。
        $timestamp = $_GET['timestamp'];  // 时间戳
        $nonce = $_GET['nonce'];          // 随机数
        $echostr = $_GET['echostr'];      // 随机字符串 确认此次GET请求来自微信服务器，请原样返回参数内容
        // 设置 token 的值
        $token = '20180608Ljlm23451030';  // token值
        // 将token、timestamp、nonce三个参数进行字典序排序并拼接成字符串sha1加密
        $tmpArr = [$token,$timestamp,$nonce];
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        // 返回参数
        if($signature === $tmpStr){
            return $echostr;
        }else{
            return false;
        }
    }

    /**
     * 微信自定义菜单配置
     */
    public function wx_button()
    {
        return msgJson("-1","","接口关闭");
        // 获取token
        $access_token = (new ConfigLogic())->getAccessToken();
        // 设置参数
        $data = array(
            'button' => array(
                /*array(
                    'name'=>'APP二维码',
                    'sub_button'=> array(
                        array(
                            "name"=>"Android",
                            "type"=>"click",
                            "key"=>"安卓二维码图片"
                        ),
                        array(
                            "name"=>"IOS",
                            "type"=>"click",
                            "key"=>"IOS二维码图片"
                        )
                    )
                ),*/
                array(
                    "name"=>"官网",
                    "type"=>"view",
                    "url"=>"http://www.8yi2345.com/mobile"
                )
            )
        );
        $data = json_encode($data,JSON_UNESCAPED_UNICODE);
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
        // 创建菜单
        $arr = retCurl(2,$url,$data);
        $arr = json_decode($arr,true);
        if($arr['errcode'] == 0){
            return "自定义菜单建立成功！";
        }else{
            return "失败！";
        }
    }

    /**
     * 微信授权 一
     */
    public function wxGrantOne()
    {
        $config = config("weixin");
        $redirect_uri = urlencode("http://www.8yi2345.com/weixin/Index/GetWxUserInfo");  // 授权后重定向的回调链接地址
        $scope = "snsapi_userinfo";  // snsapi_base 不用授权  snsapi_userinfo 授权
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$config['appid']."&redirect_uri=".$redirect_uri."&response_type=code&scope=".$scope."&state=8yi2345#wechat_redirect";
        header("Location:".$url);
    }

    /**
     * 微信授权 二
     */
    public function GetWxUserInfo()
    {
        $arr = $_GET;
        if(isset($arr['code']) && $arr['code'] && $arr['state'] == "8yi2345") {
            // 获取网页授权的token值
            $config = config("weixin");
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $config['appid'] . "&secret=" . $config['appsecret'] . "&code=" . $arr['code'] . "&grant_type=authorization_code";
            $data = retCurl(1, $url);
            $data = json_decode($data,true);
            if(isset($data['access_token']) && $data['access_token']){
                $arr = $this->wxRegister($data['access_token'],$data['openid']);
                if(isset($arr['ret']) && $arr['ret'] == 1){
                    // 记录用户登陆日记
                    (new LoginLogLogic())->addLoginLog(1,$arr['code'],date("Y-m-d H-i-s",time())."微信登陆","微信登陆");
                    $this->redirect("Mobile/Index/index");
                }
            }
        }
        return ret(-1,"","请授权登陆");
    }

    /**
     * 注册登陆
     * @param access_token
     * @param openid
     */
    protected function wxRegister($access_token,$openid)
    {
        if($access_token && $openid){
            $userM = new User();
            $user = $userM->where("wx_openid",$openid) -> find();
            if(!$user){
                // 微信注册账号  -- 获取微信用户信息
                $url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
                $dataTwo = retCurl(1,$url);
                $dataTwo = json_decode($dataTwo,true);
                if(isset($dataTwo['errcode'])){
                    return ret(-1,$dataTwo['errcode'],$dataTwo['errmsg']);
                }
                $user = array(
                    'id_card' => "",
                    'nickname' => $dataTwo['nickname'],
                    'mobile' => "",
                    'password' => "",
                    'email' => '',
                    'real_name' => '',
                    'sex' => $dataTwo['sex'],
                    'age' => "",
                    'photo' => $dataTwo['headimgurl'],
                    'addtime' => time(),
                    'state' => 5,
                    'wx_openid' => $dataTwo['openid'],
                );
                $number = $userM->insertGetId($user);
                if(!$number){
                    return ret(-1,"","微信注册失败");
                }
                $user['id'] = $number;
                $msg = "微信注册成功";
            }else{
                $msg = "";
            }
            session("user",$user);
            return ret(1,$user['id'],$msg);
        }
        return msgJson(-1,"","参数错误");
    }
}
