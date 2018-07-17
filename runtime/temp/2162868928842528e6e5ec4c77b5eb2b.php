<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:68:"E:\stuby\PHPTutorial\WWW\8yi/application/admin\view\index\index.html";i:1531210154;s:68:"E:\stuby\PHPTutorial\WWW\8yi\application\admin\view\public\left.html";i:1529487354;s:69:"E:\stuby\PHPTutorial\WWW\8yi\application\admin\view\public\layer.html";i:1528776088;}*/ ?>
<!DOCTYPE html>
<html lang="cn">
<head>
	<meta charset="utf-8">
	<title>邻居联盟后台管理</title>
	<link rel="icon" type="image/x-icon" href="favicon.ico"/>
	<meta name="description" content="Bootstrap Metro Dashboard">
	<meta name="author" content="Dennis Ji">
	<meta name="keyword" content="Metro, Metro UI, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href="/public/static/common/layui/css/layui.mobile.css" rel="stylesheet" />
	<link href="/public/static/admin/css/bootstrap.min.css" rel="stylesheet" />
	<link href="/public/static/admin/css/bootstrap-responsive.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="/public/static/admin/css/style.css" />
	<link rel="stylesheet" href="/public/static/admin/css/style-responsive.css" />
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<link id="ie-style" href="/public/static/admin/css/ie.css" rel="stylesheet">
	<![endif]-->
	<!--[if IE 9]>
	<link id="ie9style" href="/public/static/admin/css/ie9.css" rel="stylesheet">
	<![endif]-->
</head>
<body>
	<!-- 头部 -->
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="javascript:void(0)"><span>邻居联盟</span></a>
				<div class="nav-no-collapse header-nav">
					<ul class="nav pull-right">
						<li class="dropdown">
							<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
								<i class="halflings-icon white user"></i>
								<?php echo $adminInfo['username']; ?>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<li class="dropdown-menu-title">
									<span>账户设置</span>
								</li>
								<li>
									<a href="<?php echo url('Login/logOut'); ?>">
										<i class="halflings-icon off"></i> 退出登录
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<!-- 内容 -->
	<div class="container-fluid-full">
		<div class="row-fluid" style="height: 100%;">
			<!-- 菜单 -->
			<!-- 菜单 -->
<div class="span2" style="background: #1C2B36; height: 100%;">
    <div class="nav-collapse sidebar-nav">
        <ul class="nav nav-tabs nav-stacked main-menu">
            <li <?php if($location == 'Index' && $method == 'index'): ?>class="active"<?php endif; ?>> <!--  -->
                <a class="submenu" href="<?php echo url('Index/index'); ?>">
                    <i class="icon-home"></i>
                    <span class="hidden-tablet">首页</span>
                </a>
            </li>
            <?php if(is_array($left_menu) || $left_menu instanceof \think\Collection || $left_menu instanceof \think\Paginator): if( count($left_menu)==0 ) : echo "" ;else: foreach($left_menu as $key=>$list): ?>
                <li>
                    <a href="javascript:void(0)" class="menu-one">
                        <i class="icon-folder-close-alt"></i>
                        <span class="hidden-tablet"><?php echo $list['name']; ?></span>
                    </a>
                    <ul>
                        <?php if(is_array($list['child']) || $list['child'] instanceof \think\Collection || $list['child'] instanceof \think\Paginator): if( count($list['child'])==0 ) : echo "" ;else: foreach($list['child'] as $key=>$vo): ?>
                            <li <?php if($vo['act'] == $location && $vo['op'] == $method): endif; ?> >
                            <a class="submenu" href="javascript:void(0)" data-param="<?php echo $vo['act']; ?>/<?php echo $vo['op']; ?>">
                                <i class="icon-file-alt"></i>
                                <span class="hidden-tablet"><?php echo $vo['name']; ?></span>
                            </a>
                            </li>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
</div>
			<!-- 主体内容 -->
			<div class="span10" style="padding: 20px 0 20px 30px; margin: 0 auto; height: 100%; overflow-y: scroll; overflow-x: hidden;">
				<div>
					<ul class="breadcrumb" style="margin: -20px -20px -5px -20px;">
						<li>
							<i class="icon-home"></i>
							<a href="">主页</a>
							<i class="icon-angle-right"></i>
						</li>
					</ul>
					<div class="content">
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- 底部 -->
	<footer class="footer">
		<p style="color: #a4a4a4; text-align: center">
			<a href="http://www.miibeian.gov.cn" target="_blank" style="text-align:center;color:#a4a4a4;">ICP备案号: 渝ICP备17016128号	</a>&nbsp;
			<!--<a target="_blank" href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=50010502001285&amp;token=hgrf1256sdfh415fshg12" style="text-align:center;color:#a4a4a4;">
				<img src="http://www.beian.gov.cn/img/ghs.png" style="width:15px;height:15px;">
				渝公网安备案 50010502001285号
			</a>-->
		</p>
	</footer>
</body>
<!-- 独立弹框 -->
<script type="text/javascript" src='/public/static/common/js/jquery-1.8.3.min.js'></script>
<script type="text/javascript" src="/public/static/common/layer/layer.js"></script>

<!-- 后台公用js逻辑层 -->
<script type="text/javascript" src="/public/static/admin/jslogic/style.js"></script>
<script>
	$(function(){
	    // 获取高度
		var headerHeight = $(".navbar").outerHeight(true);
		var footerHeight = $(".footer").outerHeight(true);
        var contentHeight = $(document).height()*1-headerHeight-footerHeight;
        $(".container-fluid-full").css("height",contentHeight);

        // 一级菜单点击事件
		$(".menu-one").click(function () {
			var _display = $(this).next("ul").css("display");
			$(this).css('background','#1C2B36');
			if(_display === 'none'){
			    $(".menu-one").next("ul").css("display","none");
                $(this).next("ul").css("display",'block');
			}else{
                $(this).next("ul").css("display",'none');
			}
        })

		// 二级菜单点击事件
		$(".submenu").click(function () {
			var param = $(this).data("param");
			var _this = $(this);
            $.ajax({
                type: "POST",
                url: "/index.php/Admin/" + param,
                success: function (data) {
                    //console.log(param);
					$(".submenu").parent("li").removeClass("active");
                    _this.parent("li").addClass("active");
                    $(".content").html('');
                    $(".content").append(data);
                }
            });
        })
	})
</script>
</html>