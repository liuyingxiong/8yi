<?php
namespace app\admin\controller;

use app\common\logic\AdminLogLogic;
use app\common\logic\AdminUserLogic;
use think\Controller;

class Login extends Controller
{
    /**
     * 后台管理登陆
     */
    public function index()
    {
        if(session('adminInfo') && cookie("adminInfo")){
            $this->redirect("Index/index");
        }
        if($this->request->isAjax()){
            $arr = input("post.") ? input("post.") : false;
            if(isset($arr['username']) && isset($arr['password'])){
                $filed = ['username','password'];
                $value = [$arr['username'],encryTwo($arr['password'])];
                $adminInfo = (new AdminUserLogic())->getAdminInfo($filed,$value);
                if((isset($adminInfo['ret']) && $adminInfo['ret'] == -1) || $adminInfo == null){
                    return msgJson(-1,"","账号或者密码错误");
                }
                $adminInfo = json_decode($adminInfo,true);
                session('adminInfo',$adminInfo);
                cookie('adminInfo', $adminInfo, 3600);

                // 管理账号记录日记
                $ip = $this->request->ip();
                $adminId = $adminInfo['id'];
                $adminName = $adminInfo['username'];
                (new AdminLogLogic()) -> loginLog($adminId,$adminName,$ip);
                return msgJson(1,"","账号或者密码错误");
            }
            return msgJson(-1,"","账号或者密码错误");
        }
        return $this->fetch();
    }

    /**
     * 后台退出功能
     */
    public function logOut()
    {
        session("adminInfo",null);
        cookie('adminInfo', null);
        $this->redirect('Login/index');
    }
}
