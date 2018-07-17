<?php
namespace app\mobile\controller;

use app\common\logic\ComLogic;
use app\common\logic\UserLogic;
use app\common\model\ComIds;
use app\common\model\ComText;

class Message extends Base
{
    protected $foot = "消息";

    /**
     * 消息首页
     */
    public function index()
    {
        $this->assign('value',$this->foot);
        return $this->fetch();
    }

    /**
     *进入邻里心愿或发布吐槽页面的时候更新数据库的进入时间
     */
    private function getPageTime()
    {
        (new UserLogic())->updateInto(["id"=>session("user")['id']],["message_time"=>time()]);
    }

    /**
     * 社区圈吐槽-信息列表
     */
    public function community()
    {
        $this->getPageTime();

        $field = "c.*,u.nickname,u.photo,u.sex";
        $messageList = (new ComLogic())->getComSelect($field);
        if(!empty($messageList)) {
            $comTxtM = new ComText();
            $ids = new ComIds();
            foreach ($messageList as $k => $list) {
                if (!empty($messageList[$k]['com_imgs'])) {
                    $messageList[$k]['com_imgs'] = json_decode($messageList[$k]['com_imgs'], true);
                }
                $messageList[$k]['clied'] = $comTxtM->field("product_id,product_name,product_text,reply_id,reply_name,type")->where("com_id", $list['com_id'])->select();
                $messageList[$k]['count'] = $ids->where("com_id", $list['com_id'])->count();
                $count = $ids->where(['com_id'=>$list['com_id'],"uid"=>session("user")['id']])->count();
                if($count > 0){
                    $messageList[$k]['zan'] = "/public/static/mobile/svg/zan_act.svg";
                }else{
                    $messageList[$k]['zan'] = "/public/static/mobile/svg/zan2.svg";
                }
            }
        }
        $this->assign('messageList',$messageList);
        return $this->fetch();
    }

    /**
     * 社区圈吐槽-发布吐槽信息页面
     */
    public function release_community()
    {
        $this->getPageTime();

        return $this->fetch();
    }

    /**
     * 社区圈吐槽-添加吐槽信息
     */
    public function communityAdd()
    {
        if($this->request->isPost()){
            $arr = input("post.") ? input("post.") : false;
            if($arr){
                $arr['uid'] = session("user")['id'];
                $arr['create_time'] = time();
                // 有图片的时候
                if(isset($arr['com_imgs'])){
                    $imgs = [];
                    foreach($arr['com_imgs'] as $k =>  $list){
                        $imgs[$k] = base64_image_content($list,"public/static/upload/message",time().$k);
                    }
                    $arr['com_imgs'] = json_encode($imgs);
                }
                $data=(new ComLogic())->getAdd($arr);
                if($data['ret'] == 1){
                    $this->redirect(url('Message/community'));
                }else{
                    $this->errorJQ($data['msg'],2000);
                }
            }
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 评论 或者  回復  信息  添加功能
     */
    public function realy()
    {
        if($this->request->isAjax()){
            $arr = input("post.") ? input("post.") : false;
            if($arr){
                $ret = (new ComLogic())->comTxtAdd($arr);
                if($ret['ret'] == 1) {
                    $txtList = (new ComText())->field("product_id,product_name,product_text,reply_id,reply_name,type")->where("com_id", $arr['id'])->select();
                    $code = "";
                    foreach ($txtList as $list) {
                        switch ($list['type']) {
                            case 1:
                                $code .= "<li><a href='javascript:void(0)' class='reply_a' data-product_id='" . $list['product_id'] . "'>" . $list['product_name'] . "<span style='color: palevioletred;'> 回复 </span>" . $list['reply_name'] . "：" . $list['product_text'] . "</a></li>";
                                break;
                            default:
                                $code .= "<li><a href='javascript:void(0)' class='reply_a' data-product_id='" . $list['product_id'] . "'>" . $list['product_name'] . "：" . $list['product_text'] . "</a></li>";
                        }
                    }
                    $ret = ret(1, $code, $ret['msg']);
                }
                return $ret;
            }
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 吐槽 点赞功能
     */
    public function fabulous()
    {
        if ($this->request->isAjax()) {
            $com_id = input("post.com_id") ? input("post.com_id") : false;
            if($com_id && $com_id > 0){
                $comIdsM = new ComIds();
                $where = [
                    'com_id'=>$com_id,
                    "uid"=>session("user")['id'],
                ];
                $sel = $comIdsM->where($where)->find();
                if($sel){       // 取消关注
                    $ret = $comIdsM -> where($where) -> delete();
                    $code = "/public/static/mobile/svg/zan2.svg";
                    $msg = "取消关注成功";
                }else{          // 关注
                    $ret = $comIdsM -> insert($where);
                    $code = "/public/static/mobile/svg/zan_act.svg";
                    $msg = "关注成功";
                }
                if($ret){
                    return ret(1,$code,$msg);
                }
            }
        }
        return ret(-1,"","参数错误");
    }
}
