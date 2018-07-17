<?php
namespace app\mobile\controller;

use app\common\logic\UserSiteLogic;

class Cart extends Base
{
    /**
     * 购物车首页
     */
    public function index()
    {
        $user = session("user");
        // 获取送货地址
        $site = (new UserSiteLogic())->getSite($user['id'],0);
        $this->assign('site',$site);

        return $this->fetch();
    }
}
