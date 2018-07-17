<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:75:"E:\stuby\PHPTutorial\WWW\8yi/application/admin\view\goods\search_goods.html";i:1531816161;}*/ ?>
<div class="dataTables_wrapper" role="grid">
    <div class="dataTables_filter">
        <!--<a class="btn btn-success active" style="margin-right: 3px;" href="javascript:void(0)"><i class="halflings-icon white edit"></i>添加商品</a>-->
        <!--<label>搜索 <input type="text" aria-controls="DataList"></label>-->
    </div>
    <!--<div id="DataList_processing" class="dataTables_processing" style="visibility: hidden;">正在加载中...</div>-->
    <div class="dataTables_scroll">
        <div class="dataTables_scrollHead" style="overflow: hidden; position: relative; border: 0; width: 100%;">
            <div class="dataTables_scrollHeadInner" style="padding-right: 0;">
                <table class="table table-striped table-bordered bootstrap-datatable dataTable" style="margin-left: 0;">
                    <thead>
                    <tr role="row">
                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 10%; text-align: center">商品编码</th>
                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 13%; text-align: center">商品名称</th>
                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 10%; text-align: center">规格/单位</th>
                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 6%; text-align: center">卖出数量</th>
                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 6%; text-align: center">市场价格</th>
                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 6%; text-align: center">淘宝价格</th>
                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 6%; text-align: center">华润价格</th>
                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 6%; text-align: center">本店价格</th>
                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 10%; text-align: center">所属分类</th>
                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 3%; text-align: center">排序</th>
                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 7%; text-align: center">状态</th>
                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 17%; text-align: center">操作</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="dataTables_scrollBody" style="overflow: auto; width: 100%;">
            <table class="table table-striped table-bordered bootstrap-datatable dataTable" aria-describedby="DataList_info" style="margin-left: 0; width: 110%;">
                <thead>
                <tr role="row" style="height: 0;">
                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 10%;"></th>
                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 13%;"></th>
                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 10%;"></th>
                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 6%;"></th>
                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 6%;"></th>
                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 6%;"></th>
                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 6%;"></th>
                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 6%;"></th>
                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 10%;"></th>
                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 3%;"></th>
                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 7%;"></th>
                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 17%;"></th>
                </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                <?php if(is_array($goods) || $goods instanceof \think\Collection || $goods instanceof \think\Paginator): if( count($goods)==0 ) : echo "" ;else: foreach($goods as $key=>$list): ?>
                    <tr class="odd">
                        <td style="vertical-align: middle; text-align: center"><?php echo $list['goods_sn']; ?></td>
                        <td style="vertical-align: middle; text-align: center"><?php echo $list['goods_name']; ?></td>
                        <td style="vertical-align: middle; text-align: center"><?php echo $list['spec']; ?> / <?php echo $list['company']; ?></td>
                        <td style="vertical-align: middle; text-align: center"><?php echo $list['hot_count']; ?></td>
                        <td style="vertical-align: middle;">￥: <?php echo $list['market_price']; ?></td>
                        <td style="vertical-align: middle;">￥: <?php echo $list['taobao_price']; ?></td>
                        <td style="vertical-align: middle;">￥: <?php echo $list['huarun_price']; ?></td>
                        <td style="vertical-align: middle;">￥: <?php echo $list['shop_price']; ?></td>
                        <td style="vertical-align: middle;"><?php echo $list['cat_id']; ?></td>
                        <td style="vertical-align: middle;"><?php echo $list['sort']; ?></td>
                        <td style="vertical-align: middle; text-align: center">
                            <?php switch($list['is_on_sale']): case "1": ?>正常<?php break; default: ?>下架
                            <?php endswitch; ?>
                        </td>
                        <td>
                            <a class="btn <?php if($list['is_on_sale'] == 1): ?>btn-danger<?php else: ?>btn-success<?php endif; ?> " href="javascript:void(0)" onclick="onShow(<?php echo $list['goods_id']; ?>,<?php echo $list['is_on_sale']; ?>)" style="margin-right: 3px;"><i class="halflings-icon white <?php if($list['is_on_sale'] == 1): ?>remove<?php else: ?>ok<?php endif; ?>"></i><?php if($list['is_on_sale'] == 1): ?>下架<?php else: ?>上架<?php endif; ?></a>
                            <a class="btn btn-success active" style="margin-right: 3px;" href="javascript:void(0)" onclick="editGoods(<?php echo $list['goods_id']; ?>)"><i class="halflings-icon white edit"></i>编辑</a>
                            <a class="btn btn-danger active" href="javascript:void(0)" onclick="delGoods(<?php echo $list['goods_id']; ?>)" style="margin-right: 3px;"><i class="halflings-icon white remove"></i>删除</a>
                        </td>
                    </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php echo $page; ?>
</div>