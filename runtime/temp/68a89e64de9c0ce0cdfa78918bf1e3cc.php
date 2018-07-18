<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:66:"E:\stuby\PHPTutorial\WWW\8yi/application/admin\view\user\list.html";i:1531531284;}*/ ?>

    <!-- 用户列表 -->
    <div class="row-fluid sortable ui-sortable" id="user-list">
        <div class="box span12">
            <div class="box-header" data-original-title="">
                <h2><i class="halflings-icon white user"></i><span class="break"></span>用户列表</h2>
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
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 10%; text-align: center">[id]昵称</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 5%; text-align: center">头像</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 8%; text-align: center">电话</th>
                                        <!--<th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 15%; text-align: center">用户状态</th>-->
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 25%; text-align: center">操作</th>
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
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 5%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 8%;"></th>
                                    <!--<th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 15%;"></th>-->
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 25%;"></th>
                                </tr>
                                </thead>
                                <tbody role="alert" aria-live="polite" aria-relevant="all">
                                <?php if(is_array($users) || $users instanceof \think\Collection || $users instanceof \think\Paginator): if( count($users)==0 ) : echo "" ;else: foreach($users as $key=>$list): ?>
                                    <tr class="odd">
                                        <td style="vertical-align: middle; text-align: center">[<span style="color: #00b0ff"><?php echo $list['id']; ?></span>]&nbsp;<?php echo $list['nickname']; ?></td>
                                        <td style="vertical-align: middle; text-align: center"><img src="<?php echo $list['photo']; ?>" class="img-circle" width="35px" alt=""></td>
                                        <td style="vertical-align: middle; text-align: center">
                                            <label class="mobi"+<?php echo $list['id']; ?> style="display:block" onclick="mobi_show(this,<?php echo $list['id']; ?>)"><?php echo empty($list->mobile) ? "" : substr_replace($list->mobile,"***",3,4)?></label>
                                        </td>
                                        <!--<td style="vertical-align: middle; text-align: center">-->
                                            <!--<?php switch($list['state']): case "1": ?>待审核<?php break; case "2": ?>审核通过<?php break; case "3": ?>审核不通过<?php break; case "4": ?>禁用<?php break; ?>-->
                                                <!--<?php default: ?>没有上传身份-->
                                            <!--<?php endswitch; ?>-->
                                        <!--</td>-->
                                        <td>
                                            <a class="btn btn-info" style="margin-right: 3px;margin-left: 50px" href="javascript:void(0)" onclick="editUser('<?php echo $list['id']; ?>')"><i class="halflings-icon white zoom-in"></i>查看</a>
                                                <!--<a class="btn btn-danger active" href="javascript:void(0)" onclick="delUser('<?php echo $list['id']; ?>')" style="margin-right: 3px;"><i class="halflings-icon white remove"></i>删除</a>-->
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

    <!-- 用户编辑 -->
    <div class="row-fluid sortable ui-sortable" id="user-edit">
        
    </div>

    <script>
        var p = <?php echo $p; ?>;

        // 页面跳转
        $(".pagination ul li a").click(function () {
            var p = $(this).data("p");
            if(typeof(p) !== "undefined"){
                load();
                ajaxUrl("User/list/p/"+p);
            }
        });

        // 电话
        function mobi_show(obj,id){
            var txt = obj.innerHTML;
            if(txt.indexOf("*") == -1){
                return false;
            }
            $.ajax({
                type : 'post',
                url : "<?php echo url('User/mobi_show'); ?>",
                data : {id:id},
                dataType : 'json',
                success : function(ret){
                    if(ret.ret == 1){
                        obj.innerHTML=ret.msg;
                    }else{
                        layer.alert(ret.msg, {icon: 2,time:2000});
                    }
                }
            })
        }

        // 删除功能
//        function delUser(id){
//            var length = $(".odd").length;
//            layer.confirm('确认要删除吗？', {
//                btn : [ '确定', '取消' ]//按钮
//            }, function(index) {
//                layer.close(index);
//                load();
//                $.ajax({
//                    type : 'post',
//                    url : "<?php echo url('User/delUser'); ?>",
//                    data : {id:id},
//                    dataType : 'json',
//                    success : function(ret){
//                        console.log(ret);
//                        layer.closeAll();
//                        if(ret.ret == -1){
//                            layer.alert(ret.msg, {icon: 2,time:2000});
//                        }else{
//                            if(length == 1){
//                                p = p*1-1;
//                            }
//                            load();
//                            ajaxUrl("User/list/p/"+p);
//                        }
//                    }
//                })
//            });
//        }

        // 详情页面显示
        function editUser(id) {
            load();
            $.ajax({
                type: "POST",
                url: "<?php echo url('User/userdeta'); ?>",
                data: {id:id},
                success: function (data) {
                    layer.closeAll();
                    if(data.ret == -1){
                        layer.msg(data.msg,{icon:2,time:2000});
                    }else{
                        $("#user-edit").html('');
                        $("#user-edit").append(data);
                        $("#user-list").css('display','none');
                        $("#user-edit").css("display","block");
                    }
                }
            });
        }
    </script>