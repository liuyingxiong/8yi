<?php
namespace app\home\controller;
use think\Controller;
use think\Db;

class Base extends Controller
{
    /*
    * 初始化操作
    */
    public function _initialize()
    {
        // 手机浏览器
        /*if(isMobile()){
            $this->success("","Mobile/Index/index",0,0);
        }*/
    }
}
