<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>登录验证</title>
    <link rel="stylesheet" href="./resource/css/bootstrap.min.css">
    <script src="./resource/js/jquery.js"></script>
    <script src="./resource/js/register.js"></script>
    <script src="./resource/js/canvas-particle.js"></script>
    <script src="./resource/js/index.js"></script>
    <style>
        .main{
            width: 50%;
            margin: 0 auto;
            margin-top: 100px;
        }
        .error{
            color: red;
            font-weight: bold;
            display: none;
        }
        .tixing{
            color: #b0b0b0;
            font-size: 12px;
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
                    <li><a href="?c=member&a=login">登录</a></li>
            </ul>

        </div><!-- /.navbar-collapse -->

    </div><!-- /.container-fluid -->
</nav>
    <div class="main">
        <div class="page-header">
            <h1 class="text-center" style="text-indent: -2em">注&nbsp;&nbsp;册</h1>
        </div>
        <!--表单验证 -->
        <!--现在前端验证，然后再在php（一部分人绕过前端验证）中验证-->
        <form action="#" method="post" id="form" class="form-horizontal">
            <div class="form-group">
                <label for="inputName" class="col-sm-3 control-label" >用户名:</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control auth" id="inputName" name="username" placeholder="请输入用户名" >
                </div>
                <div class="col-sm-4">
                    <span class="error"></span>
                    <span class="tixing">用户名由 3-16个字符组成,必须使用字母，数字和下划线,不区分大小写</span>
                </div>
            </div>

            <!--email-->
            <div class="form-group">
                <label for="inputName1" class="col-sm-3 control-label" >Email:</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control auth" id="inputName1" name="emailname" placeholder="请输入Email" >
                </div>
                <div class="col-sm-4">
                    <span class="error">请输入正确邮箱</span>
                </div>
            </div>

            <div class="form-group ">
                <label for="inputPassword" class="col-sm-3 control-label">密&nbsp;&nbsp;&nbsp;码 :</label>
                <div class="col-sm-5">
                    <input type="password" class="form-control auth" id="inputPassword" name="pwd" placeholder="Password" >
                </div>
                <div class="col-sm-4">
                    <span class="error">密码至少8位</span>
                </div>
            </div>
           <div class="form-group ">
                <label for="inputPassword3" class="col-sm-3 control-label">确认密码 :</label>
                <div class="col-sm-5">
                    <input type="password" class="form-control auth" id="inputPassword3" name="repwd" placeholder="确认密码" >
                </div>

               <div class="col-sm-4">
                   <span class="error">两次密码不正确</span>
               </div>
            </div>

            <div class="form-group ">
                <label class="control-label col-sm-3" for="inputGroupSuccess2"></label>
                <div class="col-sm-5">
                    <div class="input-group">
                        <input type="text" class="form-control" id="inputGroupSuccess2" name="authcode" aria-describedby="inputGroupSuccess2Status" style="height:39px" placeholder="请输入图片验证码">

                        <span class="input-group-addon" style="padding: 0"><img src="?c=member&a=code"  onclick="this.src+='&code='+Math.random()"></span>

                    </div>

                </div>
                <div class="col-sm-4">
                    <span class="error">验证码不正确</span>
                </div>
            </div>

            <div class="form-group">
                <div class=" col-sm-offset-5 col-sm-6">
                    <button type="submit" class="btn btn-primary ">注册</button>
                </div>
                <div class=" col-sm-offset-7 col-sm-2">
                    <a href="?c=member&a=login">立即登录</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>