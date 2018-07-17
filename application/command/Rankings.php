<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/9 0009
 * Time: 13:35
 * 每周排行定时任务
 */
namespace app\command;

use app\common\model\RankingHistory;
use app\common\model\RankingWeek;
use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\Db;

class Rankings extends Command
{
    protected function configure()
    {
        //设置参数
        $this->setName('rankings')->setDescription('Update User Rankings');
    }

    /*
     * 最后执行的命令
     * @param Input $input
     * @param Output $output
     */
    protected function execute(Input $input, Output $output)
    {
        set_time_limit(0);
        // 获取参数
        $yesterday = strtotime("-1 day");
        $time = strtotime(date("Y-m-d",$yesterday)." 23:59:59");
        $rankingData = array();
        // 判断
        if(date("w",$yesterday) == 0){        // 昨天是星期天
            // 获取周排行榜的数据
            $weekList = (new RankingWeek()) ->alias("w")
                                            ->join("user u","w.uid = u.id")
                                            ->field("w.uid,w.s_save as save_week,w.make_time,u.nickname")
                                            ->order("w.s_save DESC,w.make_time ASC")
                                            ->select();

            // 判断不能为空数据
            if(!empty($weekList)){
                foreach($weekList as $k => $list){
                    $arr = [
                        "uid" => $list['uid'],
                        "nickname" => $list['nickname'],
                        'sort' => $k+1,
                        "save_week" => $list['save_week'],
                        'make_time' => $list['make_time'],
                        'addtime' => $time,
                    ];
                    $rankingData[] = $arr;
                }
            }

            // 判断插入的数据不为空
            if(!empty($rankingData) && isset($rankingData)){
                // 启动事务
                Db::startTrans();
                try{
                    // 插入数据
                    $retR = (new RankingHistory())->insertAll($rankingData);
                    if($retR <= 0 || !$retR){
                        throw new \Exception("插入周排行榜历史记录表失败",1);
                    }
                    // 删除数据
                    $retRW = (new RankingWeek())->where("1=1")->delete();
                    if($retRW <= 0 || !$retRW){
                        throw new \Exception("删除上周排行榜记录表失败",2);
                    }
                    // 提交事务
                    Db::commit();
                    $msg = date("Y-m-d",$yesterday).",SUCCESS_上周排行榜记录成功";
                } catch (\Exception $e) {
                    // 回滚事务
                    Db::rollback();
                    $msg = date("Y-m-d",$yesterday).",ERROR_".$e->getMessage();
                }
            }else{
                $msg = date("Y-m-d",$yesterday).",SUCCESS_上周排行榜数据为空";
            }
        }else{                                        // 不是星期天
            $msg = date("Y-m-d",$yesterday).",SUCCESS_昨天不是星期天";
        }
        $output->writeln($msg);
        $output->writeln("
                ============================
                ----------Finished----------
                ============================
            ");
    }
}