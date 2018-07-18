<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:74:"E:\stuby\PHPTutorial\WWW\8yi/application/admin\view\prize\reward_list.html";i:1531447348;}*/ ?>

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
    <!-- 奖励列表 -->
    <div class="row-fluid sortable ui-sortable" id="order-list">
        <div class="box span12">
            <div class="box-header" data-original-title="">
                <h2><i class="halflings-icon white user"></i><span class="break"></span>奖励列表</h2>
                <div style="float: left; position: relative; top: -11px; margin-left: 80px;">
                    <a class="btn btn-success active" style="margin-right: 3px;" href="javascript:void(0)" onclick="editGoods()"><i class="halflings-icon white edit"></i>添加奖励</a>
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
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 6%; text-align: center">ID</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 8%; text-align: center">期数</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 8%; text-align: center">省钱第一名</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 8%; text-align: center">省钱第二名</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 8%; text-align: center">省钱第三名</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 8%; text-align: center">心愿第一名</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 8%; text-align: center">心愿第二名</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 8%; text-align: center">心愿第三名</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 10%; text-align: center">开始时间</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 10%; text-align: center">结束时间</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 6%; text-align: center">奖品状态</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 12%; text-align: center">操作</th>
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
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 8%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 8%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 8%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 8%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 8%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 8%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 8%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 10%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 10%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 6%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 12%;"></th>
                                </tr>
                                </thead>
                                <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    <?php if(is_array($prizes) || $prizes instanceof \think\Collection || $prizes instanceof \think\Paginator): if( count($prizes)==0 ) : echo "" ;else: foreach($prizes as $key=>$list): ?>
                                        <tr class="odd">
                                            <td style="vertical-align: middle; text-align: center"><?php echo $list['id']; ?></td>
                                            <td style="vertical-align: middle; text-align: center"><?php echo $list['stage']; ?></td>
                                            <td style="vertical-align: middle; text-align: center"><?php echo $list['one_people']; ?></td>
                                            <td style="vertical-align: middle; text-align: center"><?php echo $list['two_people']; ?></td>
                                            <td style="vertical-align: middle;"><?php echo $list['three_people']; ?></td>
                                            <td style="vertical-align: middle;"><?php echo $list['x_one_people']; ?></td>
                                            <td style="vertical-align: middle;"><?php echo $list['x_two_people']; ?></td>
                                            <td style="vertical-align: middle;"><?php echo $list['x_three_people']; ?></td>
                                            <td style="vertical-align: middle;"><?php if(!(empty($list['s_time']) || (($list['s_time'] instanceof \think\Collection || $list['s_time'] instanceof \think\Paginator ) && $list['s_time']->isEmpty()))): ?><?php echo date("Y-m-d H:i:s",$list['s_time']); endif; ?></td>
                                            <td style="vertical-align: middle;"><?php if(!(empty($list['e_time']) || (($list['e_time'] instanceof \think\Collection || $list['e_time'] instanceof \think\Paginator ) && $list['e_time']->isEmpty()))): ?><?php echo date("Y-m-d H:i:s",$list['e_time']); endif; ?></td>
                                            <td style="vertical-align: middle;">
                                                <?php switch($list['state']): case "1": ?>活动进行中<?php break; case "2": ?>奖品发放中<?php break; case "3": ?>活动结束<?php break; default: ?>活动准备中
                                                <?php endswitch; ?>
                                            </td>
                                            <td>
                                                <a class="btn btn-info" style="margin-right: 3px;" href="javascript:void(0)" onclick="editGoods(<?php echo $list['id']; ?>)"><i class="halflings-icon white zoom-in"></i>查看</a>
                                                <!--<a class="btn btn-danger active" href="javascript:void(0)" onclick="delOrder()" style="margin-right: 3px;"><i class="halflings-icon white remove"></i>删除</a>-->
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

    <!-- 奖励编辑 -->
    <div class="row-fluid sortable ui-sortable" id="order-edit">
        
    </div>
    <script>
        var p = <?php echo $p; ?>;

        // 页面跳转
        $(".pagination ul li a").click(function () {
            var p = $(this).data("p");
            if(typeof(p) !== "undefined"){
                load();
                ajaxUrl("Prize/reward_list/p/"+p);
            }
        });

        // 删除功能
       /* function delOrder(order_sn){
            var length = $(".odd").length;
            layer.confirm('确认要删除吗？', {
                btn : [ '确定', '取消' ]//按钮
            }, function(index) {
                layer.close(index);
                load();
                $.ajax({
                    type : 'post',
                    url : "<?php echo url('Order/delOrder'); ?>",
                    data : {order_sn:order_sn},
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
                            ajaxUrl("Order/list/p/"+p);
                        }
                    }
                })
            });
        }*/

        // 详情页面显示
        function editGoods(id) {
            load();
            $.ajax({
                type: "POST",
                url: "<?php echo url('Prize/add_prize_show'); ?>",
                data: {id:id},
                success: function (data) {
                    layer.closeAll();
                    if(data.ret == -1){
                        layer.msg(data.msg,{icon:2,time:2000});
                    }else{
                        $("#order-edit").html('');
                        $("#order-edit").append(data);
                        $("#order-list").css('display','none');
                        $("#order-edit").css("display","block");
                    }
                }
            });
        }
    </script>
