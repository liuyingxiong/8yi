<?php
namespace app\admin\controller;

use app\common\logic\UserLogic;

class User extends Base
{
    /**
     * 用户列表
     */
    public function list()
    {
        $p = input("param.p") ? input("param.p") : 1;
        $this->assign('p',$p);
        $userL = new UserLogic();
        $count = $userL -> getUsersCount();
        $page = adminPage($p,$count);
        $this->assign('page',$page);
        $users = $userL->getUsers([],"id desc",$p);
        $this->assign('users',$users);
        return $this->fetch();
    }

    /**
     * 删除用户
     */
    public function delUser()
    {
        if($this->request->isAjax()){
            $arr = input("post.id") ? input("post.id") : false;
            if($arr){
                $res = (new UserLogic())->delUser(['id'=>$arr]);
                return $res;
            }
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 获取用户电话详情
     */
    public function mobi_show()
    {
        if($this->request->isAjax()){
            $id = input("post.id") ? input("post.id") : false;
            if($id){
                // 获取用户信息
                $ret = (new UserLogic())->getUserInfo("id",$id);
                if(!empty($ret)){
                    return ret(1,"",$ret['mobile']);
                }
            }
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 用户详情页面
     */
    public function userdeta()
    {
        if($this->request->isAjax()){
            $id = input("post.id") ? input("post.id") : false;
            if(!$id){
                return ret(-1,"","参数错误");
            }
            $userInfo = (new UserLogic())->getUserInfo('id',$id);
            $this->assign('userInfo',$userInfo);
            return $this->fetch();
        }
        return ret(-1,"","参数错误");
    }
}
