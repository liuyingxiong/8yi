<?php

namespace app\common\logic;

use app\common\model\LoginLog;
use think\Model;

class LoginLogLogic extends Model
{
    /**
     * 记录登陆日记
     * @param $tableName 1: 会员用户表； 2：管理者表
     * @param $uid  ID
     * @param $remark 备注
     * @param $system_version 登陆方式  : 手机端|PC端|APP|微信端
     */
    public function addLoginLog($tableName,$uid,$remark="",$system_version="")
    {
        switch ($tableName)
        {
            case 1:
                $data = [
                    'uid'=>$uid,
                    'remark'=>$remark,
                    'ip'=>request()->ip(),
                    'system_version'=>$system_version,
                    'addtime'=>time()
                ];
                break;
            case 2:
                break;
        }
        if(!empty($data)){
            $number = (new LoginLog())->insertGetId($data);
            if($number){
                return ['ret'=>1,"msg"=>"登陆成功"];
            }
        }
        return ['ret'=>0,"msg"=>"登陆失败"];
    }
}