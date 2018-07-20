<?php
namespace app\admin\controller;

use app\common\logic\AdminUserLogic;
use app\common\logic\AuthLogic;
use app\common\logic\RoleLogic;
use think\Db;
use think\Request;

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

    //角色列表管理
    public function role_list()
    {
        $p = input('param.p') ? input('param.p') : 1;
        $this->assign('p',$p);
        $roleM = new RoleLogic();
        $count = $roleM->getRoleCount();
        $page = adminPage($p,$count);
        $this->assign('page',$page);
        $roleList = $roleM->getRoleList([],"id desc",$p);
        $this->assign('roleList',$roleList);
        return $this->fetch();
    }

    //角色添加页面
    public function role_add()
    {
        return $this->fetch();
    }

    //角色添加管理
    public function addRole()
    {
        if ($this->request->isAjax()){
            $data = input('post.') ? input('post.') : false;
            $role = (new RoleLogic())->getRoleInfo($data);
            if(!empty($role)){
                return ret(-1,"","该角色已添加");
            }
            (new RoleLogic())->addRole($data);
            return ret(1,"","添加成功");
        }
        return ret(-1,"","添加失败");
    }

    //角色删除
    public function del_role()
    {
        if($this->request->isAjax()){
            $data = input('post.') ? input('post.') : false;
            (new RoleLogic())->delRole($data);
            return ret(1,"","角色删除成功");
        }
        return ret(-1,"","角色删除失败");
    }

    /**
     * 权限管理列表
     */
    public function auth_list()
    {
        $p = input('param.p') ? input('param.p') : 1;
        $this->assign('p',$p);
        $authM = new AuthLogic();
        $count = $authM->getAuthCount();
        $page = adminPage($p,$count);
        $this->assign('page',$page);
        $authList = $authM->authList([],"id desc",$p);
        $this->assign('authList',$authList);
        return $this->fetch();
    }

    /**
     * 权限添加页面
     */
    public function auth_add()
    {
        $authM = new AuthLogic();
        $authList = $authM->authList([],"id ASC and uid ASC");
        $authUid = $authList;
        foreach ($authList as $k => $item){
            $alias = '';
            for ($i = 0;$i <= $item['uid'];$i++){
                $alias .= "--";
            }
            $authUid[$k]['aliasname'] = $alias.$item['name'];
        }
        $this->assign('authUid',$authUid);
        return $this->fetch();
    }

    /**
     * 添加权限
     */
    public function addAuth()
    {
        if ($this->request->isAjax()){
            $data = input('post.') ? input('post.') : false;
            $auth = (new AuthLogic())->getAuth($data);
            if (!empty($auth)){
                return ret(-1,'',"此权限已添加");
            }
            (new AuthLogic())->addAuth($data);
            return ret(1,"","添加成功");
        }
        return ret(-1,"","添加失败");
    }

    /**
     * 编辑权限
     */
    public function auth_edit()
    {
        $authM = new AuthLogic();
        $authList = $authM->authList([],"id ASC and uid ASC");
        $authUid = $authList;
        foreach ($authList as $k => $item){
            $alias = '';
            for ($i = 0;$i <= $item['uid'];$i++){
                $alias .= "--";
            }
            $authUid[$k]['aliasname'] = $alias.$item['name'];
        }
        $this->assign('authUid',$authUid);
        if ($this->request->isAjax()){
            $data = input('param.i') ? input('param.i') : false;
            $auth = $authM->getAuth(["id"=>$data]);
            $this->assign('auth',$auth);
            return $this->fetch();
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 删除权限
     */
    public function delAuth()
    {
        if($this->request->isAjax()){
            $data = input('post.') ? input('post.') : false;
            (new AuthLogic())->delAuth($data);
            return ret(1,"","角色删除成功");
        }
        return ret(-1,"","角色删除失败");
    }
}
