<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author:
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * 后台菜单
 * @param $p 当前页数
 * @param $count 总条数
 */
function adminPage($p,$count)
{
    $pages = ceil($count/10); // 总页数
    if($count > 0){
        $a = ($p-1)*10+1;                // 当前页第一条数字
    }else{
        $a = 0;
    }
    if($p*10 < $count){              // 当前页最后条数字
        $b = $p*10;
    }else{
        $b = $count;
    }
    $page  = '<div class="dataTables_info">当前显示 ';
    $page .= $a." 到 ".$b." 条，共 ".$count." 条记录</div>";
    if($pages <= 1){
        return $page;
    }
    $page .= "<div class='dataTables_paginate paging_bootstrap pagination'>";
    $page .= "<ul>";
    if($p == 1){
        $prev = "disabled";             // 上一页的样式
        $prev_p = "";                   // 上一页的数字
        $next = "";                     // 下一页的样式
        $next_p = "data-p='2'";         // 下一页的数字
    }else if($p > 1 && $p < $pages){
        $d = $p*1-1;
        $e = $p*1+1;
        $prev = "";
        $prev_p = "data-p='".$d."'";
        $next = "";
        $next_p = "data-p='".$e."'";
    }else if($p == $pages){
        $d = $p*1-1;
        $prev = "";
        $prev_p = "data-p='".$d."'";
        $next = "disabled";
        $next_p = "";
    }
    $page .= "<li class='prev ".$prev."'><a href='javascript:void(0)' ".$prev_p."' style='width: 60px; height: 20px;'>←  上一页 </a></li>";
    if($pages <= 5){
        $start = 0;           // 开始页面数
        $length = $pages;     // 显示页面数
    }else{
        if($p <= 3 && ($p*1+2) <= $pages){
            $start = 0;
        }else if(($p*1+2) > $pages){
            $start = $pages*1-5;
        }else{
            $start = $p*1-3;
        }
        $length = 5;
    }
    for($i = 1; $i <= $length; $i++){
        $start++;
        if($start == $p){
            $page .= "<li class='active'><a href='javascript:void(0)'>".$p."</a></li>";
        }else{
            $page .= "<li><a href='javascript:void(0)' data-p='".$start."'>".$start."</a></li>";
        }
    }
    $page .= "<li class='next ".$next."'><a href='javascript:void(0)' ".$next_p." style='width: 60px;'> 下一页  → </a></li>";
    $page .= "</ul>";
    $page .= "</div>";
    return $page;
}