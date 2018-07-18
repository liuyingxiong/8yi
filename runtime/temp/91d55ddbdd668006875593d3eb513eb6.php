<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"E:\stuby\PHPTutorial\WWW\8yi/application/admin\view\order\orderdeta.html";i:1531815447;}*/ ?>
<style>
    #oul li{
        width: 200px;
        display: inline-block;
        margin-right: 20px;
    }
    .p_pic{
        width: 200px;
        height: 200px;
        background: red;
        font-size: 14px;
    }
    .p_pic img{
        width: 100%;
        height: 100%;
        border: 1px solid #999;
    }
    .goods_info{
        display: flex;
        justify-content: space-between;
    }
    .goods_price{
        color: red;
        display: flex;
        justify-content: space-between;
    }
    .order_stat{
        height: 30px;
        line-height: 20px;
        outline: hidden;
    }
    .order_info{
        margin: 10px 0;
        font-weight: 700;
    }
    .goods_name{
        font-weight: 700;
    }
    .goods_gg{
        color: #9c9c9c;
    }
    .order_info span{
        display: inline-block;
        text-align: right;
        width: 100px;
    }
</style>

    <div class="box span12">
        <div class="box-header" data-original-title="">
            <h2><i class="halflings-icon white "></i><span class="break"></span>订单详情</h2>
            <div class="box-icon">
                <a href="javascript:void(0)" class="btn-minimize">
                    <i class="halflings-icon white chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="box-content">
            <?php if(!(empty($orderGoods) || (($orderGoods instanceof \think\Collection || $orderGoods instanceof \think\Paginator ) && $orderGoods->isEmpty()))): ?>
            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <fieldset>
                    <div class="order_info"><span>订单编号：</span><?php echo $orderGoods[0]['order_sn']; ?></div>
                    <div class="order_info"><span>下单ID：</span><?php echo $orderGoods[0]['uid']; ?></div>
                    <div class="order_info"><span>下单时间：</span><?php echo date("Y-m-d H:i:s",$orderGoods[0]['addtime']); ?></div>
                    <div class="order_info"><span>收货人名称：</span><?php echo $orderGoods[0]['people']; ?></div>
                    <div class="order_info"><span>收货人电话：</span><?php echo $orderGoods[0]['phone']; ?></div>
                    <div class="order_info"><span>收货人电话：</span><?php echo $orderGoods[0]['address']; ?></div>
                    <div class="order_info"><span>配送商品:</span></div>
                    <ul id="oul">
                        <?php if(is_array($orderGoods) || $orderGoods instanceof \think\Collection || $orderGoods instanceof \think\Paginator): if( count($orderGoods)==0 ) : echo "" ;else: foreach($orderGoods as $key=>$list): ?>
                            <li>
                                <p class="p_pic"><img src="<?php echo $list['thumbnail_img']; ?>" alt=""></p>
                                <p class="goods_info"><span class="goods_name"><?php echo $list['goods_name']; ?></span><span class="goods_gg"><?php echo $list['spec']; ?></span></p>
                                <p class="goods_price"><span><?php echo $list['shop_price']; ?>元</span><span><?php echo $list['number']; ?><?php echo $list['company']; ?></span></p>
                            </li>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                    <div class="order_info">商品金额：￥<?php echo $orderGoods[0]['total']; ?></div>
                    <div class="order_info">配送运费：￥0</div>
                    <div class="order_info">到货时间：<?php if(!(empty($orderGoods[0]['arrivaltime']) || (($orderGoods[0]['arrivaltime'] instanceof \think\Collection || $orderGoods[0]['arrivaltime'] instanceof \think\Paginator ) && $orderGoods[0]['arrivaltime']->isEmpty()))): ?><?php echo date("Y-m-d H:i:s",$orderGoods[0]['arrivaltime']); endif; ?></div>
                    <div class="order_info">实付金额：￥<?php echo $orderGoods[0]['total']; ?></div>
                    <div class="order_info">订单状态：
                        <?php switch($orderGoods[0]['order_state']): case "1": ?>已完成<?php break; case "2": ?>会员取消<?php break; default: ?>未完成
                        <?php endswitch; ?>
                    </div>
                    <div class="order_info">付款状态：
                        <?php switch($orderGoods[0]['payment_state']): case "1": ?>已付款<?php break; default: ?>未付款
                        <?php endswitch; ?>
                    </div>
                    <div class="order_info">送货状态：
                        <?php if($orderGoods[0]['delivery_state'] != 3 && $orderGoods[0]['order_state'] != 2): ?>
                            <select name="delivery_state" class="order_stat">
                                <option value="0" <?php if($orderGoods[0]['delivery_state'] == 0): ?>selected<?php endif; ?> >等待付款</option>
                                <option value="1" <?php if($orderGoods[0]['delivery_state'] == 1): ?>selected<?php endif; ?> >等待出货</option>
                                <option value="2" <?php if($orderGoods[0]['delivery_state'] == 2): ?>selected<?php endif; ?> >正在送货</option>
                                <option value="3" <?php if($orderGoods[0]['delivery_state'] == 3): ?>selected<?php endif; ?> >完成签收</option>
                            </select>
                        <?php else: ?>
                            完成签收
                        <?php endif; ?>
                    </div>
                    <div class="form-actions">
                        <?php if($orderGoods[0]['order_state'] != 1 && $orderGoods[0]['order_state'] != 2): ?>
                            <input type="hidden" value="<?php echo $orderGoods[0]['order_sn']; ?>" name="ordersn" readonly="readonly"/>
                            <button type="button" class="btn btn-primary" onclick="onEditGoods()">修改</button>
                        <?php endif; ?>
                        <button type="button" class="btn btn-primary" style="margin-left: 100px;" onclick="modifyCancel()">返回</button>
                    </div>
                </fieldset>
            </form>
            <?php endif; ?>
        </div>
    </div>
    <script>
        function onEditGoods(){
            var order_sn = $("input[name='ordersn']").val();
            var delivery_state = $("select[name='delivery_state']").val();
            if(order_sn && delivery_state){
                layer.confirm('确认要修改状态吗？', {
                    btn : [ '确定', '取消' ]//按钮
                }, function(index) {
                    layer.close(index);
                    load();
                    $.ajax({
                        type : 'post',
                        url : "<?php echo url('Order/modifyOrder'); ?>",
                        data : {order_sn:order_sn,delivery_state:delivery_state},
                        dataType : 'json',
                        success : function(ret){
                            layer.closeAll();
                            if(ret.ret == 1){
                                load();
                                ajaxUrl("Order/list/p/"+p);
                            }else{
                                layer.alert(ret.msg, {icon: 2,time:2000});
                            }
                        }
                    })
                });
            }
        }

        // 取消
        function modifyCancel(){
            $("#order-edit").html('');
            $("#order-edit").css("display","none");
            $("#order-list").css('display','block');
        }
    </script>
