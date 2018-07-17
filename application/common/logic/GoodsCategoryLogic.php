<?php

namespace app\common\logic;

use app\common\model\AdminLog;
use app\common\model\GoodsCategory;
use think\Db;
use think\Model;

class GoodsCategoryLogic extends Model
{
    /**
     * 手机端便利店获取二级导航
     */
    public function getGoodsMenu()
    {
        $menu = [
            0 => [
                "mobile_name" => "邻里心愿",
                "image" => "/public/static/mobile/img/icon_01.png",
                "index" => "",
                "mobile_url" => "/mobile/message/community.html",
            ],
            1 => [
                "mobile_name" => "邻里排行",
                "image" => "/public/static/mobile/img/icon_02.png",
                "index" => "",
                "mobile_url" => "/mobile/Index/wookranking.html",
            ],
        ];
        // 参数
        $cateM = Db::name("goods_category");
        $field = "mobile_name,image,index,mobile_url";
        $where = [
            'is_show' => 1,
            'level' => 1
        ];
        // 获取前三个分类
        $cateThree = $cateM -> field($field) -> where($where) -> limit(0,3) -> select();
        if(!empty($cateThree)){
            $menu = array_merge($menu,$cateThree);
        }
        // 菜单栏第二排第一个
        $menu[] = [
            "mobile_name" => "历史购买",
            "image" => "/public/static/mobile/img/icon_11.png",
            "index" => "",
            "mobile_url" => "javascript:;",
        ];
        // 获取后面所有的分类
        if(!empty($cateThree)) {
            $indexArr = [];
            foreach ($cateThree as $list) {
                $indexArr[] = $list['index'];
            }
            $where['index'] = ["not in", $indexArr];
            $cateSel = $cateM->field($field)->where($where)->select();
            if (!empty($cateSel)) {
                $menu = array_merge($menu, $cateSel);
            }
        }
        return $menu;
    }

    /**
     * 获取商品分类
     * @param $field string 字段名
     */
    public function getCategory($field)
    {
        return (new GoodsCategory())->field($field)->where(['is_show'=>1,'level'=>1])->order("sort_order,id")->select();
    }

    /**
     * 获取所有的商品分类
     */
    public function getCateSelect()
    {
        return (new GoodsCategory())->select();
    }

    /**
     * 修改商品分类
     * @param $arr 修改的参数
     * @param $ip 修改者的IP
     */
    public function modiCate($arr,$ip)
    {
        if($arr && $ip){
            $goodsCateM = new GoodsCategory();
            $keyArr = array_keys($arr);
            if(in_array("name",$keyArr)){
                $ret = $goodsCateM->where(["name"=>$arr['name'],'level'=>$arr['level']])->count();
                if($ret > 0){
                    return ret(-1,"","在同级分类下已经有这个分类名称，请改一个");
                }
            }
            if(in_array("mobile_name",$keyArr)){
                $ret = $goodsCateM->where(["mobile_name"=>$arr['mobile_name'],'level'=>$arr['level']])->count();
                if($ret > 0){
                    return ret(-1,"","在同级分类下已经有这个分类名称，请改一个");
                }
            }
            // 事物
            Db::startTrans();
            try{
                // 修改数据
                $cateRet = $goodsCateM->update($arr);
                if(!$cateRet){
                    throw new \Exception("参数错误",1);
                }
                // 记录操作日记
                $adminInfo = session("adminInfo");
                $f = "";
                foreach($arr as $key => $list){
                    if($key != 'id'){
                        $f .= "字段[ ".$key." ]的数据修改为【".$list."】,";
                    }
                }
                $data = array(
                    'admin_id' => $adminInfo['id'],
                    'remark' => "管理者【".$adminInfo['username']."】修改商品分类ID：".$arr['id']." ,".$f,
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
        }
        return ret(-1,"","参数错误");
    }

    /**
     * 添加商品分类
     * @param $arr array 参数
     * @param $ip string 添加者IP
     */
    public function addCate($arr,$ip)
    {
        if($arr && $ip){
            $goodsCateM = new GoodsCategory();
            // 获取分类的等级   分类的家族图谱
            switch ($arr['parent_id'])
            {
                case 0:
                    $arr['level'] = 1;
                    $arr['parent_id_path'] = '0_';
                    break;
                default:
                    $parentInfo = $goodsCateM->where("id",$arr['parent_id'])->find();
                    if(!$parentInfo){
                        return ret(-1,"","参数错误");
                    }
                    $arr['level'] = $parentInfo['level']*1 + 1;
                    $arr['parent_id_path'] = $parentInfo['parent_id_path'].'_';
            }
            // 判断同等级下的分类名称
            $brotherCount = $goodsCateM->where("level = '".$arr['level']."' and (name = '".$arr['name']."' or mobile_name = '".$arr['mobile_name']."')")->count();
            if($brotherCount > 0){
                return ret(-1,"","同等级分类下已经有这个分类名称,请换个分类名称");
            }
            $index = $goodsCateM->field("index")->order("index DESC")->find();
            if(empty($index)){
                $arr['index'] = 1;
            }else{
                $arr['index'] = $index['index'] + 1;
            }
            // 事物
            Db::startTrans();
            try{
                // 添加数据
                $cateRet = $goodsCateM->insertGetId($arr);
                if($cateRet <= 0){
                    throw new \Exception("参数错误",1);
                }
                // 修改家族图谱
                $update = [
                    'id' => $cateRet,
                    'parent_id_path' => $arr['parent_id_path'].$cateRet,
                ];
                $number = $goodsCateM->update($update);
                if(!$number){
                    throw new \Exception("参数错误",2);
                }
                // 记录操作日记
                $adminInfo = session("adminInfo");
                $data = array(
                    'admin_id' => $adminInfo['id'],
                    'remark' => "管理者【".$adminInfo['username']."】添加商品分类",
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
     * 删除商品分类
     * @param $arr array
     * @param $ip string
     * return array
     */
    public function delCate($arr,$ip)
    {
        if($arr && $ip){
            // 事物
            Db::startTrans();
            try{
                // 删除数据
                $cateRet = (new GoodsCategory())->where("id = ".$arr['id']." or parent_id_path like '%_".$arr['id']."_%'")->delete();
                if($cateRet <= 0){
                    throw new \Exception("参数错误",1);
                }
                // 记录操作日记
                $adminInfo = session("adminInfo");
                $data = array(
                    'admin_id' => $adminInfo['id'],
                    'remark' => "管理者【".$adminInfo['username']."】删除商品分类ID：".$arr['id']."以及下面的所有商品分类",
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