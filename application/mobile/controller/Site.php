<?php
namespace app\mobile\controller;

use app\common\logic\AreaLogic;
use app\common\logic\UserSiteLogic;

class Site extends Base
{
    protected function user()
    {
        return session("user");
    }
    /**
     * 收货地址列表
     */
    public function list()
    {
        $user = $this->user();
        // 获取所有的地址
        $site = (new UserSiteLogic())->getSite($user['id'],0);
        $this->assign('site',$site);
        // 获取参数
        $title = input("param.title") ? input("param.title") : "我的地址";
        $this->assign('title',$title);
        $getId = input("param.site_id");
        $this->assign('getId',$getId);
        return $this->fetch();
    }

    /**
     * 新增收货地址
     */
    public function addsite()
    {
        // 获取参数
        $arr = input("param.") ? input("param.") : false;
        $this->assign('title',$arr ? $arr['title'] : "添加地址");
        $areaM = new AreaLogic();
        if($arr){
            // 获取收货地址
            $site = (new UserSiteLogic())->getSiteFind(['id'=>$arr['site_id']]);
            $this->assign('site',$site);
            //$province = $areaM->getArea('area_deep',1);
            $province = $areaM->getArea('area_id',32);
            if($site['zone']){
                $zone = explode(',', $site['zone']);
                $this->assign('zone',$zone);
                $city = $areaM->getArea('area_parent_id',$zone[0]);
                $county = $areaM->getArea('area_parent_id',$zone[1]);
            }else{
                $city = $areaM->getArea('area_parent_id',$province[0]['area_id']);
                $county = $areaM->getArea('area_parent_id',$city[0]['area_id']);
            }
        }else{
            //$province = $areaM->getArea('area_deep',1);
            $province = $areaM->getArea('area_id',32);
            $city = $areaM->getArea('area_parent_id',$province[0]['area_id']);
            $county = $areaM->getArea('area_parent_id',$city[0]['area_id']);
        }
        $this->assign('province',$province);
        $this->assign('city',$city);
        $this->assign('county',$county);
        return $this->fetch();
    }

    /**
     * 新增收货地址
     * AJAX提交
     */
    public function ajaxadd()
    {
        if($this->request->isAjax()){
            $arr = input("post.") ? input("post.") : false;
            if($arr){
                $user = $this->user();
                $ret = (new UserSiteLogic())->addSite($user['id'],$arr);
                if($ret){
                    return ret(1,"","新增成功");
                }
            }

        }
        return ret(-1,"","参数错误");
    }

    /**
     * 收货地址修改
     * AJAX提交
     */
    public function ajaxmodify()
    {
        if($this->request->isAjax()){
            $arr = input("post.") ? input("post.") : false;
            if($arr){
                $user = $this->user();
                $ret = (new UserSiteLogic())->modifySite($user['id'],$arr);
                if($ret){
                    return ret(1,"","修改成功");
                }
            }

        }
        return ret(-1,"","参数错误");
    }

    /**
     * 会员收货地址默认修改
     * AJAX提交
     */
    public function ajaxdefa()
    {
        if($this->request->isAjax()){
            $id = input("post.id") ? input("post.id") : false;
            if($id){
                $user = $this->user();
                $ret = (new UserSiteLogic())->defaSite($user['id'],$id);
                if($ret){
                    return ret(1,"","修改默认收货地址成功");
                }
            }
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 删除收货地址
     * AJAX提交
     */
    public function ajaxdel()
    {
        if($this->request->isAjax()){
            $id = input("post.id") ? input("post.id") : false;
            if($id){
                $ret = (new UserSiteLogic())->delSite(['id'=>$id]);
                if($ret){
                    return ret(1,"","删除成功");
                }
            }
        }
        return ret(-1,"","参数错误");
    }


}
