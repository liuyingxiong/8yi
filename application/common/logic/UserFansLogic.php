<?php

namespace app\common\logic;

use app\common\model\UserFans;
use think\Model;

class UserFansLogic extends Model
{
    /**
     * 获取我的粉丝数量 || 获取我的关注数量
     * @param type  1 粉丝数量   2 关注数量
     * @param uid
     */
    public function getFansCount($type,$uid)
    {
        switch ($type)
        {
            case 1:
                return (new UserFans())->where('uid',$uid)->count();
                break;
            case 2:
                return (new UserFans())->where('fans',$uid)->count();
                break;
            default:
                return 0;
        }
    }
}