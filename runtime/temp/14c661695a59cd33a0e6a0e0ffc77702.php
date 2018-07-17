<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:67:"E:\stuby\PHPTutorial\WWW\8yi/application/admin\view\order\list.html";i:1531813954;s:75:"E:\stuby\PHPTutorial\WWW\8yi\application\admin\view\order\search_order.html";i:1531738690;s:68:"E:\stuby\PHPTutorial\WWW\8yi\application\admin\view\public\date.html";i:1531790260;}*/ ?>

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
    <!-- 订单列表 -->
    <div class="row-fluid sortable ui-sortable" id="order-list">
        <div class="box span12">
            <div class="box-header" data-original-title="">
                <h2><i class="halflings-icon white user"></i><span class="break"></span>订单列表</h2>
                <div style="float: left; position: relative; top: -11px; margin-left: 80px; display: none" id="backBtn">
                    <a class="btn btn-success active" style="margin-right: 3px;" href="javascript:void(0)" onclick="backBtn()"><i class="halflings-icon white edit"></i>返回</a>
                </div>
                <div class="box-icon">
                    <a href="javascript:void(0)" class="btn-minimize">
                        <i class="halflings-icon white chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="box-content" id="searchBefore" style="display: block">
                <form action="" method="get" id="search">
                    <input type="text" aria-controls="DataList" name="order_sn" value="" placeholder="订单编码">
                    <input type="text" aria-controls="DataList" name="phone" value="" placeholder="收货人电话" maxlength="11">
                    <input class="laydate-icon" id="stime" type="text" name="s_time" data-options="{'type':'YYYY-MM-DD hh:mm:ss','beginYear':2018,'endYear':2088}" value="" placeholder="请点击此处选择开始时间" readonly/>
                    <input class="laydate-icon" id="etime" type="text" name="e_time" data-options="{'type':'YYYY-MM-DD hh:mm:ss','beginYear':2018,'endYear':2088}" value="" placeholder="请点击此处选择结束时间" readonly/>
                    <input type="button" class="btn btn-info" onclick="search()" style="height: 30px;margin-bottom: 10px" value="搜索">
                </form>
                <div class="dataTables_wrapper" role="grid">
                    <div class="dataTables_filter"></div>
                    <!--<div id="DataList_processing" class="dataTables_processing" style="visibility: hidden;">正在加载中...</div>-->
                    <div class="dataTables_scroll">
                        <div class="dataTables_scrollHead" style="overflow: hidden; position: relative; border: 0; width: 100%;">
                            <div class="dataTables_scrollHeadInner" style="padding-right: 0;">
                                <table class="table table-striped table-bordered bootstrap-datatable dataTable" style="margin-left: 0;">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 15%; text-align: center">订单编码</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 7%; text-align: center">下单ID</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 7%; text-align: center">收货人名称</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 8%; text-align: center">收货人电话</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 15%; text-align: center">收货人地址</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 7%; text-align: center">订单总价</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 10%; text-align: center">下单时间</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 5%; text-align: center">订单状态</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 5%; text-align: center">送货状态</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 5%; text-align: center">付款状态</th>
                                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 16%; text-align: center">操作</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="dataTables_scrollBody" style="overflow: auto; width: 100%;">
                            <table class="table table-striped table-bordered bootstrap-datatable dataTable" aria-describedby="DataList_info" style="margin-left: 0; width: 110%;">
                                <thead>
                                <tr role="row" style="height: 0;">
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 15%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 7%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 7%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 8%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 15%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 7%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 10%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 5%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 5%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 5%;"></th>
                                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 16%;"></th>
                                </tr>
                                </thead>
                                <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    <?php if(is_array($goods) || $goods instanceof \think\Collection || $goods instanceof \think\Paginator): if( count($goods)==0 ) : echo "" ;else: foreach($goods as $key=>$list): ?>
                                        <tr class="odd">
                                            <td style="vertical-align: middle; text-align: center"><?php echo $list['order_sn']; ?></td>
                                            <td style="vertical-align: middle; text-align: center"><?php echo $list['uid']; ?></td>
                                            <td style="vertical-align: middle; text-align: center"><?php echo $list['people']; ?></td>
                                            <td style="vertical-align: middle; text-align: center"><?php echo $list['phone']; ?></td>
                                            <td style="vertical-align: middle;"><?php echo $list['address']; ?></td>
                                            <td style="vertical-align: middle;">￥: <?php echo $list['total']; ?></td>
                                            <td style="vertical-align: middle;"><?php echo date("Y-m-d H:i:s",$list['addtime']); ?></td>
                                            <td style="vertical-align: middle;">
                                                <?php switch($list['order_state']): case "1": ?>已完成<?php break; case "2": ?>会员取消<?php break; default: ?>未完成
                                                <?php endswitch; ?>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <?php switch($list['delivery_state']): case "1": ?>等待出货<?php break; case "2": ?>正在送货<?php break; case "3": ?>完成签收<?php break; default: ?>等待付款
                                                <?php endswitch; ?>
                                            </td>
                                            <td style="vertical-align: middle; text-align: center">
                                                <?php switch($list['payment_state']): case "1": ?>已付款<?php break; default: ?>未付款
                                                <?php endswitch; ?>
                                            </td>
                                            <td>
                                                <a class="btn btn-info" style="margin-right: 3px;" href="javascript:void(0)" onclick="editGoods('<?php echo $list['order_sn']; ?>')"><i class="halflings-icon white zoom-in"></i>查看</a>
                                                <?php if($list['order_state'] == 1 && $list['payment_state'] == 1 && $list['delivery_state'] == 3): ?>
                                                    <a class="btn btn-danger active" href="javascript:void(0)" onclick="delOrder('<?php echo $list['order_sn']; ?>')" style="margin-right: 3px;"><i class="halflings-icon white remove"></i>删除</a>
                                                <?php endif; ?>
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

            <!-- 搜索结果 -->
            <div class="box-content" id="searchAfter" style="display: none">
                <div class="dataTables_wrapper" role="grid">
        <div class="dataTables_scrollHead" style="overflow: hidden; position: relative; border: 0; width: 100%;">
            <div class="dataTables_scrollHeadInner" style="padding-right: 0;">
                <table class="table table-striped table-bordered bootstrap-datatable dataTable" style="margin-left: 0;">
                    <thead>
                    <tr role="row">
                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 15%; text-align: center">订单编码</th>
                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 7%; text-align: center">下单ID</th>
                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 7%; text-align: center">收货人名称</th>
                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 8%; text-align: center">收货人电话</th>
                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 15%; text-align: center">收货人地址</th>
                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 7%; text-align: center">订单总价</th>
                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 10%; text-align: center">下单时间</th>
                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 5%; text-align: center">订单状态</th>
                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 5%; text-align: center">送货状态</th>
                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 5%; text-align: center">付款状态</th>
                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 16%; text-align: center">操作</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="dataTables_scrollBody" style="overflow: auto; width: 100%;">
            <table class="table table-striped table-bordered bootstrap-datatable dataTable" aria-describedby="DataList_info" style="margin-left: 0; width: 110%;">
                <thead>
                <tr role="row" style="height: 0;">
                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 15%;"></th>
                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 7%;"></th>
                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 7%;"></th>
                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 8%;"></th>
                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 15%;"></th>
                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 7%;"></th>
                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 10%;"></th>
                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 5%;"></th>
                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 5%;"></th>
                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 5%;"></th>
                    <th role="columnheader" rowspan="1" colspan="1" style="padding: 0; height: 0; width: 16%;"></th>
                </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                <?php if(is_array($goods) || $goods instanceof \think\Collection || $goods instanceof \think\Paginator): if( count($goods)==0 ) : echo "" ;else: foreach($goods as $key=>$list): ?>
                    <tr class="odd">
                        <td style="vertical-align: middle; text-align: center"><?php echo $list['order_sn']; ?></td>
                        <td style="vertical-align: middle; text-align: center"><?php echo $list['uid']; ?></td>
                        <td style="vertical-align: middle; text-align: center"><?php echo $list['people']; ?></td>
                        <td style="vertical-align: middle; text-align: center"><?php echo $list['phone']; ?></td>
                        <td style="vertical-align: middle;"><?php echo $list['address']; ?></td>
                        <td style="vertical-align: middle;">￥: <?php echo $list['total']; ?></td>
                        <td style="vertical-align: middle;"><?php echo date("Y-m-d H:i:s",$list['addtime']); ?></td>
                        <td style="vertical-align: middle;">
                            <?php switch($list['order_state']): case "1": ?>已完成<?php break; case "2": ?>会员取消<?php break; default: ?>未完成
                            <?php endswitch; ?>
                        </td>
                        <td style="vertical-align: middle;">
                            <?php switch($list['delivery_state']): case "1": ?>等待出货<?php break; case "2": ?>正在送货<?php break; case "3": ?>完成签收<?php break; default: ?>等待付款
                            <?php endswitch; ?>
                        </td>
                        <td style="vertical-align: middle; text-align: center">
                            <?php switch($list['payment_state']): case "1": ?>已付款<?php break; default: ?>未付款
                            <?php endswitch; ?>
                        </td>
                        <td>
                            <a class="btn btn-info" style="margin-right: 3px;" href="javascript:void(0)" onclick="editGoods('<?php echo $list['order_sn']; ?>')"><i class="halflings-icon white zoom-in"></i>查看</a>
                            <?php if($list['order_state'] == 1 && $list['payment_state'] == 1 && $list['delivery_state'] == 3): ?>
                                <a class="btn btn-danger active" href="javascript:void(0)" onclick="delOrder('<?php echo $list['order_sn']; ?>')" style="margin-right: 3px;"><i class="halflings-icon white remove"></i>删除</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php echo $page; ?>
</div></include>
            </div>
        </div>
    </div>

    <!-- 订单编辑 -->
    <div class="row-fluid sortable ui-sortable" id="order-edit">
        
    </div>

    <!-- 原版JQ时间插件 -->

<!-- 插件js文件 -->
<!--<script src="/public/static/common/jsDate/jquery.date.js"></script>-->


<!-- 新版js时间插件 -->
<link type="text/css" rel="stylesheet" href="/public/static/common/jedate/skin/jedate.css">
<script type="text/javascript" src="/public/static/common/jedate/src/jedate.js"></script>
<script type="text/javascript">
    /**
     * 时间插件点击事件
     * @param inputIdDate string  元素ID
     * @param minTime     string  最小时间
     */
    function on_jeDate(inputIdDate,minTime) {
        if(minTime === ""){
            var date = new Date();
            var sign1 = "-";
//            var sign2 = ":";
            var year = date.getFullYear(); // 年
            var month = date.getMonth() + 1; // 月
            var day  = date.getDate(); // 日
            /*var hour = date.getHours(); // 时
            var minutes = date.getMinutes(); // 分
            var seconds = date.getSeconds(); //秒*/
            // 给一位数数据前面加 “0”
            if (month >= 1 && month <= 9) {
                month = "0" + month;
            }
            if (day >= 0 && day <= 9) {
                day = "0" + day;
            }
            /*if (hour >= 0 && hour <= 9) {
                hour = "0" + hour;
            }
            if (minutes >= 0 && minutes <= 9) {
                minutes = "0" + minutes;
            }
            if (seconds >= 0 && seconds <= 9) {
                seconds = "0" + seconds;
            }*/
            minTime = year + sign1 + month + sign1 + day;
            /*minTime = year + sign1 + month + sign1 + day + " " + hour + sign2 + minutes + sign2 + seconds;*/
        }
        jeDate("#"+inputIdDate,{
            format:"YYYY-MM-DD hh:mm:ss",              //日期格式
            minDate:minTime,                           //最小日期 或者 "1900-01-01" 或者 "10:30:25"
            isTime:false,
            clearfun:function() {                      //清除日期后的回调, elem当前输入框ID, val当前选择的值
                document.getElementById("etime").value="";
            },
            donefun:function(obj) {                    //点击确定后的回调,obj包含{ elem当前输入框ID, val当前选择的值, date当前的日期值}
                if(obj.elem.id === "stime"){
                    document.getElementById("etime").value="";
                }
            },
            success:function(elem) {}                  //层弹出后的成功回调方法, elem当前输入框ID*/
           /* skinCell:"jedateblue",                      //日期风格样式，默认蓝色
            format:"YYYY-MM-DD hh:mm:ss",               //日期格式
            minDate:"1900-01-01 00:00:00",              //最小日期 或者 "1900-01-01" 或者 "10:30:25"
            maxDate:"2099-12-31 23:59:59",              //最大日期 或者 "2099-12-31" 或者 "16:35:25"
            language:{                                  //多语言设置
                name  : "cn",
                month : ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"],
                weeks : [ "日", "一", "二", "三", "四", "五", "六" ],
                times : ["小时","分钟","秒数"],
                titText: "请选择日期时间",
                clear : "清空",
                today : "今天",
                yes   : "确定",
                close : "关闭"
            },
            isShow:true,                                //是否显示为固定日历，为false的时候固定显示
            multiPane:true,                             //是否为双面板，为false是展示双面板
            onClose:true,                               //是否为选中日期后关闭弹层，为false时选中日期后关闭弹层
            range:null,                                 //如果不为空，则会进行区域选择，例如 " 至 "，" ~ "，" To "
            trigger:"click",                            //是否为内部触发事件，默认为内部触发事件
            position:[],                                //自定义日期弹层的偏移位置，长度为0，弹层自动查找位置
            valiDate:[],                                //有效日期与非有效日期，例如 ["0[4-7]$,1[1-5]$,2[58]$",true]
            isinitVal:false,                            //是否初始化时间，默认不初始化时间
            initDate:{},                                //初始化时间，加减 天 时 分
            isTime:true,                                //是否开启时间选择
            isClear:true,                               //是否显示清空
            isToday:true,                               //是否显示今天或本月
            festival:false,                             //是否显示农历节日
            fixed:true,                                 //是否静止定位，为true时定位在输入框，为false时居中定位
            zIndex:2099,                                //弹出层的层级高度
            marks:null,                                 //给日期做标注
            clearfun:function(elem, val) {},            //清除日期后的回调, elem当前输入框ID, val当前选择的值
            donefun:function(obj) {},                   //点击确定后的回调,obj包含{ elem当前输入框ID, val当前选择的值, date当前的日期值}
            success:function(elem) {}                  //层弹出后的成功回调方法, elem当前输入框ID*/
        })
    }

    /**
     * 时间插件点击事件  搜索
     * @param inputIdDate string  元素ID
     * @param minTime     string  最小时间
     */
    function on_search_jeDate(inputIdDate,minTime) {
        if(minTime == ""){
            jeDate("#"+inputIdDate,{
                format:"YYYY-MM-DD hh:mm:ss",              //日期格式
                isTime:false,
                clearfun:function() {                      //清除日期后的回调, elem当前输入框ID, val当前选择的值
                    document.getElementById("etime").value="";
                },
                donefun:function(obj) {                    //点击确定后的回调,obj包含{ elem当前输入框ID, val当前选择的值, date当前的日期值}
                    if(obj.elem.id === "stime"){
                        document.getElementById("etime").value="";
                    }
                },
                success:function(elem) {}                  //层弹出后的成功回调方法, elem当前输入框ID*/
            })
        }else{
            jeDate("#"+inputIdDate,{
                format:"YYYY-MM-DD hh:mm:ss",              //日期格式
                minDate:minTime,                           //最小日期 或者 "1900-01-01" 或者 "10:30:25"
                isTime:false,
                clearfun:function() {                      //清除日期后的回调, elem当前输入框ID, val当前选择的值
                    document.getElementById("etime").value="";
                },
                donefun:function(obj) {                    //点击确定后的回调,obj包含{ elem当前输入框ID, val当前选择的值, date当前的日期值}
                    if(obj.elem.id === "stime"){
                        document.getElementById("etime").value="";
                    }
                },
                success:function(elem) {}                  //层弹出后的成功回调方法, elem当前输入框ID*/
            })
        }
    }
</script>
    <script>
        // 开始时间
        $("#stime").click(function () {
            on_search_jeDate("stime","");
        });

        // 结束时间
        $("#etime").click(function(){
            var s_time = $("#stime").val();
            if(s_time !== "" && $.trim(s_time).length > 0){
                on_search_jeDate("etime",s_time);
            }
        });

        var p = <?php echo $p; ?>;

        // 页面跳转
        $(".pagination ul li a").click(function () {
            var p = $(this).data("p");
            if(typeof(p) !== "undefined"){
                load();
                ajaxUrl("Order/list/p/"+p);
            }
        });

        // 删除功能
        function delOrder(order_sn){
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
        }

        // 详情页面显示
        function editGoods(order_sn) {
            load();
            $.ajax({
                type: "POST",
                url: "<?php echo url('Order/orderdeta'); ?>",
                data: {order_sn:order_sn},
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

        //搜索订单号
        function search() {
            $.ajax({
                type: "POST",
                url: "<?php echo url('Order/searchOrder'); ?>",
                data: $('#search').serialize(),
                success: function (data) {
                    layer.closeAll();
                    if(data.ret == -1){
                        layer.msg(data.msg,{icon:2,time:2000});
                    }else{
                        $("#searchAfter").html('');
                        $("#searchAfter").append(data);
                        $("#searchBefore").css('display','none');
                        $("#searchAfter").css("display","block");
                        $("#backBtn").css("display","block");
                    }
                }
            })
        }

        //返回起始页
        function backBtn() {
            $("#searchAfter").html('');
            $("#searchAfter").css("display","none");
            $("#backBtn").css("display","none");
            $("#searchBefore").css('display','block');
            load()
            ajaxUrl("Order/list")
        }
    </script>
