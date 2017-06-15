<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>南山松</title>
    <link rel="stylesheet" href="./resource/css/bootstrap.min.css">
    <link rel="stylesheet" href="./resource/css/index.css">
</head>
<body>
<!--导航开始-->
<?php include_once './view/public/nav.php'?>
<!--导航结束-->

<!--main-->
<div class="main">
    <!--侧边栏-->
    <div class="container">
    <div class="row text-center" >
        <ul class="list-group col-sm-2">
            <!--通过PHP遍历出侧边文章列表-->
            <li class="list-group-item aa hidden-xs">最新文章列表</li>
            <?php $num =0; foreach (array_reverse($article) as $a){  ?>
                <li class="list-group-item aa hidden-xs">
                    <a href="?id=<?php echo $num; ?>" ><?php echo $a['title'];?></a>
                </li>
            <?php  if($num>=9){break;} $num++; } ?>
        </ul>
        <div class="content col-sm-10">
            <!--内容区，通过PHP遍历出每篇文章-->
                <article class=" contents">
                    <h2><?php echo $article[$id]['title'] ?></h2>
                    <p style="width: 65%; text-align: right;">发布时间:<?php echo date("Y-n-d H:i:s",$article[$id]['ctime']); ?> </p>
                    <p class="author">—— 作者：<?php echo $article[$id]['author'] ?></p>
                    <?php echo $article[$id]['content']; ?>

                </article>
            <!--内容区-->
        </div>

    </div>
</div>
</div>
<!--main结束-->

<!--加载footer-->
<?php include "./view/public/footer.php"?>

<!--加载js文件 -->
<script src="./resource/js/jquery.js"></script>
<script src="./resource/js/bootstrap.js"></script>
<script src="./resource/js/canvas-particle.js"></script>
<script src="./resource/js/index.js"></script>


</body>
</html>


