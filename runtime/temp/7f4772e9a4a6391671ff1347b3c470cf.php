<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"E:\stuby\PHPTutorial\WWW\8yi/application/admin\view\goods\addgoods.html";i:1530087684;}*/ ?>

    <style>
        .controls select{
            width: auto;
            line-height: 20px;
            padding: 5px 8px;
            height: auto;
        }
        .controls div{
            float: left;
            width: 10%;
        }
        .controls div label{
            float: left;
            margin: 0;
            padding: 0;
            height: 30px;
            line-height: 30px;
            width: 30%;
        }
        .controls div input{
            float: left;
            margin: 0;
            padding: 0;
            height: 30px;
            line-height: 30px;
            position: relative;
            top: 1px;
        }
        .controls .file-img{
            position: relative;
            width: 150px;
            height: 150px;
        }
        .controls .file-img input{
            width: 100%;
            height: 100%;
            padding: 0;
            margin: 0;
            position: absolute;
            left: 0;
            opacity: 0;
        }
        .controls .file-img div{
            width: 100%;
            height: 100%;
        }
    </style>
    <div class="row-fluid sortable ui-sortable">
        <div class="box span12">
            <div class="box-header" data-original-title="">
                <h2><i class="halflings-icon white "></i><span class="break"></span>添加商品</h2>
                <div class="box-icon">
                    <a href="javascript:void(0)" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
                </div>
            </div>
            <div class="box-content">
                <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                    <fieldset>
                        <div class="control-group">
                            <label class="control-label">商品名称</label>
                            <div class="controls">
                                <input class="input-xlarge focused" name="goods_name" type="text" value=""/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">商品图片</label>
                            <div class="controls">
                                <div class="file-img">
                                    <input type="file" onchange="preview(this)" id="original_img"/>
                                    <div>
                                        <img src="/public/static/common/img/onload.png" alt="点击上传图片" />
                                    </div>
                                </div>
                                <input type="hidden" name="original_img" readonly="readonly" value=""/>
                                <!--<input class="input-xlarge focused" name="original_img" type="text" value=""/>-->
                            </div>
                        </div>
                        <!--<div class="control-group">
                            <label class="control-label">商品缩略图</label>
                            <div class="controls">
                                <input class="input-xlarge focused" name="original_img" type="text" value=""/>
                            </div>
                        </div>-->
                        <div class="control-group">
                            <label class="control-label">所属分类</label>
                            <div class="controls">
                                <select name="cat_id">
                                    <?php if(is_array($cate) || $cate instanceof \think\Collection || $cate instanceof \think\Paginator): if( count($cate)==0 ) : echo "" ;else: foreach($cate as $key=>$list): ?>
                                        <option value="<?php echo $list['id']; ?>">PC:<?php echo $list['name']; ?>,Mobile:<?php echo $list['mobile_name']; ?></option>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">商品规格</label>
                            <div class="controls">
                                <input class="input-xlarge focused" name="spec" type="text" value="" placeholder="500g*1" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">商品单位</label>
                            <div class="controls">
                                <input class="input-xlarge focused" name="company" type="text" value="" placeholder="瓶" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">市场价格</label>
                            <div class="controls">
                                <input class="input-xlarge focused" name="market_price" type="text" value="" placeholder="3.5" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">淘宝价格</label>
                            <div class="controls">
                                <input class="input-xlarge focused" name="taobao_price" type="text" value="" placeholder="3.5" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">华润价格</label>
                            <div class="controls">
                                <input class="input-xlarge focused" name="huarun_price" type="text" value="" placeholder="3.5" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">本店价格</label>
                            <div class="controls">
                                <input class="input-xlarge focused" name="shop_price" type="text" value="" placeholder="2.5" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">排列顺序</label>
                            <div class="controls">
                                <input class="input-xlarge focused" name="sort" type="text" value="50" placeholder="50" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">是否上架</label>
                            <div class="controls">
                                <div>
                                    <label for="yes">是</label>
                                    <input name="is_on_sale" id="yes" type="radio" value="1" checked="checked"/>
                                </div>
                                <div>
                                    <label for="no">否</label>
                                    <input name="is_on_sale" id="no" type="radio" value="0"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn btn-primary" onclick="addGoods()">添加</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <script>
        // 添加商品
        function addGoods() {
            var goods_name = $("input[name='goods_name']").val(),
                original_img = $("input[name='original_img']").val(),
                spec = $("input[name='spec']").val(),
                company = $("input[name='company']").val(),
                market_price = $("input[name='market_price']").val(),
                taobao_price = $("input[name='taobao_price']").val(),
                huarun_price = $("input[name='huarun_price']").val(),
                shop_price = $("input[name='shop_price']").val();
            if($.trim(goods_name).length <= 0){
                layer.msg("请输入商品名称!",{icon:2,time:2000});
                return false;
            }
            if($.trim(original_img).length <= 0){
                layer.msg("请选择商品图片!",{icon:2,time:2000});
                return false;
            }
            if($.trim(spec).length <= 0){
                layer.msg("请输入商品规格!",{icon:2,time:2000});
                return false;
            }
            if($.trim(company).length <= 0){
                layer.msg("请输入商品单位!",{icon:2,time:2000});
                return false;
            }
            if($.trim(shop_price).length <= 0){
                layer.msg("请输入商品价格!",{icon:2,time:2000});
                return false;
            }
            load();
            $.ajax({
                type : 'post',
                url : "<?php echo url('Goods/addGoodsFun'); ?>",
                data : $(".form-horizontal").serialize(),
                dataType : 'json',
                success : function(ret){
                    layer.closeAll();
                    if(ret.ret === 1){
                        layer.msg(ret.msg,{icon:1,time:2000});
                        setTimeout(function(){
                            ajaxUrl("Goods/addgoods");
                        },2000);
                        //$(".form-horizontal input").val("");
                    }else{
                        layer.msg(ret.msg,{icon:2,time:3000});
                    }
                }
            })
        }

        // 上传图片时显示功能
        function preview(file){
            var original_img = $("#original_img");
            var img = original_img.next("div").find("img");
            var old_width = img.css("width");
            var old_height = img.css("height");
            if(file.files && file.files[0]){
                var fileImg = file.files[0];
                if(window.FileReader) {
                    var reader = new FileReader();
                    reader.readAsDataURL(fileImg);
                    reader.onload = function (e) {
                        base64Code = this.result;
                        img.attr("src",base64Code);
                        $("input[name='original_img']").val(base64Code);
                        var img_width = img.css("width");
                        var img_height = img.css("height");
                        if((img_width*1-old_width*1) > (img_height*1-old_height*1)){
                            img.css({
                                "width":"100%",
                                "height":"auto"
                            })
                        }else{
                            img.css({
                                "height":"100%",
                                "width":"auto"
                            })
                        }
                    }
                }else{
                    layer.msg('浏览器不支持base64上传功能,请更新为最新的浏览器',{icon:2,time:2000});
                    original_img.val("");
                    img.attr("src","/public/static/common/img/onload.png");
                }
            }
        }
    </script>
