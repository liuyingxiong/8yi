<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"E:\stuby\PHPTutorial\WWW\8yi/application/admin\view\goods\meal_list.html";i:1531294352;}*/ ?>

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
    </style>
    <!-- 商品列表 -->
    <div class="row-fluid sortable ui-sortable" id="goods-list">
        <div class="box span12">
            <div class="box-header" data-original-title="">
                <h2><i class="halflings-icon white user"></i><span class="break"></span>商品套餐列表</h2>
                <div style="float: left; position: relative; top: -11px; margin-left: 80px;">
                    <a class="btn btn-success active" style="margin-right: 3px;" href="javascript:void(0)" onclick="addMeal()"><i class="halflings-icon white edit"></i>添加活动套餐</a>
                </div>
                <div class="box-icon">
                    <a href="javascript:void(0)" class="btn-minimize">
                        <i class="halflings-icon white chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="box-content">
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
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 6%; text-align: center">套餐ID</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 14%; text-align: center">套餐名称</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 14%; text-align: center">套餐图片</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 4%; text-align: center">卖出</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 6%; text-align: center">市场价格</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 6%; text-align: center">优惠价格</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 10%; text-align: center">开始时间</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 10%; text-align: center">结束时间</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 3%; text-align: center">排序</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 4%; text-align: center">状态</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 6%; text-align: center">计入排行榜</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 19%; text-align: center">操作</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="dataTables_scrollBody" style="overflow: auto; width: 100%;">
                            <table class="table table-striped table-bordered bootstrap-datatable dataTable" aria-describedby="DataList_info" style="margin-left: 0; width: 110%;">
                                <thead>
                                <tr role="row" style="height: 0;">
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 6%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 14%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 14%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 4%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 6%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 6%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 10%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 10%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 3%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 4%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 6%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 19%;"></th>
                                </tr>
                                </thead>
                                <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    <?php if(is_array($act_goods) || $act_goods instanceof \think\Collection || $act_goods instanceof \think\Paginator): if( count($act_goods)==0 ) : echo "" ;else: foreach($act_goods as $key=>$list): ?>
                                        <tr class="odd">
                                            <td style="vertical-align: middle; text-align: center"><?php echo $list['act_goods_id']; ?></td>
                                            <td style="vertical-align: middle; text-align: center"><?php echo $list['title']; ?></td>
                                            <td style="vertical-align: middle; text-align: center"><img src="<?php echo $list['img']; ?>" alt="" /></td>
                                            <td style="vertical-align: middle; text-align: center"><?php echo $list['number']; ?></td>
                                            <td style="vertical-align: middle;">￥: <?php echo $list['market_price']; ?></td>
                                            <td style="vertical-align: middle;">￥: <?php echo $list['price']; ?></td>
                                            <td style="vertical-align: middle;"><?php echo date("Y-m-d H:i:s",$list['s_time']); ?></td>
                                            <td style="vertical-align: middle;"><?php echo date("Y-m-d H:i:s",$list['e_time']); ?></td>
                                            <td style="vertical-align: middle;"><?php echo $list['sort']; ?></td>
                                            <td style="vertical-align: middle; text-align: center">
                                                <?php switch($list['state']): case "1": ?>正常<?php break; default: ?>下架
                                                <?php endswitch; ?>
                                            </td>
                                            <td style="vertical-align: middle; text-align: center">
                                                <?php switch($list['ranking_state']): case "1": ?>计入<?php break; default: ?>不计入
                                                <?php endswitch; ?>
                                            </td>
                                            <td>
                                                <a class="btn <?php if($list['state'] == 1): ?>btn-danger<?php else: ?>btn-success<?php endif; ?> " href="javascript:void(0)" onclick="onShow(<?php echo $list['act_goods_id']; ?>,<?php echo $list['state']; ?>)" style="margin-right: 3px;"><i class="halflings-icon white <?php if($list['state'] == 1): ?>remove<?php else: ?>ok<?php endif; ?>"></i><?php if($list['state'] == 1): ?>下架<?php else: ?>上架<?php endif; ?></a>
                                                <a class="btn btn-success active" style="margin-right: 3px;" href="javascript:void(0)" onclick="editMeal(<?php echo $list['act_goods_id']; ?>)"><i class="halflings-icon white edit"></i>编辑</a>
                                                <a class="btn btn-danger active" href="javascript:void(0)" onclick="delMeal(<?php echo $list['act_goods_id']; ?>,'<?php echo $list['img']; ?>')" style="margin-right: 3px;"><i class="halflings-icon white remove"></i>删除</a>
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
            var p = $(this).data("p");
            if(typeof(p) !== "undefined"){
                load();
                ajaxUrl("Goods/meal_list/p/"+p);
            }
        });
        // 添加商品套餐
        function addMeal() {
            ajaxMeal(0);
        }

        // 编辑商品套餐
        function editMeal(act_goods_id) {
            ajaxMeal(act_goods_id);
        }

        // 套餐上下架
        function onShow(act_goods_id,state){
            switch (state)
            {
                case 0:
                    state = 1;
                    break;
                default:
                    state = 0
            }
            load();
            $.ajax({
                type : 'post',
                url : "<?php echo url('Goods/statemeal'); ?>",
                data : {act_goods_id:act_goods_id,state:state},
                dataType : 'json',
                success : function(ret){
                    layer.closeAll();
                    if(ret.ret === 1){
                        layer.msg(ret.msg,{icon:1,time:1000});
                        setTimeout(function(){
                            ajaxUrl("Goods/meal_list/p/"+p);
                        },1000);
                        //$(".form-horizontal input").val("");
                    }else{
                        layer.msg(ret.msg,{icon:2,time:3000});
                    }
                }
            })
        }

        // 删除商品套餐
        function delMeal(act_goods_id,img) {
            var length = $(".odd").length;
            layer.confirm('确认要删除吗？', {
                btn : [ '确定', '取消' ]//按钮
            }, function(index) {
                layer.close(index);
                load();
                $.ajax({
                    type : 'post',
                    url : "<?php echo url('Goods/delmeal'); ?>",
                    data : {act_goods_id:act_goods_id,img:img},
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
                            ajaxUrl("Goods/meal_list/p/"+p);
                        }
                    }
                })
            });
            console.log(act_goods_id);return false;
        }

        // AJAX页面显示
        function ajaxMeal(act_goods_id){
            load();
            $.ajax({
                type: "POST",
                url: "/index.php/Admin/Goods/meal_show",
                data: {act_goods_id:act_goods_id},
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
    </script>
