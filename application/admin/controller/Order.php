<?php
namespace app\admin\controller;

use app\common\logic\OrderLogic;
use app\common\model\OrderGoods;
use think\Db;

class Order extends Base
{
    /**
     * 订单列表页面
     */
    public function list()
    {
        $p = input("param.p") ? input("param.p") : 1;
        $this->assign('p',$p);
        $GoodsM = new OrderLogic();
        $count = $GoodsM -> getOrderCount();
        $page = adminPage($p,$count);
        $this->assign('page',$page);
        $goods = $GoodsM->getOrderInfo([],"order_id desc",$p);
        $this->assign('goods',$goods);
        return $this->fetch();
    }

    /**
     * 订单详情页面
     */
    public function orderdeta()
    {
        if($this->request->isAjax()){
            $order_sn = input("post.order_sn") ? input("post.order_sn") : false;
            if(!$order_sn){
                return ret(-1,"","参数错误");
            }
            $field = "o.*,g.goods_name,g.thumbnail_img,g.spec,g.company,g.shop_price,g.number";
            $orderGoods = (new OrderLogic())->getOrderGoodsFind(['o.order_sn'=>$order_sn],$field);
            if(empty($orderGoods)){
                return ret(-1,"","该订单没有商品");
            }
            $this->assign('orderGoods',$orderGoods);
            return $this->fetch();
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 删除订单
     */
    public function delOrder()
    {
        if($this->request->isAjax()){
            $goods_sn = input("post.order_sn") ? input("post.order_sn") : false;
            if($goods_sn){
                $res = (new OrderLogic())->delOrder(["order_sn"=>$goods_sn],$this->request->ip());
                return $res;
            }
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 修改订单
     */
    public function modifyOrder()
    {
        if($this->request->isAjax()){
            $order = input("post.") ? input("post.") : false;
            if($order){
                $res = (new OrderLogic())->modiOrder($order,$this->request->ip());
                return $res;
            }
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 无理由强制删除订单
     */
    public function forcedel()
    {
        if($this->request->isAjax()){
            $order_sn = input("post.order_sn") ? input("post.order_sn") : false;
            if($order_sn){
                // 启动事务
                Db::startTrans();
                try{
                    // 删除数据
                    $retO = (new \app\common\model\Order())->where("order_sn",$order_sn)->delete();
                    if($retO <= 0){
                        throw new \Exception("没有此订单！",1);
                    }
                    $retG = (new OrderGoods())->where("order_sn",$order_sn)->delete();
                    if($retG <= 0){
                        throw new \Exception("没有此订单！",2);
                    }
                    // 提交事务
                    Db::commit();
                    return ret(1,"","删除订单成功");
                } catch (\Exception $e) {
                    // 回滚事务
                    Db::rollback();
                    return ret(-1,$e->getCode(),$e->getMessage());
                }
            }
        }
        return $this->fetch();
    }

    /**
     * 搜索订单号
     */
    public function searchOrder()
    {
        if($this->request->isAjax()){
            $arr = input("post.") ? input("post.") : false;
            $where = [];
            // 订单号
            if(isset($arr['order_sn'])){
                if(trim($arr['order_sn']) != ""){
                    $where['order_sn'] = ['like','%'.trim($arr['order_sn']).'%'];
                }else{
                    unset($arr['order_sn']);
                }
            }
            // 收货人电话
            if(isset($arr['phone'])){
                if(trim($arr['phone']) != ""){
                    $where['phone'] = trim($arr['phone']);
                }else{
                    unset($arr['phone']);
                }
            }
            // 时间范围
            if(isset($arr['s_time']) && isset($arr['e_time'])){
                if($arr['s_time'] != "" && $arr['e_time'] != ""){
                    $where['addtime'] = ['between',[strtotime($arr['s_time']),strtotime($arr['e_time'])]];
                }else{
                    unset($arr['s_time']);
                    unset($arr['e_time']);
                }
            }
            // 判断
            if(!empty($where)){
                $p =  input("param.p") ? input("param.p") : 1;
                $this->assign('p',$p);
                $GoodsM = new OrderLogic();
                $count = $GoodsM -> getOrderCount($where);
                $page = adminPage($p,$count);
                $this->assign('page',$page);

                $ret = Db::name("order")->where($where)->select();
                if (empty($ret)){
                    return ret(-1,"","没有该订单");
                }
                $this->assign('goods',$ret);
                return $this->fetch();
            }
            return ret(-1,'',"没有该订单");
        }
        return ret(-1,"","无参数");
    }
}
