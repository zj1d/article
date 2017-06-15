<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>登录</title>
    <link rel="stylesheet" href="./resource/css/bootstrap.min.css">
    <script src="./resource/js/jquery.js"></script>

    <?php if(isset($_SESSION['error'])&&$_SESSION['error']!==0){ ?>
        <script src="./resource/js/login.js"></script>
    <?php } ?>

    <script src="./resource/js/canvas-particle.js"></script>
    <script src="./resource/js/index.js"></script>
    <link rel="stylesheet" href="./resource/css/index.css">
    <style>
        .main{
            width: 50%;
            margin: 0 auto;
            margin-top: 100px;
        }
    </style>
</head>
<body>

<?php include "./view/public/nav.php"?>

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

        <?php if(isset($_SESSION['error'])&&$_SESSION['error']!==0){ ?>

        <div class="form-group ">
            <label class="control-label col-sm-3" for="inputGroupSuccess2"></label>
            <div class="col-sm-5">
                <div class="input-group">
                    <input type="text" class="form-control auth" name="authcode" id="inputGroupSuccess2" aria-describedby="inputGroupSuccess2Status" style="height:39px" placeholder="请输入图片验证码" required>

                    <span class="input-group-addon" style="padding: 0"><img src="?c=member&a=code"  onclick="this.src+='&code='+Math.random()"></span>

                </div>
            </div>
            <div class="col-sm-4">
                <span class="error" style="display: none">验证码不正确</span>
            </div>
        </div>

        <?php } ?>


        <div class="form-group ">
            <div class="checkbox col-sm-offset-3">
                <label>
                    <input type="checkbox" name="autologin"> 七天免登陆
                </label>
            </div>
        </div>



        <div class="form-group">
            <div class=" col-sm-offset-5 col-sm-6">
                <button type="submit" class="btn btn-primary ">登录</button>
            </div>
            <div class=" col-sm-offset-7 col-sm-2">
                <a href="?c=member&a=reg">立即注册</a>
            </div>
        </div>
    </form>
</div>

<!--加载footer-->
<?php include "./view/public/footer.php"?>
</body>
</html>