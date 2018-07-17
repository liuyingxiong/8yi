<?php

namespace app\common\logic;

use app\common\model\RankingHistory;
use app\common\model\RankingWeek;
use think\Model;

class RankingWeekLogic extends Model
{
    /**
     * 双表获取周排行数据
     * 表一 USER    表二 RankingWeek
     * @param $where array  条件
     * @param $field  string 字段名
     * @param $order string 排列顺序
     */
    public function getUserWeekSelect($field,$order="id ASC")
    {
        return (new RankingWeek())->alias("w")
                                  ->join("user u","w.uid = u.id")
                                  ->field($field)
                                  ->order($order)
                                  ->select();
    }

    /**
     * 获取上周排行数据
     * 表一 USER    表二 RankingHistory
     * @param $where  array  条件
     * @param $field  string 字段名
     * @param $order  string 排列顺序
     * @param $length int    条数
     */
    public function getHistoryWeek($where,$field,$length=0,$order="id ASC")
    {
        if($length > 0){
            return (new RankingHistory())->alias("w")
                                        ->join("user u","w.uid = u.id")
                                        ->field($field)
                                        ->where($where)
                                        ->limit(0,$length)
                                        ->order($order)
                                        ->select();
        }
        return (new RankingHistory())->alias("w")
                                    ->join("user u","w.uid = u.id")
                                    ->field($field)
                                    ->where($where)
                                    ->order($order)
                                    ->select();
    }

}