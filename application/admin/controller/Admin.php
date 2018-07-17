<?php
namespace app\admin\controller;

use app\common\logic\AdminUserLogic;
use think\Db;

class Admin extends Base
{
    /**
     * 管理者列表
     */
    public function list()
    {
        // 获取参数
        $p = input("param.p") ? input("param.p") : 1;
        $this->assign('p',$p);
        $adminUserM = new AdminUserLogic();
        $count = $adminUserM -> getAdminCount();
        $page = adminPage($p,$count);
        $this->assign('page',$page);
        // 获取所有的管理者
        $adminList = $adminUserM->getAdminSelect([],"*",$p);
        $this->assign('adminlist',$adminList);
        return $this->fetch();
    }

    /**
     * 管理者删除功能
     */
    public function del()
    {
        if($this->request->isAjax()){
            $admin_id = input("post.admin_id") ? input("post.admin_id") : false;
            $admin_username = input("post.adminusername") ? input("post.adminusername") : false;
            if(!$admin_id || !$admin_username || $admin_id == 1 || $admin_username == "admin"){
                return ret(-1,"","参数错误");
            }
            $adminInfo = session("adminInfo");
            $res = (new AdminUserLogic())->delAdmin(['id'=>$admin_id],"管理者【".$adminInfo['username']."】删除管理账号【".$admin_username."】",$adminInfo['id'],$this->request->ip());
            return $res;
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 管理者账号密码修改
     */
    public function modify()
    {
        if($this->request->isAjax()){
            $arr = input("post.") ? input("post.") : false;
            if($arr){
                $res = (new AdminUserLogic())->modifyPassAdmin($arr,$this->request->ip());
                return $res;
            }
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 管理者添加页面
     */
    public function add()
    {
        return $this->fetch();
    }

    /**
     * 管理者添加
     */
    public function addAjax()
    {
        if($this->request->isAjax()){
            $arr = input("post.") ? input("post.") : false;
            if($arr){
                $ret = (new AdminUserLogic())->addAdmin($arr,$this->request->ip());
                return $ret;
            }
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 临时
     *//*
    public function temp()
    {
        return $this->fetch();
    }*/
}
