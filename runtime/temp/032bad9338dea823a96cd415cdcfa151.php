<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:68:"E:\stuby\PHPTutorial\WWW\8yi/application/admin\view\login\index.html";i:1531210186;s:69:"E:\stuby\PHPTutorial\WWW\8yi\application\admin\view\public\layer.html";i:1528776088;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>登录</title>
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
    <style type="text/css">
        body { background: url(/public/static/admin/img/bg-login.jpg) !important; }
    </style>
</head>
<body>
<div class="container-fluid-full">
    <div class="row-fluid">
        <div class="row-fluid">
            <div class="login-box">
                <div class="icons">
                    <a href="index.html"><i class="halflings-icon home"></i></a>
                    <a href="#"><i class="halflings-icon cog"></i></a>
                </div>
                <h2>登录</h2>
                <form class="form-horizontal" action="" method="post">
                    <fieldset>
                        <div class="input-prepend" title="Username">
                            <span class="add-on"><i class="halflings-icon user"></i></span>
                            <input class="input-large span10" name="username" type="text" onkeyup="this.value=this.value.replace(/\s+/g,'')" placeholder="用户名"/>
                        </div>
                        <div class="clearfix"></div>

                        <div class="input-prepend" title="Password">
                            <span class="add-on"><i class="halflings-icon lock"></i></span>
                            <input class="input-large span10" name="password" type="password" onkeyup="this.value=this.value.replace(/\s+/g,'')" placeholder="密码"/>
                        </div>
                        <div class="clearfix"></div>
                        <div style="color: red; width: 100%; text-align: center;"></div>

                        <div class="button-login">
                            <button type="button" class="btn btn-primary" id="onLogin" data-url="<?php echo url('Login/index'); ?>" data-type=0>登录</button>
                        </div>
                        <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
<!-- 独立弹框 -->
<script type="text/javascript" src='/public/static/common/js/jquery-1.8.3.min.js'></script>
<script type="text/javascript" src="/public/static/common/layer/layer.js"></script>

<!-- 后台公用js逻辑层 -->
<script type="text/javascript" src="/public/static/admin/jslogic/style.js"></script>
<script type="text/javascript">
    // 登陆
    $("#onLogin").click(function () {
        var url = $(this).data("url"),
            type = $(this).data("type"),
            username = $("input[name='username']").val(),
            password = $("input[name='password']").val();
            if(type === 0){
                $(this).data("type",1);
                login(username,password,url);
            }
    })
</script>
</html>
