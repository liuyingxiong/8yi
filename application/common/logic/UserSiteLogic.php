<?php

namespace app\common\logic;

use app\common\model\UserSite;
use think\Db;
use think\Model;

class UserSiteLogic extends Model
{
    /**
     * 获取送货地址
     * @param $uid
     * @param $type int 1 : 默认地址  其它：全部地址
     */
    public function getSite($uid,$type=1)
    {
        switch ($type)
        {
            case 1:
                return (new UserSite())->where(['uid'=>$uid,"default"=>1])->find();
            default:
                return (new UserSite())->where("uid",$uid)->select();
        }
    }

    /**
     * 条件获取送货地址
     * @param $where
     */
    public function getSiteFind($where)
    {
        return (new UserSite())->where($where)->find();
    }

    /**
     * 新增送货地址
     * @param $uid
     * @param $data
     */
    public function addSite($uid,$data)
    {
        $siteM = new UserSite();
        $areaM = new AreaLogic();
        // 获取该用户是否有送货地址
        $count = $siteM -> where("uid",$uid)->count();
        if($count <= 0){
            $data['default'] = 1;
        }
        $data['uid'] = $uid;
        $data['zone'] = $data['province'].",".$data['city'].",".$data['county'];
        $data['province'] = $areaM -> getAreaName("area_id",$data['province']);
        $data['city'] = $areaM -> getAreaName("area_id",$data['city']);
        $data['county'] = $areaM -> getAreaName("area_id",$data['county']);
        return $siteM->insert($data);
    }

    /**
     * 修改送货地址
     * @param $uid
     * @param $data
     */
    public function modifySite($uid,$data)
    {
        $siteM = new UserSite();
        $areaM = new AreaLogic();
        $data['uid'] = $uid;
        $data['zone'] = $data['province'].",".$data['city'].",".$data['county'];
        $data['province'] = $areaM -> getAreaName("area_id",$data['province']);
        $data['city'] = $areaM -> getAreaName("area_id",$data['city']);
        $data['county'] = $areaM -> getAreaName("area_id",$data['county']);
        return $siteM->where("")->update($data);
    }

    /**
     * 修改用户默认送货地址
     * @param $uid
     * @param $id  int  site table id
     */
    public function defaSite($uid,$id)
    {
        Db::startTrans();
        try{
            $siteM = new UserSite();
            $site = $siteM -> where(['uid'=>$uid,'default'=>1])->count();
            if($site >= 1){
                $ret = $siteM -> where("uid",$uid)->update(['default'=>0]);
                if(!$ret){
                    throw new \Exception('用户默认地址修改失败');
                }
            }
            $res = $siteM->where("id",$id)->update(['default'=>1]);
            if(!$res){
                throw new \Exception('用户默认地址修改失败');
            }
            // 提交事务
            Db::commit();
            $state = true;
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            //$state['msg'] = $e->getMessage();
            $state = false;
        }
        return $state;
    }

    /**
     * 删除收货地址
     * @param $where
     */
    public function delSite($where)
    {
        return (new UserSite())->where($where)->delete();
    }
}