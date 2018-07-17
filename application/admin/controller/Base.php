<?php
namespace app\admin\controller;

use think\Controller;

class Base extends Controller
{
    /*
    * 初始化操作
    */
    public function _initialize()
    {
        $this->checkLogin();
        $this->getMenu();
        $this->assign('adminInfo',session("adminInfo"));
    }

    /**
     * 判断是否已登录
     */
    protected function checkLogin()
    {
        $adminSe  = session('adminInfo');
        $adminCo = cookie("adminInfo");
        if($adminSe && $adminCo){
            cookie('adminInfo', $adminCo, 3600);
        }else{
            $this->clearLogin();
        }
    }

    /**
     * 清空登录cookie session
     */
    protected function clearLogin()
    {
        session("adminInfo",null);
        cookie('adminInfo', null);
        $this->redirect('Login/index');
    }

    /**
     * 获取导航菜单
     */
    protected function getMenu()
    {
        $menu = include APP_PATH."admin/conf/menu.php";
//        $location = strtolower('Admin/'.$this->request->controller()); // 当前控制器
        $location = $this->request->controller(); // 当前控制器
        $method = $this->request->action(); // 当前方法名
        $this->assign('left_menu',$menu);
        $this->assign('location',$location);
        $this->assign('method',$method);
    }
}
