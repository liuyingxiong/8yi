<?php
namespace app\mobile\controller;
use app\common\logic\ComLogic;
use app\common\logic\UserLogic;
use app\weixin\controller\Index as WX_Index;
use think\Controller;

class Base extends Controller
{
    /*
    * 初始化操作
    */
    public function _initialize()
    {
        // 手机浏览器
//        if(!isMobile()){
//            $this->redirect("Home/Index/index");
//        }
//        // 微信浏览器
//        if(!isWeiXin()){
//            $this->redirect("Home/Index/prompt");
//        }
//        // 获取登陆后记录的用户信息
//        $user = session("user");
//        if(!$user){
//            $this->clearLogin();
//            exit;
//        }
//        // 判断数据库里面有没有数据 有 更新SESSION
//        $userInfo = (new UserLogic())->getUserInfo('id',$user['id']);
//        if(!$userInfo){
//            $this->clearLogin();
//            exit;
//        }
//        session("user",$userInfo);
//        $this->assign('user',$userInfo);


        /**
         * 本地测试的时候开启
         */
        #############
        $userInfo = (new UserLogic())->getUserInfo('id','120');
        session("user",$userInfo);
        $this->assign('user',$userInfo);
        #############
    }

    /**
     * 清除session 重新授权登陆
     */
    protected function clearLogin()
    {
        session("user",null);
        (new WX_Index())->wxGrantOne();
        exit;
    }

    /**
     * 返回上一页
     * @param $txt string
     */
    protected function errorJQ($txt,$time=3000)
    {
        echo "<style>.layui-layer-msg{min-width: 50%!important;padding: 20px 25px!important;}.layui-layer-hui .layui-layer-content{padding: 20px 40px!important;}.layui-layer-dialog .layui-layer-content{font-size: 2rem!important; line-height: 2.5rem!important;}</style>";
        echo "<script type='text/javascript' src='/public/static/common/js/jquery-1.8.3.min.js'></script>";
        echo "<script type='text/javascript' src='/public/static/common/layer/layer.js'></script>";
        echo "<script>
                   layer.msg('".$txt."',{time:$time});
                   setInterval(function(){
                        window.history.go(-1);
                   },$time)
              </script>";
        exit;
    }

    /**
     * 消息推送数字
     */
    protected function getTotalNum()
    {
        $user = session("user");
        $lastTime = !empty($user["message_time"]) ? $user["message_time"] : 0;
        $where = [
            "create_time" => ["between",[$lastTime,time()]],
        ];
        $comNum = (new ComLogic())->getCount($where);
        //获取其他用户对当前用户回复总条数
        $where["t.addtime"] = $where["create_time"];
        $where["c.uid"] = $user["id"];
        unset($where["create_time"]);
        $comTextNum = (new ComLogic())->getComTextCount($where);
        $totalNum = $comNum + $comTextNum;
        $this->assign("com_number",$totalNum);
    }
}
