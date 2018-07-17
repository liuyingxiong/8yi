<?php

namespace app\common\logic;

use app\common\model\Area;
use think\Model;

class AreaLogic extends Model
{
    /**
     * 获取地区
     * @param $field
     * @param $value
     */
    public function getArea($field,$value)
    {
        return (new Area())->where($field,$value)->select();
    }

    /**
     * 获取地区名
     * @param $field
     * @param $value
     */
    public function getAreaName($field,$value)
    {
        $ret = (new Area())->field("area_name")->where($field,$value)->find();
        return $ret['area_name'];
    }
}