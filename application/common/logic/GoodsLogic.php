<?php

namespace app\common\logic;

use app\common\model\AdminLog;
use app\common\model\Goods;
use think\Db;
use think\Model;

class GoodsLogic extends Model
{
    /**
     * 获取热销商品
     */
    public function getGoodsHot()
    {
        return (new Goods())->where("is_on_sale",1)->order("hot_count desc,goods_id")->limit(10)->select();
    }

    /**
     * 获取商品信息
     * @param $where
     * @param $order
     * @param $p
     */
    public function getGoodsInfo($where=[],$order="goods_id ASC",$p=0)
    {
        if($p > 0){
            $s = ($p-1)*10;
            return (new Goods())->where($where)->order($order)->limit($s,10)->select();
        }
        return (new Goods())->where($where)->order($order)->select();
    }

    /**
     * 获取单商品信息
     * @param $where
     */
    public function getGoodsFindInfo($where)
    {
        return (new Goods())->where($where)->find();
    }

    /**
     * 条件获取商品总数
     * @param $where
     */
    public function getGoodsCount($where=[])
    {
        return (new Goods())->where($where)->count();
    }

    /**
     * 商品修改
     * @param $arr array
     * @param $ip string 修改者IP地址
     */
    public function modiGoods($arr,$ip)
    {
        if($arr && $ip){
            Db::startTrans();
            try{
                $old_original_img = "";
                // 不是修改状态的情况下
                if(isset($arr['original_img']) && isset($arr['old_original_img'])){
                    if(!$arr['original_img']){
                        unset($arr['original_img']);
                    }else{
                        $old_original_img = $arr['old_original_img'];
                    }
                    unset($arr['old_original_img']);
                    /*if(!$arr['thumbnail_img']){
                        unset($arr['thumbnail_img']);
                    }*/
                }
                // 修改数据
                $adminRet = (new Goods())->update($arr);
                if(!$adminRet){
                    throw new \Exception("参数错误",1);
                }
                // 删除图片
                @unlink(substr($old_original_img,1));
                $adminInfo = session("adminInfo");
                $f = "";
                foreach($arr as $key => $list){
                    if($key != 'goods_id'){
                        $f .= "字段[ ".$key." ]的数据修改为【".$list."】,";
                    }
                }
                // 记录操作日记
                $data = array(
                    'admin_id' => $adminInfo['id'],
                    'remark' => "管理者【".$adminInfo['username']."】修改商品ID：".$arr['goods_id']." ,".$f,
                    'ip' => $ip,
                    'addtime' => time()
                );
                $logRet = (new AdminLog())->insert($data);
                if($logRet <= 0){
                    throw new \Exception("系统错误",2);
                }
                // 提交事务
                Db::commit();
                return ret(1,"","修改成功");
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                return ret(-1,"",$e->getMessage());
            }
        };
        return ret(-1,"","参数错误");
    }

    /**
     * 商品添加
     * @param $arr array
     * @param $ip string
     */
    public function addGoods($arr,$ip)
    {
        if($arr && $ip){
            Db::startTrans();
            try{
                $goodsM = new Goods();
                // 添加数据
                $adminRet = $goodsM->insertGetId($arr);
                if(!$adminRet){
                    throw new \Exception("参数错误",1);
                }
                // 修改商品编码
                $arr['goods_sn'] = "TP";
                $length = 7 - strlen($adminRet);
                for($i = 0; $i < $length; $i++){
                    $arr['goods_sn'] .= 0;
                }
                $arr['goods_sn'] .= $adminRet;
                $goodsRet = $goodsM->where("goods_id",$adminRet)->update($arr);
                if(!$goodsRet){
                    throw new \Exception("参数错误",3);
                }
                $adminInfo = session("adminInfo");
                // 记录操作日记
                $data = array(
                    'admin_id' => $adminInfo['id'],
                    'remark' => "管理者【".$adminInfo['username']."】添加商品ID：".$adminRet,
                    'ip' => $ip,
                    'addtime' => time()
                );
                $logRet = (new AdminLog())->insert($data);
                if($logRet <= 0){
                    throw new \Exception("系统错误",2);
                }
                // 提交事务
                Db::commit();
                return ret(1,"","添加成功");
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                return ret(-1,"",$e->getMessage());
            }
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 商品删除
     * @param $where array
     * @param $ip string
     */
    public function delGoods($where,$ip)
    {
        if($where && $ip){
            Db::startTrans();
            try{
                $goodsM = new Goods();
                // 查出要删除的数据
                $delInfo = $goodsM->field("goods_id,original_img,thumbnail_img")->where($where)->select();
                if(!$delInfo){
                    throw new \Exception("参数错误",0);
                }
                // 删除数据
                $adminRet = $goodsM->where($where)->delete();
                if(!$adminRet){
                    throw new \Exception("参数错误",1);
                }
                // 删除图片
                $adminInfo = session("adminInfo");
                $remark = "管理者【".$adminInfo['username']."】删除商品ID：";
                foreach ($delInfo as $list){
                    $remark .= $list['goods_id'] ."; ";
                    @unlink(substr($list['original_img'],1));
                    @unlink(substr($list['thumbnail_img'],1));
                }
                // 记录操作日记
                $data = array(
                    'admin_id' => $adminInfo['id'],
                    'remark' => $remark,
                    'ip' => $ip,
                    'addtime' => time()
                );
                $logRet = (new AdminLog())->insert($data);
                if($logRet <= 0){
                    throw new \Exception("系统错误",2);
                }
                // 提交事务
                Db::commit();
                return ret(1,"","删除成功");
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                return ret(-1,"",$e->getMessage());
            }
        }
        return ret(-1,"","参数错误");
    }
}