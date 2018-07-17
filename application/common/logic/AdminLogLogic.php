<?php

namespace app\common\logic;

use app\common\model\AdminLog;
use think\Model;

class AdminLogLogic extends Model
{
    /**
     * 管理者登陆日记
     * @param $adminId int ID
     * @param $adminName
     * @param $ip
     */
    public function loginLog($adminId,$adminName,$ip)
    {
        $data = [
            'admin_id' => $adminId,
            'remark' => $adminName.'登陆',
            'ip' => $ip,
            'addtime' => time()
        ];
        $ret = (new AdminLog())->insert($data);
        if(!$ret){
            $this->loginLog($adminId,$adminName,$ip);
        }else{
            return $ret;
        }
    }
}