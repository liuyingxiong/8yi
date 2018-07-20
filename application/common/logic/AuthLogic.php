<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/19
 * Time: 15:19
 */

namespace app\common\logic;


use think\console\command\make\Model;
use think\Db;

class AuthLogic extends Model
{
    /**
     * 权限列表
     * @param $where array   条件
     * @param $order string  排序
     * @param $p     int     数字
     */
    public function authList($where=[],$order='id ASC',$p=0)
    {
        if ($p > 0){
            $s = ($p-1)*10;
            return Db::name('auth')->where($where)->order($order)->limit($s,10)->select();
        }
        return Db::name('auth')->where($where)->order($order)->select();
    }

    /**
     * 条件获取单个权限
     * @param  $where  array  条件
     */
    public function getAuth($where)
    {
        return Db::name('auth')->where($where)->find();
    }

    /**
     * 条件获取权限总数
     * @param $where array  条件
     */
    public function getAuthCount($where=[])
    {
        return Db::name('auth')->where($where)->count();
    }

    /**
     * 添加权限
     * @param $data array  数据
     */
    public function addAuth($data)
    {
        return Db::name('auth')->insert($data);
    }

    /**
     * 删除权限
     * @param $data  array  数据
     */
    public function delAuth($data)
    {
        return Db::name('auth')->delete($data);
    }

}