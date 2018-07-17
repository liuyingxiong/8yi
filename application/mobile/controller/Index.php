<?php
namespace app\mobile\controller;

use app\common\logic\RankingMonthLogic;
use app\common\logic\RankingWeekLogic;

class Index extends Base
{
    protected $foot = "首页";

    /**
     * @return mixed
     */
    public function index()
    {
        $this->assign('value',$this->foot);
        return $this->fetch();
    }

    /**
     * 玩家周排行榜
     */
    public function wookranking()
    {
        // 获取排行榜名次
        /*$field = "u.nickname,u.photo,w.*";
        $list = (new RankingWeekLogic())->getUserWeekSelect([],$field,"s_save DESC,make_time ASC");
        $this->assign('rankingList',$list);
        return $this->fetch();*/
      	// 获取本周排行榜名次
        $field = "u.nickname,u.photo,w.*";
        $list = (new RankingWeekLogic())->getUserWeekSelect($field,"s_save DESC,make_time ASC");
        $this->assign('rankingList',$list);

        //获取上周排行榜名次
        $historyList = [];
        $week = date("w",time());
        $time = "";
        switch ($week) {
            case 1:
                $time = strtotime(date("Y-m-d",time())." 23:59:59")*1-(60*60*24);
                break;
            case 2:
                $time = strtotime(date("Y-m-d",time())." 23:59:59")*1-(60*60*24*2);
                break;
            case 3:
                $time = strtotime(date("Y-m-d",time())." 23:59:59")*1-(60*60*24*3);
                break;
            case 4:
                $time = strtotime(date("Y-m-d",time())." 23:59:59")*1-(60*60*24*4);
                break;
            case 5:
                $time = strtotime(date("Y-m-d",time())." 23:59:59")*1-(60*60*24*5);
                break;
            case 6:
                $time = strtotime(date("Y-m-d",time())." 23:59:59")*1-(60*60*24*6);
                break;
            case 0:
                $time = strtotime(date("Y-m-d",time())." 23:59:59")*1-(60*60*24*7);
                break;
        }
        if(!empty($time)){
            $historyList = (new RankingWeekLogic())->getHistoryWeek(["w.addtime"=>$time],$field,0,"w.sort ASC");
        }
        $this->assign('historyList',$historyList);
        return $this->fetch();
    }
  
  	/**
     * 月排行榜
     */
    public function saveList()
    {
        //获取本月排行榜名次
        $list = (new RankingMonthLogic())->getUserMonth([]);
        $this->assign('monthList',$list);

        //获取历史月排行榜名次  23:59:59
        $time = strtotime(date("Y-m",time())."-01 23:59:59")*1-(60*60*24);
        $hismonthList = (new RankingMonthLogic())->getHistoryMonth(["m.addtime"=>$time],"m.save_month DESC,m.make_time ASC");
        $this->assign('hismonthList',$hismonthList);
        return $this->fetch();
    }
}
