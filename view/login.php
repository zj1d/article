<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>登录</title>
    <link rel="stylesheet" href="./resource/css/bootstrap.min.css">
    <script src="./resource/js/jquery.js"></script>
    <script src="./resource/js/login.js"></script>
    <script src="./resource/js/canvas-particle.js"></script>
    <script src="./resource/js/index.js"></script>
    <style>
        .main{
            width: 50%;
            margin: 0 auto;
            margin-top: 100px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container">
        <!-- logo区-->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand logo" href="index.php">南山松</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" role="navigation">
            <ul class="nav navbar-nav">
                <!-- 默认选中区-->
                <!--                <li class="active"><a href="#">首页 <span class="sr-only">(current)</span></a></li>-->
            </ul>

            <ul class="nav navbar-nav navbar-right">
                    <li><a href="?m=register">注册</a></li>
            </ul>

        </div><!-- /.navbar-collapse -->

    </div><!-- /.container-fluid -->
</nav>
<div class="main">
    <div class="page-header">
        <h1 class="text-center" style="text-indent: -2em">登&nbsp;&nbsp;录</h1>
    </div>
    <form class="form-horizontal" action="" method="post">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label" >用户名</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="inputEmail3" name="username" placeholder="请输入用户名" required>
            </div>
        </div>
        <div class="form-group ">
            <label for="inputPassword3" class="col-sm-3 control-label">密码</label>
            <div class="col-sm-5">
                <input type="password" class="form-control" id="inputPassword3" name="pwd" placeholder="Password" required>
            </div>
        </div>

        <div class="form-group ">
            <label class="control-label col-sm-3" for="inputGroupSuccess2"></label>
            <div class="col-sm-5">
                <div class="input-group">
                    <input type="text" class="form-control auth" name="authcode" id="inputGroupSuccess2" aria-describedby="inputGroupSuccess2Status" style="height:39px" placeholder="请输入图片验证码" required>

                    <span class="input-group-addon" style="padding: 0"><img src="index.php?auth=authcode"  onclick="this.src='?auth=authcode&'+Math.random()"></span>

                </div>
            </div>
            <div class="col-sm-4">
                <span class="error" style="display: none">验证码不正确</span>
            </div>
        </div>

        <div class="form-group">
            <div class=" col-sm-offset-5 col-sm-6">
                <button type="submit" class="btn btn-primary ">登录</button>
            </div>
            <div class=" col-sm-offset-7 col-sm-2">
                <a href="?m=register">立即注册</a>
            </div>
        </div>
    </form>

</div>
</body>
</html>