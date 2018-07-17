<?php

namespace app\common\logic;

use app\common\model\Prizes;
use think\Model;

class PrizesLogic extends Model
{
    /**
     * 添加奖励
     * @param $arr array 数组
     */
    public function getUserMonth($arr)
    {
        if($arr){
            // 判断是否有正在进行的活动
            $row = $this->getFind(['state'=>1]);
            if(!empty($row)){
                return ret(-1,"","已经有正在进行的活动,不能再次添加！");
            }
            // 判断参数
            if(!isset($arr['stage']) || empty($arr['stage'])){
                return ret(-1,"","请输入期数！");
            }
            if(!isset($arr['one_des']) || !isset($arr['two_des']) || !isset($arr['three_des']) || !isset($arr['x_one_des']) || !isset($arr['x_two_des']) || !isset($arr['x_three_des'])){
                return ret(-1,"","奖品描述不能为空！");
            }
            if(!isset($arr['one_img']) || !isset($arr['two_img']) || !isset($arr['three_img']) || !isset($arr['x_one_img']) || !isset($arr['x_two_img']) || !isset($arr['x_three_img'])){
                return ret(-1,"","奖品图片不能空！");
            }
            if(!isset($arr['s_time']) || !isset($arr['e_time'])){
                return ret(-1,"","开始时间与结束时间不能为空！");
            }
            $time = time();
            $arr['one_img'] = base64_image_content($arr['one_img'],"public/static/upload/prize",$time."one");
            if(!$arr['one_img']){
                return ret(-1,"","图片上传失败");
            }
            $arr['two_img'] = base64_image_content($arr['two_img'],"public/static/upload/prize",$time."two");
            if(!$arr['two_img']){
                return ret(-1,"","图片上传失败");
            }
            $arr['three_img'] = base64_image_content($arr['three_img'],"public/static/upload/prize",$time."three");
            if(!$arr['three_img']){
                return ret(-1,"","图片上传失败");
            }
            $arr['x_one_img'] = base64_image_content($arr['x_one_img'],"public/static/upload/prize",$time."xone");
            if(!$arr['x_one_img']){
                return ret(-1,"","图片上传失败");
            }
            $arr['x_two_img'] = base64_image_content($arr['x_two_img'],"public/static/upload/prize",$time."xtwo");
            if(!$arr['x_two_img']){
                return ret(-1,"","图片上传失败");
            }
            $arr['x_three_img'] = base64_image_content($arr['x_three_img'],"public/static/upload/prize",$time."xthree");
            if(!$arr['x_three_img']){
                return ret(-1,"","图片上传失败");
            }
            $arr['s_time'] = strtotime($arr['s_time']);
            $arr['e_time'] = strtotime($arr['e_time']);
            $arr['addtime'] = $time;
            $ret = (new Prizes())->insert($arr);
            if($ret){
               return ret(1,"","添加奖励成功");
            }else{
                return ret(-1,"","添加失败");
            }
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 修改奖励
     * @param $arr array 数组
     */
    public function modiPrize($arr)
    {
        if($arr){
            if(!isset($arr['stage']) || empty($arr['stage'])){
                return ret(-1,"","请输入期数！");
            }
            if(!isset($arr['one_des']) || !isset($arr['two_des']) || !isset($arr['three_des']) || !isset($arr['x_one_des']) || !isset($arr['x_two_des']) || !isset($arr['x_three_des'])){
                return ret(-1,"","奖品描述不能为空！");
            }
            if(!isset($arr['s_time']) || !isset($arr['e_time'])){
                return ret(-1,"","开始时间与结束时间不能为空！");
            }
            $time = time();
            if(isset($arr['one_img'])){
                if(empty($arr['one_img'])){
                    unset($arr['one_img']);
                }else{
                    $arr['one_img'] = base64_image_content($arr['one_img'],"public/static/upload/prize",$time."one");
                    if(!$arr['one_img']){
                        return ret(-1,"","图片上传失败");
                    }
                }
            }
            if(isset($arr['two_img'])){
                if(empty($arr['two_img'])){
                    unset($arr['two_img']);
                }else{
                    $arr['two_img'] = base64_image_content($arr['two_img'],"public/static/upload/prize",$time."two");
                    if(!$arr['two_img']){
                        return ret(-1,"","图片上传失败");
                    }
                }
            }
            if(isset($arr['three_img'])){
                if(empty($arr['three_img'])){
                    unset($arr['three_img']);
                }else{
                    $arr['three_img'] = base64_image_content($arr['three_img'],"public/static/upload/prize",$time."three");
                    if(!$arr['three_img']){
                        return ret(-1,"","图片上传失败");
                    }
                }
            }
            if(isset($arr['x_one_img'])){
                if(empty($arr['x_one_img'])){
                    unset($arr['x_one_img']);
                }else{
                    $arr['x_one_img'] = base64_image_content($arr['x_one_img'],"public/static/upload/prize",$time."xone");
                    if(!$arr['x_one_img']){
                        return ret(-1,"","图片上传失败");
                    }
                }
            }
            if(isset($arr['x_two_img'])){
                if(empty($arr['x_two_img'])){
                    unset($arr['x_two_img']);
                }else{
                    $arr['x_two_img'] = base64_image_content($arr['x_two_img'],"public/static/upload/prize",$time."xtwo");
                    if(!$arr['x_two_img']){
                        return ret(-1,"","图片上传失败");
                    }
                }
            }
            if(isset($arr['x_three_img'])){
                if(empty($arr['x_three_img'])){
                    unset($arr['x_three_img']);
                }else{
                    $arr['x_three_img'] = base64_image_content($arr['x_three_img'],"public/static/upload/prize",$time."xthree");
                    if(!$arr['x_three_img']){
                        return ret(-1,"","图片上传失败");
                    }
                }
            }
            $arr['s_time'] = strtotime($arr['s_time']);
            $arr['e_time'] = strtotime($arr['e_time']);
            $ret = (new Prizes())->where("id",$arr['id'])->update($arr);
            if($ret){
                return ret(1,"","修改奖励成功");
            }else{
                return ret(-1,"","修改奖励失败");
            }
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 获取总数
     * @param $where array 条件
     */
    public function getCount($where=[])
    {
        return (new Prizes())->where($where)->count();
    }

    /**
     * 获取数据
     * @param $where array  条件
     * @param $p     int    页数
     * @param $order string 排序
     */
    public function getSe($where,$order="id DESC",$p=0)
    {
        if($p > 0){
            $s = ($p-1)*10;
            return (new Prizes())->where($where)->order($order)->limit($s,10)->select();
        }
        return (new Prizes())->where($where)->order($order)->select();
    }

    /**
     * 获取单条数据
     * @param $where array  条件
     * @param $filed string 字段名
     */
    public function getFind($where,$order="stage DESC",$filed="*")
    {
        return (new Prizes())->field($filed)->where($where)->find();
    }

}