<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:73:"E:\stuby\PHPTutorial\WWW\8yi/application/admin\view\goods\tabulation.html";i:1531712276;}*/ ?>

    <style>
        .odd td input{
            margin: 0;
            width: 90%;
        }
        .odd td img{
            max-width: 50%;
        }
    </style>
    <!-- 商品分类列表 -->
    <div class="row-fluid sortable ui-sortable">
        <div class="box span12">
            <div class="box-header" data-original-title="">
                <h2><i class="halflings-icon white user"></i><span class="break"></span>分类列表</h2>
                <div class="box-icon">
                    <a href="javascript:void(0)" class="btn-minimize">
                        <i class="halflings-icon white chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="box-content">
                <div class="dataTables_wrapper" role="grid">
                    <div class="dataTables_filter" id="DataList_filter">
                        <!--<label>搜索 <input type="text" aria-controls="DataList"></label>-->
                    </div>
                    <div class="dataTables_scroll">
                        <div class="dataTables_scrollHead" style="overflow: hidden; position: relative; border: 0; width: 100%;">
                            <div class="dataTables_scrollHeadInner" style="padding-right: 0;">
                                <table class="table table-striped table-bordered bootstrap-datatable dataTable" style="margin-left: 0;">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 10%; text-align: center">电脑端名称</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 10%; text-align: center">电脑端图片</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 10%; text-align: center">手机端名称</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 7%; text-align: center">手机端图片</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 10%; text-align: center">上级分类</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 10%; text-align: center">所处分类等级</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 10%; text-align: center">排列等级</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 6%; text-align: center">index属性</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 7%; text-align: center">状态</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 20%; text-align: center">操作</th>
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
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 10%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 10%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 7%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 10%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 10%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 10%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 6%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 7%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 20%;"></th>
                                </tr>
                                </thead>
                                <tbody role="alert" aria-live="polite" aria-relevant="all">
                                <?php if(is_array($cate) || $cate instanceof \think\Collection || $cate instanceof \think\Paginator): if( count($cate)==0 ) : echo "" ;else: foreach($cate as $key=>$list): ?>
                                    <tr class="odd">
                                        <td style="vertical-align: middle"><input type="text" onpaste="return false" ondragenter="return false" value="<?php echo $list['name']; ?>" class="cateInput" data-field="name" data-value="<?php echo $list['name']; ?>" data-id="<?php echo $list['id']; ?>" data-level="<?php echo $list['level']; ?>"/></td>
                                        <td style="vertical-align: middle; text-align: center;"><?php if(!(empty($list['pc_image']) || (($list['pc_image'] instanceof \think\Collection || $list['pc_image'] instanceof \think\Paginator ) && $list['pc_image']->isEmpty()))): ?><img src="<?php echo $list['pc_image']; ?>" alt=""><?php endif; ?></td>
                                        <td style="vertical-align: middle"><input type="text" onpaste="return false" ondragenter="return false" value="<?php echo $list['mobile_name']; ?>" class="cateInput" data-field="mobile_name" data-value="<?php echo $list['mobile_name']; ?>" data-id="<?php echo $list['id']; ?>" data-level="<?php echo $list['level']; ?>"/></td>
                                        <td style="vertical-align: middle; text-align: center;"><?php if(!(empty($list['image']) || (($list['image'] instanceof \think\Collection || $list['image'] instanceof \think\Paginator ) && $list['image']->isEmpty()))): ?><img src="<?php echo $list['image']; ?>" alt=""><?php endif; ?></td>
                                        <td style="vertical-align: middle"><?php echo $list['parent_id']; ?></td>
                                        <td style="vertical-align: middle"><?php echo $list['level']; ?></td>
                                        <td style="vertical-align: middle"><input type="text" onpaste="return false" ondragenter="return false" value="<?php echo $list['sort_order']; ?>" class="cateInput" data-field="sort_order" data-value="<?php echo $list['sort_order']; ?>" data-id="<?php echo $list['id']; ?>" data-level="<?php echo $list['level']; ?>" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"/></td>
                                        <td style="vertical-align: middle"><?php echo $list['index']; ?></td>
                                        <td style="vertical-align: middle; text-align: center">
                                            <?php switch($list['is_show']): case "1": ?>正常<?php break; default: ?>禁用
                                            <?php endswitch; ?>
                                        </td>
                                        <td style="vertical-align: middle">
                                            <a class="btn <?php if($list['is_show'] == 1): ?>btn-danger<?php else: ?>btn-success<?php endif; ?> " href="javascript:void(0)" onclick="onShow(<?php echo $list['id']; ?>,<?php echo $list['is_show']; ?>)" style="margin-right: 3px;"><i class="halflings-icon white <?php if($list['is_show'] == 1): ?>remove<?php else: ?>ok<?php endif; ?>"></i><?php if($list['is_show'] == 1): ?>禁用<?php else: ?>启用<?php endif; ?></a>
                                            <a class="btn btn-danger active" href="javascript:void(0)" onclick="delCate(<?php echo $list['id']; ?>)" style="margin-right: 3px;"><i class="halflings-icon white remove"></i>删除</a>
                                        </td>
                                    </tr>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // 分类启用
        function onShow(cate_id,show) {
            var is_show;
            switch (show)
            {
                case 1:
                    is_show = 0;
                    break;
                default:
                    is_show = 1;
            }
            load();
            $.ajax({
                type : 'post',
                url : "<?php echo url('Goods/modifyCate'); ?>",
                data : {id:cate_id,is_show:is_show},
                dataType : 'json',
                success : function(ret){
                    console.log(ret);
                    layer.closeAll();
                    if(ret.ret == -1){
                        layer.alert(ret.msg, {icon: 2,time:2000});
                    }else{
                        load();
                        ajaxUrl("Goods/tabulation");
                    }
                }
            })
        }

        // input框的值变的时候
        $(".cateInput").change(function () {
            var field = $(this).data("field");
            var oldValue = $(this).data("value");
            var id = $(this).data("id");
            var value = $(this).val();
            var level = $(this).data("level");
            if($.trim(value).length <= 0){
                $(this).val(oldValue);
                layer.msg("不能输入为空",{icon:2,time:2000});
                return false;
            }
            if($.trim(value) === $.trim(oldValue)){
                $(this).val(oldValue);
                return false;
            }
            var _this = $(this);
            load();
            $.ajax({
                type : 'get',
                url : "<?php echo url('Goods/modifyCate'); ?>",
                data : "id="+id+"&"+field+"="+$.trim(value)+"&level="+level,
                dataType : 'json',
                success : function(ret){
                    console.log(ret);
                    layer.closeAll();
                    if(ret.ret == -1){
                        layer.alert(ret.msg, {icon: 2,time:2000});
                        _this.val(oldValue);
                    }else{
                        load();
                        ajaxUrl("Goods/tabulation");
                    }
                }
            })
        })

        // 删除分类
        function delCate(cate_id){
            layer.confirm('会把当前名下的其它分级分类一起删除，确认要删除吗？', {
                btn : [ '确定', '取消' ]//按钮
            }, function(index) {
                layer.close(index);
                load();
                $.ajax({
                    type : 'post',
                    url : "<?php echo url('Goods/delCate'); ?>",
                    data : {id:cate_id},
                    dataType : 'json',
                    success : function(ret){
                        console.log(ret);
                        layer.closeAll();
                        if(ret.ret == -1){
                            layer.alert(ret.msg, {icon: 2,time:2000});
                        }else{
                            load();
                            ajaxUrl("Goods/tabulation");
                        }
                    }
                })
            });
        }
    </script>
