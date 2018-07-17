<?php
namespace app\mobile\controller;

use app\common\logic\OrderLogic;
use app\common\logic\UserFansLogic;

class User extends Base
{
    protected $foot = "我的";

    /**
     * 我的信息页面
     */
    public function my()
    {
        $user = session("user");
        // 获取关注数量  粉丝数量
        $fansM = new UserFansLogic();
        $user['fans'] = $fansM->getFansCount(1,$user['id']);
        $user['follow'] = $fansM->getFansCount(2,$user['id']);

        $this->assign("value",$this->foot);
        return $this->fetch();
    }

    /**
     * 我的订单列表
     */
    public function myorder()
    {
        $orderType = input("param.type") ? input("param.type") : 0;
        $this->assign('orderType',$orderType);
        return $this->fetch();
    }

    /**
     * AJAX订单列表
     */
    public function myorderajax()
    {
        $user = session("user");
        $orderType = input("post.type");
        $this->assign('orderType',$orderType);
        // 获取订单
        $where = [
            'uid'=>$user['id'],
            "is_show" => 1
        ];
        switch ($orderType)
        {
            case 1:                                 // 待付款订单
                $where['payment_state'] = 0;
                $where['order_state'] = 0;
                break;
            case 2:                                 // 待配送订单
                $where['delivery_state'] = array(array("neq",3),array("neq",0),"and");
                $where['order_state'] = 0;
                break;
            case 3:                                 // 已完成订单
                $where['order_state'] = 1;
                $where['delivery_state'] = 3;
                $where['payment_state'] = 1;
                break;
            default:                                // 全部订单
        }
        $orderList = (new OrderLogic())->getOrderInfo($where,"order_id desc");
        $this->assign("order",$orderList);
        return $this->fetch();
    }

    /**
     * 订单总省金额
     */
    public function save()
    {
        $user = session("user");
        // 获取所有订单
        $where = [
            'uid'=>$user['id'],
            'order_state' => 1
        ];
        $order = (new OrderLogic())->getOrderInfo($where,"order_id DESC",0,"order_sn,save,addtime");
        $total_save = (new OrderLogic())->getSum($where,"save");
        $this->assign('order',$order);
        $this->assign('total_save',$total_save);
        return $this->fetch();
    }

    /**
     * 我的优惠劵
     */
    public function coupon()
    {
        return $this->fetch();
    }
}
