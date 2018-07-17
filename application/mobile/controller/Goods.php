<?php
namespace app\mobile\controller;

use app\common\logic\ActivityGoodsLogic;
use app\common\logic\GoodsCategoryLogic;
use app\common\logic\GoodsLogic;
use app\common\logic\OrderLogic;
use app\common\logic\RankingMonthLogic;
use think\Db;

class Goods extends Base
{
    /**
     * 商品列表
     * @return mixed
     */
    public function index()
    {
        // 获取参数
        $cateType = input("param.catetype") ? input("param.catetype") : 1;
        $this->assign('cate_id',$cateType);
        // 获取商品类别
        $category = (new GoodsCategoryLogic())->getCategory("id,mobile_name,index");
        $this->assign('category',$category);
        // 获取商品
        $shop = [];
        $goodsM = new GoodsLogic();
        //  --*-- 先下掉热销商品
        /*$shop[0] = [
            'title' => "热销",
            'content' => $goodsM->getGoodsHot(),
        ];*/
        //  --*-- 先下掉热销商品
        foreach($category as $k => $item){
            /*$i = $k+1;
            $shop[$i] = [
                'title' => $item['mobile_name'],
                'content' => $goodsM->getGoodsInfo(['cat_id'=>$item['id']]),
            ];*/
            $shop[$item['index']] = [
                'title' => $item['mobile_name'],
                'content' => $goodsM->getGoodsInfo(['cat_id'=>$item['id'],"is_on_sale"=>1],"sort ASC,goods_id ASC"),
            ];
        }
        $this->assign('shop',$shop);
        // 已经选中的商品
        // --*-- 先下掉返回商品选择状态
        session("goods",null);
        // --*-- 先下掉返回商品选择状态
        $is_goods = session("goods");
        $this->assign('is_goods',$is_goods);
        return $this->fetch();
    }

    /**
     * 便利店首页
     */
    public function store_index()
    {
        // 获取二级导航
        $menu = (new GoodsCategoryLogic())->getGoodsMenu();
        $menu_count = count($menu);
        $number = ceil($menu_count/10);
        $this->assign('menu_count',$menu_count);
        $this->assign('number',$number);
        $this->assign('menu',$menu);
        // 获取当月排行榜前三名
        $rankingUser = (new RankingMonthLogic())->getUserMonth(3);
        $this->assign("rankingUser",$rankingUser);
        // 获取最近一次订单信息
        $order = (new OrderLogic())->getOrderUserFind();
        $this->assign('order',$order);
        // 获取商品活动套餐
        $time = time();
        $where = [
            'state' => 1,
            's_time' => ['<=',$time],
            'e_time' => ['>',$time],
        ];
        $act_goods = (new ActivityGoodsLogic())->getActivitySet($where);
        $this->assign('act_goods',$act_goods);
        // 获取消息推送
        $this->getTotalNum();
        return $this->fetch();
    }

    /**
     * 历史购买
     */
    public function history()
    {
        echo "历史购买";
    }

}
