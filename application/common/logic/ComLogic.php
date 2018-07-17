<?php

namespace app\common\logic;

use app\common\model\Com;
use app\common\model\ComText;
use app\common\model\User;
use think\Model;

class ComLogic extends Model
{
    /**
     * 双表查询吐槽数据
     * @param oneTable - lj_com as c    threeTable - lj_user as u
     * @param $where array 条件
     * @param $field string 字段
     * @param $order string 排列顺序
     * @param $p int 页面
     */
    public function getComSelect( $field, $p=0, $order='c.com_id DESC')
    {
        if( !$field){
            return ret(-1,"","参数错误");
        }
        if($p >= 1){
            $s = $p*10+1;
            $e = 10;
            return (new Com())->alias("c")
                              ->field($field)
                              ->join("user u","c.uid = u.id",'left')
                              ->limit($s,$e)
                              ->order($order)
                              ->select();
        }
        return (new Com())->alias("c")
                          ->field($field)
                          ->join("user u","c.uid = u.id",'left')
                          ->order($order)
                          ->select();
    }

    /**
     * 添加吐槽   tableName  com
     * @param $data array
     * @return int|string
     */
    public function getAdd($data)
    {
        if($data){
            $msg = (new Com())->insert($data);
            if($msg){
                return ret(1,"","");
            }
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 添加评论
     * @param $data array
     */
    public function comTxtAdd($data)
    {
        if($data){
            $dataAdd = [
                'com_id' => $data['id'],
                'addtime' => time(),
                'type' => $data['type'],
            ];
            $user = session("user");
            if(empty($user['nickname'])){
                $user['nickname'] = "匿名";
            }
            switch ($data['type'])
            {
                case 0:       // 添加评论
                    $msg = "评论成功";
                    $code = "<li><a href='javascript:void(0)' class='reply_a' data-product_id='".$user['id']."'>".$user['nickname']."：".$data['txt']."</a></li>";
                    break;
                case 1:       // 添加回复
                    $userReply = (new User())->field("nickname")->where("id",$data['product_id'])->find();
                    if(!$userReply || !$userReply['nickname']){
                        return ret(-1,"","参数错误");
                    }
                    $dataAdd['type'] = 1;
                    $dataAdd['reply_id'] = $data['product_id'];
                    $dataAdd['reply_name'] = $userReply['nickname'];
                    $msg = "回复成功";
                    $code = "<li><a href='javascript:void(0)' class='reply_a' data-product_id='".$user['id']."'>".$user['nickname']."<span style='color: palevioletred;'> 回复 </span>".$userReply['nickname']."：".$data['txt']."</a></li>";
                    break;
                default:
                    return ret(-1,"","参数错误");
            }
            $dataAdd['product_id'] = $user['id'];
            $dataAdd['product_name'] = $user['nickname'];
            $dataAdd['product_text'] = $data['txt'];
            $ret = (new ComText())->insert($dataAdd);
            if($ret){
                return ret(1,$code,$msg);
            }
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 获取吐槽表总条数
     * @param $where array 条件
     */
    public function getCount($where)
    {
        return (new Com())->where($where)->count();
    }

    /**
     * 双表查询总条数
     * tableOne name ComText as t  &&  tableTwo name Com as c
     * @param $where array 条件
     */
    public function getComTextCount($where)
    {
        return (new ComText())->alias("t")
                              ->join("com c","t.com_id = c.com_id")
                              ->where($where)
                              ->count();
    }
}