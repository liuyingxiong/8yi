<?php
namespace app\admin\controller;

use app\common\logic\ActivityGoodsLogic;
use app\common\logic\GoodsCategoryLogic;
use app\common\logic\GoodsLogic;
use app\common\model\GoodsCategory;

class Goods extends Base
{
    /**
     * 商品列表页面
     */
    public function list()
    {
        $where = [];
        $arr = input('post.') ? input('post.') : false;
        //商品编码
        if (isset($arr['ss_goods_sn'])) {
            if (trim($arr['ss_goods_sn']) != "") {
                $where['goods_sn'] = ['like', '%' . trim($arr['ss_goods_sn']) . '%'];
            } else {
                unset($arr['ss_goods_sn']);
            }
        }
        //商品名称
        if (isset($arr['ss_goods_name'])) {
            if (trim($arr['ss_goods_name']) != "") {
                $where['goods_name'] = ['like', '%' . trim($arr['ss_goods_name']) . '%'];
            } else {
                unset($arr['ss_goods_name']);
            }
        }
        //所属分类
        if (isset($arr['category'])){
            if(trim($arr['category']) != "") {
                $where['cat_id'] = trim($arr['category']);
            } else {
                unset($arr['category']);
            }
        }
        //状态
        if (isset($arr['ss_on_sale'])) {
            if (trim($arr['ss_on_sale']) != "") {
                $where['is_on_sale'] = trim($arr['ss_on_sale']);
            } else {
                unset($arr['ss_on_sale']);
            }
        }
        $p = input("param.p") ? input("param.p") : 1;
        $this->assign('p',$p);
        $GoodsM = new GoodsLogic();
        $count = $GoodsM -> getGoodsCount($where);
        $page = adminPage($p,$count);
        $this->assign('page',$page);
        $this->assign('where',$where);
        $goods = $GoodsM->getGoodsInfo($where,"goods_id desc",$p);
        if(!empty($goods)){
            $goodsCM = new GoodsCategory();
            foreach ($goods as $k => $list){
                $res = $goodsCM->field("name")->where("id",$list['cat_id'])->find();
                $goods[$k]['cat_id'] = $res['name'];
            }
        }
        if (empty($goods)){
            return ret(-1,"","没有该商品");
        }
        $this->assign('goods',$goods);
        $goodsCate = (new GoodsCategoryLogic())->getCateSelect();
        $this->assign('goodsCate',$goodsCate);
        return $this->fetch();
    }

    /**
     * 添加商品页面
     */
    public function addgoods()
    {
        // 获取分类
        $cate = (new GoodsCategoryLogic())->getCategory("id,name,mobile_name");
        $this->assign('cate',$cate);

        return $this->fetch();
    }

    /**
     * 添加商品功能
     */
    public function addGoodsFun()
    {
        if($this->request->isAjax()){
            $arr = input("post.") ? input("post.") : false;
            if($arr){
                $arr['thumbnail_img'] = $arr['original_img'] = base64_image_content($arr['original_img'],"public/static/upload/goods");
                if(!$arr['thumbnail_img'] || !$arr['original_img']){
                    return ret(-1,"","图片上传失败");
                }
                $arr['on_time'] = time();
                $res = (new GoodsLogic())->addGoods($arr,$this->request->ip());
                return $res;
            }
            return $arr;
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 删除功能
     */
    public function delGoods()
    {
        if($this->request->isAjax()){
            $arr = input("post.goods_id") ? input("post.goods_id") : false;
            if($arr){
                $res = (new GoodsLogic())->delGoods(['goods_id'=>$arr],$this->request->ip());
                return $res;
            }
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 修改商品信息
     */
    public function modifyGoods()
    {
        if($this->request->isAjax()){
            $arr = input("") ? input("") : false;
            if($arr){
                if(isset($arr['original_img']) && $arr['original_img']){
                    $arr['thumbnail_img'] = $arr['original_img'] = base64_image_content($arr['original_img'],"public/static/upload/goods");
                    if(!$arr['thumbnail_img'] || !$arr['original_img']){
                        return ret(-1,"","图片上传失败");
                    }
                }
                // 获取最高价格
                if(isset($arr['market_price']) && isset($arr['taobao_price']) && isset($arr['huarun_price'])){
                    $arr['tiptop'] = max($arr['market_price'],$arr['taobao_price'],$arr['huarun_price']);
                    switch ($arr['tiptop'])
                    {
                        case $arr['market_price']:
                            $arr['tiptop'] = 0;
                            break;
                        case $arr['taobao_price']:
                            $arr['tiptop'] = 1;
                            break;
                        case $arr['huarun_price']:
                            $arr['tiptop'] = 2;
                            break;
                        default:
                            $arr['tiptop'] = 0;
                    }
                }
                $res = (new GoodsLogic())->modiGoods($arr,$this->request->ip());
                return $res;
            }
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 编辑商品页面
     */
    public function goodsedit()
    {
        if($this->request->isAjax()){
            $goods_id = input("post.goods_id") ? input("post.goods_id") : false;
            if(!$goods_id){
                return ret(-1,"","参数错误");
            }
            // 获取分类
            $cate = (new GoodsCategoryLogic())->getCategory("id,name,mobile_name");
            $this->assign('cate',$cate);
            // 获取商品信息
            $goodsEdit = (new GoodsLogic())->getGoodsFindInfo(['goods_id'=>$goods_id]);
            $this->assign('goodsEdit',$goodsEdit);
            return $this->fetch();
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 商品分类页面
     */
    public function tabulation()
    {
        $cate = (new GoodsCategoryLogic())->getCateSelect();
        $this->assign('cate',$cate);
        return $this->fetch();
    }

    /**
     * 修改商品分类
     */
    public function modifyCate()
    {
        if($this->request->isAjax()){
            $arr = input("") ? input("") : false;
            if($arr){
                $res = (new GoodsCategoryLogic())->modiCate($arr,$this->request->ip());
                return $res;
            }
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 添加商品分类页面
     */
    public function addcate()
    {
        $cateList = (new GoodsCategoryLogic())->getCateSelect();
        $this->assign('cateList',$cateList);
        return $this->fetch();
    }

    /**
     * 添加商品分类
     */
    public function addCateFun()
    {
        if($this->request->isAjax()){
            $arr = input("post.") ? input("post.") : false;
            if($arr){
                $arr['name'] = trim($arr['name']);
                $arr['mobile_name'] = trim($arr['mobile_name']);
              	$arr['mobile_url'] = "/mobile/goods/index.html";
                if(empty($arr['image'])){
                    return ret(-1,"","请选择手机端显示图片");
                }else{
                    $arr['image'] = base64_image_content($arr['image'],"public/static/mobile/img");
                }
                if(!empty($arr['pc_image'])){
                    $arr['pc_image'] = base64_image_content($arr['pc_image'],"public/static/home/img");
                }else{
                    unset($arr['pc_image']);
                }
                $res = (new GoodsCategoryLogic())->addCate($arr,$this->request->ip());
                return $res;
            }
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 删除商品分类
     */
    public function delCate()
    {
        if($this->request->isAjax()){
            $arr = input("post.") ? input("post.") : false;
            if($arr){
                $res = (new GoodsCategoryLogic())->delCate($arr,$this->request->ip());
                return $res;
            }
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 商品套餐(活动)
     */
    public function meal_list()
    {
        $actGoodsM = new ActivityGoodsLogic();
        // 页数
        $p = input("param.p") ? input("param.p") : 1;
        $this->assign('p',$p);
        // 数据总数  分页
        $count = $actGoodsM->getCount();
        $page = adminPage($p,$count);
        $this->assign('page',$page);
        // 数据
        $act_goods = $actGoodsM->getActivitySet([],"*","act_goods_id DESC",$p);
        $this->assign('act_goods',$act_goods);
        return $this->fetch();
    }

    /**
     * 商品套餐(活动)增加或者修改页面
     */
    public function meal_show()
    {
        if($this->request->isAjax()){
            $act_goods_id = input("param.act_goods_id") ? input("param.act_goods_id") : 1;
            $act_meal = (new ActivityGoodsLogic())->getActivityFind(['act_goods_id'=>$act_goods_id]);
            if(!empty($act_meal)){
                $h_span = "修改商品套餐";
                $button = "修改";
            }else{
                $h_span = "添加商品套餐";
                $button = "添加";
            }
            $this->assign('h_span',$h_span);
            $this->assign('button',$button);
            $this->assign('act_meal',$act_meal);
            return $this->fetch();
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 商品套餐(活动)增加   或者  修改
     */
    public function addmeal()
    {
        if($this->request->isAjax()){
            $arr = input("post.") ? input("post.") : false;
            if(!isset($arr['title'])){
                return ret(-1,"","请输入套餐名称");
            }
            if(isset($arr['img']) && trim($arr['img']) != ""){
                $arr['img'] = base64_image_content($arr['img'],"public/static/upload/activity");
                if(!$arr['img']){
                    return ret(-1,"","图片上传失败");
                }
            }
            if($arr['s_time'] >= $arr['e_time'] || !isset($arr['s_time']) || !isset($arr['e_time'])){
                return ret(-1,"","时间范围选择错误");
            }
            $arr['s_time'] = strtotime($arr['s_time']);
            $arr['e_time'] = strtotime($arr['e_time']);
            if(!isset($arr['market_price']) || !isset($arr['price'])){
                return ret(-1,"","价格不能为空");
            }
            $ret = (new ActivityGoodsLogic())->addActGoods($arr);
            return $ret;
        };
        return ret(-1,"","参数错误");
    }

    /**
     * 商品套餐上下架
     */
    public function statemeal()
    {
        if($this->request->isAjax()){
            $arr = input("post.") ? input("post.") : false;
            if($arr){
                return (new ActivityGoodsLogic())->addActGoods($arr);
            }
        };
        return ret(-1,"","参数错误");
    }

    /**
     * 删除商品套餐
     */
    public function delmeal()
    {
        if($this->request->isAjax()){
            $act_goods_id = input("post.act_goods_id") ? input("post.act_goods_id") : false;
            $img = input("post.img") ? input("post.img") : false;
            if($act_goods_id && $img){
                $ret = (new ActivityGoodsLogic())->delActGoods($act_goods_id,$img);
                return $ret;
            }
        };
        return ret(-1,"","参数错误");
    }
}
