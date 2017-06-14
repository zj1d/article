<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>南山松</title>
    <link rel="stylesheet" href="./resource/css/bootstrap.min.css">
    <link rel="stylesheet" href="./resource/css/index.css">
    <!-- 配置文件 -->
    <script type="text/javascript" src="./umeditor/ueditor.config.js"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="./umeditor/ueditor.all.js"></script>
    <style>
        .main{
            min-height: 500px;
        }
    </style>
</head>
<body>
<!--导航开始-->
<?php include_once './view/public/nav.php'?>
<!--导航结束-->
<div class="main" style="width: 80%;margin: 0 auto">
    <form action="" method="post" class="form-horizontal">

        <div class="form-group">
            <label for="inputEmail3" class="col-sm-1 control-label" >文章标题</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="inputEmail3" name="title" placeholder="请输入文章名" required>
                <input type="hidden" name="author" value="<?php echo $_SESSION['username'] ?>">
            </div>
        </div>

        <script id="container" name="content" type="text/plain" style="height: 300px"></script>
        <button type="submit" class="btn btn-primary">提交</button>

    </form>
</div>

<footer class="text-center">
    <p>风中的云，云中的梦</p>
    <p>Copyright © 2010-2017  www.fengzhongyun1992.top All Rights Reserved </p>
</footer>
<!--footer区结束-->
<script src="./resource/js/jquery.js"></script>
<script src="./resource/js/bootstrap.js"></script>
<script src="./resource/js/canvas-particle.js"></script>
<script src="./resource/js/index.js"></script>
<!-- 实例化编辑器 -->
<script type="text/javascript">
    var ue = UE.getEditor('container');
    //对编辑器的操作最好在编辑器ready之后再做
</script>

</body>
</html>
