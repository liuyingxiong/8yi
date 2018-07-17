<?php
namespace app\admin\controller;

use app\common\logic\PrizesLogic;

class Prize extends Base
{
    /**
     * 排行榜奖励列表
     */
    public function reward_list()
    {
        // 页数
        $p = input("param.p") ? input("param.p") : 1;
        $this->assign('p',$p);
        // 分页
        $prizesM = new PrizesLogic();
        $count = $prizesM->getCount();
        $page = adminPage($p,$count);
        $this->assign('page',$page);
        // 数据
        $prizes = $prizesM->getSe([],"id DESC",$p);
        $this->assign('prizes',$prizes);
        return $this->fetch();
    }

    /**
     * 添加 或者 修改 奖品页面
     */
    public function add_prize_show()
    {
        if($this->request->isAjax()){
            $id = input("post.id") ? input("post.id") : false;
            if($id){
                $prize_row = (new PrizesLogic())->getFind(['id'=>$id]);
                $this->assign("prize_row",$prize_row);
                $h_span = "修改奖励";
                $button = "修改";
            }else{
                $h_span = "添加奖励";
                $button = "添加";
            }
            $this->assign('button',$button);
            $this->assign('h_span',$h_span);
            return $this->fetch();
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 添加 或者 修改 奖品功能
     */
    public function add_prize()
    {
        if($this->request->isAjax()){
            $data = input("post.") ? input("post.") : false;
            if($data){
                if(isset($data['id']) && $data['id'] > 0){          // 修改
                    $ret = (new PrizesLogic()) -> modiPrize($data);
                }else{                                              // 添加
                    $ret = (new PrizesLogic()) -> getUserMonth($data);
                }
                return $ret;
            }
        }
        return ret(-1,"","参数错误");
    }

}
