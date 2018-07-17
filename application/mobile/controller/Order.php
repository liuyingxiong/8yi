<?php
namespace app\mobile\controller;

use app\common\logic\ActivityGoodsLogic;
use app\common\logic\GoodsLogic;
use app\common\logic\OrderLogic;
use app\common\logic\UserSiteLogic;
use app\weixin\controller\Jssdk;
use app\weixin\controller\Weipay;

class Order extends Base
{
    /**
     * AJAX-FROM动态记录选中商品 param
     */
    public function ajaxRecord()
    {
        if($this->request->isAjax()){
            $arr = input("post.") ? input("post.") : false;
            if($arr){
                session("goods",$arr);
            }else{
                session("goods",null);
            }
            return ret(1,"","商品记录成功");
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 确认订单 - 选择商品订单
     */
    public function on_order()
    {
        $user = session("user");
        // 获取送货地址
        $site = (new UserSiteLogic())->getSite($user['id']);
        $this->assign('site',$site);
        // 获取商品参数
        $goodsSession = session("goods");
        $goods = [];
        $i = 0;
        if($goodsSession){
            $goodsM = new GoodsLogic();
            foreach($goodsSession as $k => $item){
                $i++;
                $goods[$i] = $goodsM->getGoodsFindInfo(["goods_sn" => $k]);
                $goods[$i]['number'] = $item;
            }
        }
        $this->assign('goods',$goods);
        $this->assign('order_sn',order_sn($user['id']));
        return $this->fetch();
    }

    /**
     * 确认订单购买 - 商品套餐
     */
    public function on_order_meal()
    {
        if($this->request->isAjax()){
            $act_goods_id = input("post.act_goods_id") ? input("post.act_goods_id") : false;
            if($act_goods_id){
                $ret = (new OrderLogic())->addOrderMeal($act_goods_id);
                return $ret;
            }
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 订单成功下单页面
     */
    public function pay()
    {
        $arr = input("param.") ? input("param.") : false;
        if($arr && isset($arr['order_sn'])){
            $res = (new OrderLogic())->getOrderFind(['order_sn'=>$arr['order_sn']]);
            $this->assign("order",$res);
            return $this->fetch();
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 下订单
     */
    public function xiaorder()
    {
        if($this->request->post()){
            $arr = input("post.") ? input("post.") : false;
            if(!$arr || !isset($arr['site_id']) || !isset($arr['order_sn'])){
                $this->errorJQ("参数错误",2000);
            }
            // 判断是不是重复提交
            $orderM = new OrderLogic();
            $res = $orderM->getOrderFind(['order_sn'=>$arr['order_sn']]);
            if($res){
                session("goods",null);
                $this->assign("order",$res);
                return $this->fetch();
            }
            // 下单
            $ret = $orderM->addOrder($arr);
            if($ret['ret'] === 1){
                session("goods",null);
                return $ret;
            }
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 订单支付(订单详情)
     */
    public function pays()
    {
        $order_sn = input("param.order_sn") ? input("param.order_sn") : false;
        if($order_sn){
            $type = input("param.type");
            if(isset($type)){
                $leftUrl = url("User/myorder",['type'=>$type],false);
            }else{
                $leftUrl = url("Goods/index");
            }
            $this->assign('leftUrl',$leftUrl);
            // 获取订单
            $field = "o.*,g.goods_name,g.thumbnail_img,g.spec,g.company,g.shop_price,g.number";
            $orderGoods = (new OrderLogic())->getOrderGoodsFind(['o.order_sn'=>$order_sn],$field);
            if(empty($orderGoods)){
                $this->errorJQ("该订单没有商品",2000);
            }else{
                $this->assign('orderGoods',$orderGoods);
                if($orderGoods[0]['payment_state'] != 1){
                    if(isWeiXin()){     // 微信支付
                        $this->assign('isweixin',true);
                        // 微信接口配置
                        $jssdk = (new Jssdk())->getSignPackage();
                        $this->assign('jssdk',$jssdk);
                        // 统一下单
                        $chooseWXPay = (new Weipay())->jssdkweipay(session("user")['wx_openid'],$orderGoods[0]['order_sn'],$orderGoods[0]['total'],$this->request->ip());
                        $this->assign('chooseWXPay',$chooseWXPay);
                    }
                }
                return $this->fetch();
            }
        }
        $this->errorJQ("该订单没有商品",2000);
    }

    /**
     * 取消订单
     */
    public function delOrder()
    {
        if($this->request->isAjax()){
            $arr = input("post.") ? input("post.") : false;
            if($arr && isset($arr['order_sn'])){
                return (new OrderLogic())->modiOrderUser($arr);
            }
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 订单确认为货到付款
     */
    public function cashonde()
    {
        if($this->request->isAjax()){
            $arr = input("post.") ? input("post.") : false;
            if($arr && isset($arr['order_sn'])){
                return (new OrderLogic())->cashUpdate($arr);
            }
        }
        return ret(-1,"","参数错误");
    }

}
