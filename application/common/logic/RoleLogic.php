<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/19
 * Time: 11:34
 */

namespace app\common\logic;


use app\common\model\Role;
use think\console\command\make\Model;
use think\Db;

class RoleLogic extends Model
{
    /**
     * 获取角色列表信息
     * @param  $where  array   条件
     * @param  $order  string  排序
     * @param  $p      int     数字
     */
    public function getRoleList($where=[],$order="id ASC",$p=0)
    {
        if ($p > 0){
            $s = ($p-1) * 10;
            return Db::name('role')->where($where)->order($order)->limit($s,10)->select();
        }
        return Db::name('role')->where($where)->order($order)->select();
    }

    /**
     * 条件获取角色总数
     * @param  $where
     */
    public function getRoleCount($where=[])
    {
        return Db::name('role')->where($where)->count();
    }

    /**
     * 条件获取角色信息
     * @param $where array  条件
     */
    public function getRoleInfo($where = [])
    {
        return (new Role())->where($where)->find();
    }

    /**
     * 添加角色
     * @param $data  array  数据
     */
    public function addRole($data)
    {
        return Db::name('role')->insert($data);
    }

    /**
     * 删除角色
     * @param $data  array  数据
     */
    public function delRole($data)
    {
        return Db::name('role')->delete($data);
    }
}