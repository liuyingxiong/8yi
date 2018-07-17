<?php

namespace app\common\logic;

use app\common\model\RankingHistoryMonth;
use app\common\model\RankingMonth;
use think\Model;

class RankingMonthLogic extends Model
{
    /**
     * 获取当月排行数据
     * 表一 USER    表二 RankingWeek
     * @param $length int 条数
     */
    public function getUserMonth($where,$length=0)
    {
        $field = "u.nickname,u.photo,w.*";
        if($length > 0){
            return (new RankingMonth()) ->alias("w")
                                        ->join("user u","w.uid = u.id")
                                        ->where($where)
                                        ->field($field)
                                        ->limit(0,$length)
                                        ->order("w.s_save DESC,w.make_time ASC")
                                        ->select();
        }else{
            return (new RankingMonth()) ->alias("w")
                                        ->join("user u","w.uid = u.id")
                                        ->field($field)
                                        ->order("w.s_save DESC,w.make_time ASC")
                                        ->select();
        }
    }

    /**
     * 获取历史月排行数据
     * 表一 USER    表二 RankingHistoryMonth
     * @param $where  array  条件
     * @param $length int    条数
     */
    public function getHistoryMonth($where,$order="id ASC",$length=0)
    {
        $field = "u.nickname,u.photo,m.*";
        if($length > 0){
            return (new RankingHistoryMonth()) ->alias("m")
                ->join("user u","m.uid = u.id")
                ->field($field)
                ->where($where)
                ->limit(0,$length)
                ->order($order)
                ->select();
        }else{
            return (new RankingHistoryMonth()) ->alias("m")
                ->join("user u","m.uid = u.id")
                ->field($field)
                ->where($where)
                ->order($order)
                ->select();
        }
    }
}