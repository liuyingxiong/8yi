<?php

namespace app\common\logic;

use app\common\model\User;
use think\Model;

class UserLogic extends Model
{
    /**
     * 单条件获取用户信息
     * @param $field
     * @param $value
     */
    public function getUserInfo($field,$value)
    {
        return (new User())->where($field,$value)->find();
    }

    /**
     * 条件获取用户总数
     * @param $where array 条件
     */
    public function getUsersCount($where=[])
    {
        return (new User())->where($where)->count();
    }

    /**
     * 获取用户信息
     * @param $where array   条件
     * @param $order string  排序
     * @param $p     int     页数
     */
    public  function getUsers($where = [],$order = "id asc",$p = 0)
    {
        if($p > 0){
            $s = ($p-1)*10;
            return (new User())->where($where)->order($order)->limit($s,10)->select();
        }
        return (new User())->where($where)->order($order)->select();
    }

    /**
     * 删除用户信息
     * @param $where array 条件
     */
    public function delUser($where)
    {
        return (new User())->where($where)->delete();
    }

    /**
     * 更新数据
     * @param $where array 条件
     * @param $data array 数组
     */
    public function updateInto($where,$data)
    {
        return (new User())->where($where)->update($data);
    }
}