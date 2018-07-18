<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:67:"E:\stuby\PHPTutorial\WWW\8yi/application/admin\view\goods\list.html";i:1531909302;}*/ ?>

    <style>
        .pagination{
            margin: 10px auto;
        }
        .box{
            margin-bottom: 0;
        }
        #goods-edit{
            display: none;
        }
        form input {
            width: 160px;
        }
        input::-webkit-input-placeholder{
            color: #111111;
        }
        select option{
            width: 200px;
            color: #111111;
        }

    </style>
    <!-- 商品列表 -->
    <div class="row-fluid sortable ui-sortable" id="goods-list">
        <div class="box span12">
            <div class="box-header" data-original-title="">
                <h2><i class="halflings-icon white user"></i><span class="break"></span>商品列表</h2>
                <div class="box-icon">
                    <a href="javascript:void(0)" class="btn-minimize">
                        <i class="halflings-icon white chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="box-content" id="searchBefore" style="display: block">
                <form action="<?php echo url('Goods/list'); ?>" method="get" id="search">
                    <input type="text" name="ss_goods_sn" value="<?php if(empty($where['goods_sn'])){echo '';}else{echo trim($where['goods_sn'][1],'%');}?>"  AUTOCOMPLETE="off" placeholder="商品编码" >
                    <input type="text" aria-controls="DataList" name="ss_goods_name" value="<?php if(empty($where['goods_name'])){echo '';}else{echo trim($where['goods_name'][1],'%');}?>"  AUTOCOMPLETE="off" placeholder="商品名称">
                    <select name="category" style="outline: none;line-height: inherit;">
                        <option value="">请选择所属分类</option>
                        <?php if(is_array($goodsCate) || $goodsCate instanceof \think\Collection || $goodsCate instanceof \think\Paginator): if( count($goodsCate)==0 ) : echo "" ;else: foreach($goodsCate as $key=>$list): ?>
                            <option value="<?php echo $list['id']; ?>"<?php if(empty($where["cat_id"])){echo "";}else{if($where["cat_id"]==$list->id){echo "selected";}else{echo "";}} ?> ><?php echo $list['name']; ?>[<?php echo $list['mobile_name']; ?>]</option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                    <select name="ss_on_sale" style="outline: none;line-height: inherit;">
                        <option value="">请选择状态</option>
                        <option value="1" <?php if(empty($where["is_on_sale"])){echo "";}else{if($where["is_on_sale"]==1){echo "selected";}else{echo "";}} ?> >正常</option>
                        <option value="0" <?php if(array_key_exists('is_on_sale',$where)){if($where["is_on_sale"]!=1){echo "selected";}else{echo "";}}echo ""; ?> >下架</option>
                    </select>
                    <input type="button" class="btn btn-info" onclick="search(1)" style="height: 30px;margin-bottom: 10px" value="搜索">
                </form>
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
            </div>
        </div>
    </div>

    <!-- 商品编辑 -->
    <div class="row-fluid sortable ui-sortable" id="goods-edit">
        
    </div>
    <script>
        var p = <?php echo $p; ?>;
        // 页面跳转
        $(".pagination ul li a").click(function () {
            var _p = $(this).data("p");
            if(typeof(_p) !== "undefined"){
                p = _p;
                search(p);
//                load();
//                ajaxUrl("Goods/list/p/"+p);
            }
        });

        // 上下架功能
        function onShow(goods_id,is_on_sale) {
            switch (is_on_sale)
            {
                case 1:
                    is_on_sale = 0;
                    break;
                default:
                    is_on_sale = 1;
            }
            load();
            $.ajax({
                type : 'post',
                url : "<?php echo url('Goods/modifyGoods'); ?>",
                data : {goods_id:goods_id,is_on_sale:is_on_sale},
                dataType : 'json',
                success : function(ret){
                    console.log(ret);
                    layer.closeAll();
                    if(ret.ret == -1){
                        layer.alert(ret.msg, {icon: 2,time:2000});
                    }else{
                        load();
                        ajaxUrl("Goods/list/p/"+p);
                    }
                }
            })
        }

        // 删除功能
        function delGoods(goods_id){
            var length = $(".odd").length;
            layer.confirm('确认要删除吗？', {
                btn : [ '确定', '取消' ]//按钮
            }, function(index) {
                layer.close(index);
                load();
                $.ajax({
                    type : 'post',
                    url : "<?php echo url('Goods/delGoods'); ?>",
                    data : {goods_id:goods_id},
                    dataType : 'json',
                    success : function(ret){
                        console.log(ret);
                        layer.closeAll();
                        if(ret.ret == -1){
                            layer.alert(ret.msg, {icon: 2,time:2000});
                        }else{
                            if(length == 1){
                                p = p*1-1;
                            }
                            load();
                            ajaxUrl("Goods/list/p/"+p);
                        }
                    }
                })
            });
        }

        // 编辑页面显示
        function editGoods(goods_id) {
            load();
            $.ajax({
                type: "POST",
                url: "/index.php/Admin/Goods/goodsedit",
                data: {goods_id:goods_id},
                success: function (data) {
                    layer.closeAll();
                    if(data.ret == -1){
                        layer.msg(ret.msg,{icon:2,time:2000});
                    }else{
                        $("#goods-edit").html('');
                        $("#goods-edit").append(data);
                        $("#goods-list").css('display','none');
                        $("#goods-edit").css("display","block");
                    }
                }
            });
        }

        //搜索商品
        function search(b) {
            p = b;
            $.ajax({
                type: "POST",
                url: "/index.php/Admin/Goods/list/p/"+p,
                data: $("#search").serialize(),
                success: function (data) {
                    layer.closeAll();
                    if(data.ret == -1){
                        layer.msg(data.msg,{icon:2,time:2000});
                    }else {
                        $(".content").html('');
                        $(".content").append(data);
                    }
                }
            });
        }
    </script>
