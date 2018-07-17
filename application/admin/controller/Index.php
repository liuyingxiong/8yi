<?php
namespace app\admin\controller;

class Index extends Base
{
    /**
     * 后台管理首页
     */
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 测试
     */
    public function list()
    {
        return $this->fetch();
    }

}
