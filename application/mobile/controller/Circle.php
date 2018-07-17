<?php
namespace app\mobile\controller;

class Circle extends Base
{
    protected $foot = "邻居圈";

    /**
     * 消息首页
     */
    public function index()
    {
        $this->assign('value',$this->foot);
        return $this->fetch();
    }
}
