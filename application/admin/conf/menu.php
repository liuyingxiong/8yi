<?php
return array(
    'system' => array('name' => '系统模块', 'child' => array(
        array('name' => 'test', 'act' => 'Index', 'op' => 'list'),
        /*'name' => '首页', 'child' => array()*/
    )),
    'admin' => array('name' => '管理者模块', 'child' => array(
        array('name' => '管理者列表', 'act' => 'Admin', 'op' => 'list'),
        array('name' => '管理者添加', 'act' => 'Admin', 'op' => 'add'),
    )),
    'user' => array('name' => '用户模块', 'child' => array(
        array('name' => '用户列表', 'act' => 'User', 'op' => 'list'),
    )),
    'shop' => array('name' => '便利店模块', 'child' => array(
        array('name' => '商品分类', 'act' => 'Goods', 'op' => 'tabulation'),
        array('name' => '添加分类', 'act' => 'Goods', 'op' => 'addcate'),
        array('name' => '商品列表', 'act' => 'Goods', 'op' => 'list'),
        array('name' => '添加商品', 'act' => 'Goods', 'op' => 'addgoods'),
    )),
    'order' => array('name' => '订单模块', 'child' => array(
        array('name' => '订单列表', 'act' => 'Order', 'op' => 'list'),
        array('name' => '删除订单', 'act' => 'Order', 'op' => 'forcedel'),
    )),
    'activity' => array('name' => '活动模块', 'child' => array(
        array('name' => '商品套餐', 'act' => 'Goods', 'op' => 'meal_list'),
    )),
    'reward' => array('name' => '奖品模块', 'child' => array(
        array('name' => '奖励列表', 'act' => 'Prize', 'op' => 'reward_list'),
    )),
    /*'ranking' => array('name' => '排行榜模块', 'child' => array(
        array('name' => '省钱—周排行', 'act' => 'Ranking', 'op' => 'week_ranking_list'),
        array('name' => '省钱—月排行', 'act' => 'Ranking', 'op' => 'month_ranking_list'),
    )),*/

    /*'菜单分组' => array('name' => '一级菜单名', 'child' => array(
        array('name' => '二级菜单名', 'act' => '控制器', 'op' => '方法'),
    )),*/
);