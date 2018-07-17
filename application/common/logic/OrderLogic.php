<?php

namespace app\common\logic;

use app\common\model\AdminLog;
use app\common\model\Order;
use app\common\model\OrderGoods;
use app\common\model\RankingMonth;
use app\common\model\RankingWeek;
use sms\SendDemo;
use think\Db;
use think\Model;

class OrderLogic extends Model
{
    /**
     * 条件获取单条数据
     * @param $where array
     */
    public function getOrderFind($where)
    {
        return (new Order())->where($where)->find();
    }

    /**
     * 条件获取订单数据
     * @param $where array
     * @param $order string
     * @param $p int
     * @param $field string
     */
    public function getOrderInfo($where=[],$order="order_id ASC",$p=0,$field="*")
    {
        if($p > 0){
            $s = ($p-1)*10;
            return (new Order())->field($field)->where($where)->order($order)->limit($s,10)->select();
        }
        return (new Order())->field($field)->where($where)->order($order)->select();
    }

    /*
     * 获取字段的总数
     * @param $where array
     * @param $field string
     */
    public function getSum($where=[],$field)
    {
        return (new Order())->where($where)->sum($field);
    }

    /**
     * 用户下单
     * @param $arr array
     */
    public function addOrder($arr)
    {
        if($arr && $arr['site_id']){
            $time = time();
            // 获取收货信息
            $site = (new UserSiteLogic())->getSiteFind(['id'=>$arr['site_id']]);
            if(!$site){
                return ret(-1,"","参数错误");
            }
            $order_sn = $arr['order_sn'];               // 订单编号
            $goods_sns = array_keys($arr);
            unset($goods_sns[0]);
            unset($goods_sns[1]);
            $goods_sns = implode(",",$goods_sns);
            // 订单信息参数
            $user = session("user");
            $orderDate = [
                "order_sn" => $order_sn,                 // 订单编号
                "uid" => $user['id'],                    // 用户id
                "people" => $site['receiver'],           // 收货人名称
                "phone" => $site['phone'],               // 收货人电话
                "address" => $site['province'].$site['city'].$site['county'].$site['street'].$site['community'].$site['tower'].$site['unit'].$site['floor'].$site['room'],    // 收货地址
                "goods_sns" => $goods_sns,               // 商品编码字符串
                "addtime" => $time,                      // 下单时间
                "delivery_state" => 0,                   // 送货状态
                "order_state" => 0,                      // 订单状态
                "total" => 0,                            // 总的价格
                "save" => 0,                             // 总的省价
                'imgs' => array(),                       // 订单图片集合
                'total_number' => 0,                     // 订单商品总数量
            ];
            // 订单商品信息
            unset($arr['site_id']);
            unset($arr['order_sn']);
            $goodsDate = [];
            $goodsM = new GoodsLogic();
            foreach($arr as $goods_sn => $value){
                $res = $goodsM->getGoodsFindInfo(['goods_sn'=>$goods_sn]);
                if(!$res){
                    return ret(-1,"","参数错误");
                }
                $orderDate['total'] = $orderDate['total'] + $res['shop_price']*$value;
                // 获取外面价格最大值
                switch ($res['tiptop'])
                {
                    case 1:                     // 淘宝价格
                        $orderDate['save']  = $orderDate['save'] + ($res['taobao_price'] - $res['shop_price'])*$value;
                        break;
                    case 2:                     // 华润价格
                        $orderDate['save']  = $orderDate['save'] + ($res['huarun_price'] - $res['shop_price'])*$value;
                        break;
                    default:                    // 超市价格
                        $orderDate['save']  = $orderDate['save'] + ($res['market_price'] - $res['shop_price'])*$value;
                }

                if(count($orderDate['imgs']) < 3){
                    $orderDate['imgs'][]= $res["thumbnail_img"];
                }
                $orderDate['total_number'] = $orderDate['total_number'] + $value;
                $goodsArr = [
                    "order_sn"      => $order_sn,            // 订单编号
                    "goods_sn"      => $res["goods_sn"],     // 商品编码
                    "goods_name"    => $res["goods_name"],   // 商品名称
                    "thumbnail_img" => $res["thumbnail_img"],// 商品图片
                    "spec"          => $res["spec"],         // 商品规格
                    "company"       => $res["company"],      // 商品单位
                    "shop_price"    => $res["shop_price"],   // 商品单价
                    "number"        => $value,               // 商品数量
                    "addtime"       => $time,                // 添加时间
                ];
                $goodsDate[] = $goodsArr;
            }
            // 事务
            Db::startTrans();
            try{
                // 添加订单信息
                $orderDate['imgs'] = json_encode($orderDate['imgs']);
                $orderRet = (new Order())->insertGetId($orderDate);
                if($orderRet <= 0){
                    throw new \Exception("下单失败",1);
                }
                // 添加订单里面的商品信息
                $orderGoodsRet = (new OrderGoods())->insertAll($goodsDate);
                if($orderGoodsRet <= 0){
                    throw new \Exception("下单失败",2);
                }
                // 提交事务
                Db::commit();
                return ret(1,"",$orderDate);
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                return ret(-1,"",$e->getMessage());
            }
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 用户抢购商品套餐
     * @param $act_goods_id int 活动套餐ID
     * return array
     */
    public function addOrderMeal($act_goods_id)
    {
        if($act_goods_id){
            $user = session("user");
            $time = time();
            $order_sn = order_sn($user['id']);
            // 判断用户地址
            $site = (new UserSiteLogic())->getSite($user['id']);
            if(!$site){
                return ret(-1,"","请先完善收货地址");
            }
            // 获取套餐
            $where = [
                'act_goods_id'=>$act_goods_id,
                'state' => 1,
                's_time'=>['<=',$time],
                'e_time'=>[">=",$time]
            ];
            $actGoods = (new ActivityGoodsLogic())->getActivityFind($where);
            if(empty($actGoods)){
                return ret(-1,"","没有这个活动套餐");
            }
            // 订单里面的商品
            $goodslist = json_decode($actGoods['goods'],true);
            $goods_sns = "";
            $total_number = 0;
            $imgs = [];
            $goodsM = new GoodsLogic();
            $orderGoodsData = [];           // 订单商品
            foreach($goodslist as $list){
                $goods_sns .= "," . $list['goods_name'];
                $total_number += $list['goods_number'];
                $goodsRet = $goodsM->getGoodsFindInfo(["goods_sn" => $list['goods_name']]);
                if(count($imgs) < 3){
                    $imgs[] = $goodsRet['thumbnail_img'];
                }
                $arr = [
                    'order_sn' => $order_sn,
                    'goods_sn' => $list['goods_name'],
                    'goods_name' => $goodsRet['goods_name'],
                    'thumbnail_img' => $goodsRet['thumbnail_img'],
                    'spec' => $goodsRet['spec'],
                    'company' => $goodsRet['company'],
                    'shop_price' => 0,
                    'number' => $list['goods_number'],
                    'addtime' => $time
                ];
                $orderGoodsData[] = $arr;
            }
            $goods_sns = substr($goods_sns,1);
            // 生成订单
            $orderData = [
                'order_sn' => $order_sn,
                'uid' => $user['id'],
                'people' => $site['receiver'],
                'phone' => $site['phone'],
                'address' => $site['province'].$site['city'].$site['county'].$site['street'].$site['community'].$site['tower'],
                'goods_sns' => $goods_sns,
                'total' => $actGoods['price'],
                'save' => $actGoods['market_price'] - $actGoods['price'],
                'addtime' => $time,
                'imgs' => json_encode($imgs,true),
                'total_number' => $total_number,
            ];
            // 事务
            Db::startTrans();
            try{
                // 生成订单
                $orderRet = (new Order())->insert($orderData);
                if($orderRet <= 0){
                    throw new \Exception("下单失败",10);
                }
                // 插入订单里面的商品信息
                $orderGoodsRet = (new OrderGoods())->insertAll($orderGoodsData);
                if($orderGoodsRet <= 0){
                    throw new \Exception("下单失败",20);
                }
                // 提交事务
                Db::commit();
                return ret(1,$order_sn,"抢购成功");
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                return ret(-1,$e->getCode(),$e->getMessage());
            }
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 获取订单总数
     * @param $where array
     */
    public function getOrderCount($where=[])
    {
        return (new Order())->where($where)->count();
    }

    /**
     * 删除条件订单
     * @param $where array
     * @param $ip string ip
     */
    public function delOrder($where,$ip)
    {
        if($where){
            // 获取要删除的信息
            $orderList = $this->getOrderInfo($where);
            if($orderList){
                $order_sn = [];
                foreach($orderList as $list){
                    if($list['order_state'] !== 1 || $list['payment_state'] !== 1 || $list['delivery_state'] !== 3){
                        return ret(-1,1,"还没有成功完成这笔订单，不能删除");
                    }
                    $order_sn[] = $list['order_sn'];
                }
                // 事务
                Db::startTrans();
                try{
                    // 删除订单信息
                    $orderRet = (new Order())->where(["order_sn"=>["in",$order_sn]])->delete();
                    if($orderRet <= 0){
                        throw new \Exception("删除订单失败",10);
                    }
                    // 删除订单里面的商品信息
                    $orderGoodsM = new OrderGoods();
                    $goodsCount = $orderGoodsM->where(["order_sn"=>["in",$order_sn]])->count();
                    if($goodsCount > 0){
                        $goodsRet = $orderGoodsM->where(["order_sn"=>["in",$order_sn]])->delete();
                        if($goodsRet <= 0){
                            throw new \Exception("删除订单商品失败",20);
                        }
                    }
                    // 记录日记
                    $adminInfo = session("adminInfo");
                    $data = [
                        'admin_id' => $adminInfo['id'],
                        'remark' => "管理者【".$adminInfo['username']."】删除商品编号:".json_encode($order_sn,true),
                        'ip' => $ip,
                        'addtime' => time()
                    ];
                    $logRet = (new AdminLog())->insert($data);
                    if($logRet <= 0){
                        throw new \Exception("删除订单失败",30);
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
        return ret(-1,"","参数错误");
    }

    /**
     * 订单信息修改
     * @param $arr array
     * @param $ip string
     */
    public function modiOrder($arr,$ip)
    {
        if($arr && $ip){
            if(isset($arr['delivery_state']) && $arr['delivery_state'] == 3){       // 当订单完成的情况下
                $arr['payment_state'] = 1;
                $arr['order_state'] = 1;

                // 获取订单下面的商品
                $where = [
                    "order_sn" => $arr['order_sn'],
                    "goods_sn" => ['neq',""],
                ];
                $goods = (new OrderGoods())->field("goods_sn,number")->where($where)->select();

                // 获取订单省钱总数
                $ranking = (new Order())->field("uid,save,addtime")->where("order_sn",$arr['order_sn'])->find();
            }
            // 事务
            Db::startTrans();
            try{
                // 修改订单信息
                $orderRet = (new Order())->where("order_sn",$arr['order_sn'])->update($arr);
                if($orderRet <= 0){
                    throw new \Exception("修改失败",1);
                }
                // 增加商品购买数量
                if(isset($goods) && !empty($goods)){
                    foreach($goods as $list){
                        Db::query("update lj_goods set hot_count = hot_count + ".$list['number']." where goods_sn = '".$list['goods_sn']."'");
                    }
                }
                // 增加用户周省钱总数
                if(isset($ranking) && !empty($ranking)){
                    $rankingM = new RankingWeek();
                    // 判断是不是本周第一次成功下单
                    $rankingWeek = $rankingM -> where("uid",$ranking['uid']) -> find();
                    if(empty($rankingWeek)){
                        $rankingData = [
                            'uid' => $ranking['uid'],
                            'make_time' => $ranking['addtime'],
                            's_save' => $ranking['save'],
                            'addtime' => time(),
                        ];
                        $rankingRet = $rankingM->insert($rankingData);
                    }else{
                        $rankingData = [
                            'make_time' => max($ranking['addtime'],$rankingWeek['make_time']),
                            's_save' => $ranking['save'] + $rankingWeek['s_save'],
                        ];
                        $rankingRet = $rankingM->where("uid",$ranking['uid'])->update($rankingData);
                    }
                    if($rankingRet <= 0){
                        throw new \Exception("修改失败",100);
                    }
                    // 增加用户月省钱总数
                    $rankingMonthM = new RankingMonth();
                    // 判断是不是本月第一次成功下单
                    $rankingMonth = $rankingMonthM -> where("uid",$ranking['uid']) -> find();
                    if(empty($rankingMonth)){
                        $rankingMonthData = [
                            'uid' => $ranking['uid'],
                            'make_time' => $ranking['addtime'],
                            's_save' => $ranking['save'],
                            'addtime' => time(),
                        ];
                        $rankingMonthRet = $rankingMonthM->insert($rankingMonthData);
                    }else{
                        $rankingMonthData = [
                            'make_time' => max($ranking['addtime'],$rankingMonth['make_time']),
                            's_save' => $ranking['save'] + $rankingMonth['s_save'],
                        ];
                        $rankingMonthRet = $rankingMonthM->where("uid",$ranking['uid'])->update($rankingMonthData);
                    }
                    if($rankingMonthRet <= 0){
                        throw new \Exception("修改失败",200);
                    }
                }
                // 记录日记
                $adminInfo = session("adminInfo");
                if($adminInfo){
                    $data = [
                        'admin_id' => $adminInfo['id'],
                        'remark' => "管理者【".$adminInfo['username']."】修改订单编号:".$arr['order_sn'],
                        'ip' => $ip,
                        'addtime' => time()
                    ];
                    $logRet = (new AdminLog())->insert($data);
                    if($logRet <= 0){
                        throw new \Exception("修改订单信息失败",3);
                    }
                }

                // 提交事务
                Db::commit();
                return ret(1,"","订单修改成功");
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                return ret(-1,"",$e->getMessage());
            }

        }
        return ret(-1,"","参数错误");
    }

    /**
     * 支付成功后系统自动修改字段
     * @param $where array 条件
     * @param $data array 数据
     */
    public function modiOrderXitong($where,$data)
    {
        return (new Order())->where($where)->update($data);
    }

    /**
     * 用户取消订单
     */
    public function modiOrderUser($arr)
    {
        if($arr){
            $arr['order_state'] = 2;
            $number = (new Order())->where('order_sn',$arr['order_sn'])->update($arr);
            if($number){
                return ret(1,"","取消订单成功");
            }
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 用户选择货到付款
     */
    public function cashUpdate($arr)
    {
        if($arr){
            $arr['delivery_state'] = 1;
            $orderM = new Order();
            $number = $orderM->where('order_sn',$arr['order_sn'])->update($arr);
            if($number){
                $order = $orderM -> field("address,total") -> where("order_sn",$arr['order_sn']) -> find();
                $start = mb_strlen($order['address'],'utf-8')*1-10;
                $address = mb_substr($order['address'], $start, 10, 'utf8');
                $txt = "已有新的订单[".$arr['order_sn']."],货到付款[".$order['total']."],送货地址[".$address."]";
                (new SendDemo())->send(config("smsname.admin_phone"),"",$txt);
                return ret(1,"","下单成功");
            }
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 获取订单详情
     * @param $where array
     * @param $field string
     */
    public function getOrderGoodsFind($where,$field)
    {
        $ret = (new Order())->alias("o")
                            ->join("order_goods g","o.order_sn = g.order_sn")
                            ->field($field)
                            ->where($where)
                            ->select();
        return $ret;
    }

    /**
     * 获取最新下单信息
     * @param $where array
     * @param $field string
     */
    public function getOrderUserFind()
    {
        $where = [
            'delivery_state' => 3,
            'payment_state' => 1,
            'order_state' => 1
        ];
        $field = "u.nickname,u.photo,o.total,o.save";
        return (new Order())->alias("o")
                            ->join("user u","o.uid = u.id")
                            ->field($field)
                            ->where($where)
                            ->order("o.addtime desc")
                            ->find();
    }

}