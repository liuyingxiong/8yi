<?php
namespace app\mobile\controller;

use app\common\logic\PrizesLogic;

class Activity extends Base
{
    protected $foot = "活动";

    /**
     * 活动首页
     */
    public function index()
    {
        $this->assign('value',$this->foot);
        return $this->fetch();
    }

    /**
     * 排行榜 心愿奖励 当期奖品
     */
    public function prize_list_2()
    {
        $prize = (new PrizesLogic())->getFind(['state'=>1]);
        $this->assign('prize',$prize);
        return $this->fetch();
    }

    /**
     * 排行榜 心愿奖励 公布上期奖品
     */
    public function prize_list_3()
    {
        $prize = (new PrizesLogic())->getFind(['state'=>3]);
        $this->assign('prize',$prize);
        return $this->fetch();
    }
}
