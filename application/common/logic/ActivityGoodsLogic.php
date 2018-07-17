<?php

namespace app\common\logic;

use app\common\model\ActivityGoods;
use think\Model;

class ActivityGoodsLogic extends Model
{
    /**
     * 获取商品活动套餐
     * @param $where array 条件
     * @param $field string 字段名
     * @param $order string 排序
     * @param $p int 页面数
     * return array
     */
    public function getActivitySet($where=[],$field="*",$order="act_goods_id ASC",$p=0)
    {
        if($p > 0){
            $s = ($p-1)*10;
            return (new ActivityGoods())->field($field)->where($where)->order($order)->limit($s,10)->select();
        }
        return (new ActivityGoods())->field($field)->where($where)->order($order)->select();
    }

    /**
     * 获取商品活动套餐总条数
     * $param $where array 条件
     * return int
     */
    public function getCount($where=[])
    {
        return (new ActivityGoods())->where($where)->count();
    }

    /**
     * 获取商品活动套餐单条数据
     * @param $where array 条件
     * return array
     */
    public function getActivityFind($where)
    {
        return (new ActivityGoods())->where($where)->find();
    }

    /**
     * 增加商品活动数据   ||   修改商品套餐
     * @param $data array 数组
     */
    public function addActGoods($data)
    {
        if($data){
            if(isset($data['goods_name']) && isset($data['goods_number'])){
                $data['goods'] = "";
                $brr = [];
                foreach($data['goods_name'] as $k => $list){
                    if(!empty($data['goods_name'][$k]) && !empty($data['goods_number'][$k])){
                        $arr = [
                            'goods_name' => $data['goods_name'][$k],
                            'goods_number' => $data['goods_number'][$k],
                        ];
                        $brr[] = $arr;
                    }
                }
                if(!empty($brr)){
                    $data['goods'] = json_encode($brr,true);
                }
                unset($data['goods_name']);
                unset($data['goods_number']);
            }
            if(isset($data['img']) && trim($data['img']) == ""){
                unset($data['img']);
            }
            if(isset($data['act_goods_id'])){
                $ret = (new ActivityGoods())->where("act_goods_id",$data['act_goods_id'])->update($data);
                $msg = "修改";
            }else{
                $ret = (new ActivityGoods())->insert($data);
                $msg = "增加";
            }
            if($ret){
                return ret(1,"",$msg."商品套餐成功");
            }else{
                return ret(-1,"",$msg."商品套餐失败");
            }
        }
        return ret(-1,'',"参数错误");
    }

    /**
     * 删除商品套餐
     * $param $act_goods_id int ID
     * @param $img string 图片路径
     */
    public function delActGoods($act_goods_id,$img)
    {
        if($act_goods_id){
            @unlink(substr($img,1));
            $ret = (new ActivityGoods())->where("act_goods_id",$act_goods_id)->delete();
            if($ret){
                return ret(1,"","删除成功");
            }
        }
        return ret(-1,"","参数错误");
    }

}