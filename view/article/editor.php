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
        <!--文章标题-->
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-1 control-label" >文章标题</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="inputEmail3" name="title" value="<?php echo $art['title'] ?>" required>
                <input type="hidden" name="author" value="<?php echo $art['author'] ?>">
                <input type="hidden" name="ctime" value="<?php echo $art['ctime'] ?>">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
            </div>
        </div>
        <!--文章标题-->

        <!--文章分类-->
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-1 control-label" >选择分类</label>
            <div class="col-sm-5">
                <!-- 下拉列表  -->
                <select class="form-control" name="classify">
                    <?php foreach ($data as $v){ ?>
                        <option value="<?php echo $v['cid'];?>" <?php if($v['cid']==$art['classify']) echo "selected" ?> ><?php echo $v['top']; ?></option>
                    <?php } ?>
                </select>
                <!-- 下拉列表结束 -->
                <input type="hidden" name="author" value="<?php echo $_SESSION['username'] ?>">
            </div>
        </div>
        <!--文章分类-->
        <script id="container" name="content" type="text/plain" style="height: 300px">
            <?php echo $art['content'] ?>
        </script>
        <button type="submit" class="btn btn-primary">提交</button>

            </form>
            </div>

    <!--加载footer即js文件-->
    <?php include "./view/public/footer.php"?>

        <!-- 实例化编辑器 -->
        <script type="text/javascript">
            var ue = UE.getEditor('container');
            //对编辑器的操作最好在编辑器ready之后再做
        </script>

</body>
</html>
