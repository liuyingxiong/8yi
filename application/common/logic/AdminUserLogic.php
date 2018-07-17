<?php

namespace app\common\logic;

use app\common\model\AdminLog;
use app\common\model\AdminUser;
use think\Db;
use think\Model;

class AdminUserLogic extends Model
{
    /**
     * 管理账号条件查询
     * @param $field array || char
     * @param $value array || char
     */
    public function getAdminInfo($field,$value)
    {
        if($field && $value){
            if(is_array($field) && is_array($value)){
                $where = [];
                foreach($field as $k => $list){
                    $where[$list] = $value[$k];
                }
                return (new AdminUser())->where($where)->find();
            }else{
                return (new AdminUser())->where($field,$value)->find();
            }
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 管理账号条件总数查询
     */
    public function getAdminCount($where=[])
    {
        return (new AdminUser())->where($where)->count();
    }

    /**
     * 管理账号条件查询
     * @param $p 页数
     */
    public function getAdminSelect($where=[],$field="*",$p)
    {
        if($p >= 1){
            $s = ($p-1)*10;
            return (new AdminUser())->field($field)->where($where)->limit($s,10)->select();
        }
        return (new AdminUser()) -> field($field) -> where($where) -> select();
    }

    /**
     * 删除管理账号
     * @param $where 删除条件
     * @param $remark 记录删除日记的备注
     * @param $admin_id 操作者
     * @param $ip 操作者ip地址
     */
    public function delAdmin($where,$remark,$admin_id,$ip)
    {
        if($where && $admin_id){
            Db::startTrans();
            try{
                // 删除数据
                $adminRet = (new AdminUser())->where($where)->delete();
                if($adminRet <= 0){
                    throw new \Exception("参数错误",1);
                }
                // 记录操作日记
                $data = array(
                    'admin_id' => $admin_id,
                    'remark' => $remark,
                    'ip' => $ip,
                    'addtime' => time()
                );
                $logRet = (new AdminLog())->insert($data);
                if($logRet <= 0){
                    throw new \Exception("系统错误",2);
                }
                // 提交事务
                Db::commit();
                return ret(1,"","删除成功");
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                return ret(-1,"",$e->getMessage());
            }
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 修改管理账号密码
     * @param $arr 数组参数
     * @param $ip 操作者ip地址
     */
    public function modifyPassAdmin($arr,$ip)
    {
        $adminUserM = new AdminUser();
        // 获取要修改的账号
        $modAdmin = $adminUserM -> where("id",$arr['admin_id'])->find();
        if(empty($modAdmin)){
            return ret(-1,"","参数错误");
        }
        if(!empty($modAdmin['password'])){
            if(encryTwo($arr['oldPassword']) !== $modAdmin['password']){
                return ret(-1,"","密码错误");
            }
        }
        // 事物
        Db::startTrans();
        try{
            // 修改数据
            $adminRet = $adminUserM->where("id",$arr['admin_id'])->update(['password'=>encryTwo($arr['newPassword'])]);
            if($adminRet <= 0){
                throw new \Exception("系统错误",1);
            }
            // 记录操作日记
            $adminInfo = session("adminInfo");
            $data = array(
                'admin_id' => $adminInfo['id'],
                'remark' => "管理者【".$adminInfo['username']."】修改管理账号【".$modAdmin['username']."】的登陆密码",
                'ip' => $ip,
                'addtime' => time()
            );
            $logRet = (new AdminLog())->insert($data);
            if($logRet <= 0){
                throw new \Exception("系统错误",2);
            }
            // 提交事务
            Db::commit();
            return ret(1,"","修改成功");
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return ret(-1,"",$e->getMessage());
        }
    }

    /**
     * 添加管理账号密码
     * @param $arr 数组参数
     * @param $ip 操作者ip地址
     */
    public function addAdmin($arr,$ip)
    {
        if($arr && $ip){
            $adminUserM = new AdminUser();
            $info = $adminUserM->where("username",$arr['username'])->find();
            if($info){
                return ret(-1,"","账号已有，请重新输入");
            }
            // 事物
            Db::startTrans();
            try{
                // 添加数据
                $time = time();
                $arr['addtime'] = $time;
                $arr['password'] = encryTwo($arr['password']);
                $adminRet = $adminUserM->insert($arr);
                if($adminRet <= 0){
                    throw new \Exception("系统错误",1);
                }
                // 记录操作日记
                $adminInfo = session("adminInfo");
                $data = array(
                    'admin_id' => $adminInfo['id'],
                    'remark' => "管理者【".$adminInfo['username']."】添加管理账号【".$arr['username']."】",
                    'ip' => $ip,
                    'addtime' => $time
                );
                $logRet = (new AdminLog())->insert($data);
                if($logRet <= 0){
                    throw new \Exception("系统错误",2);
                }
                // 提交事务
                Db::commit();
                return ret(1,"","添加成功");
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                return ret(-1,"",$e->getMessage());
            }
        }
        return ret(-1,"","参数错误");
    }

}