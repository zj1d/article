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
            <?php $num =-1; foreach ($article as $a){ $num++; ?>
                <li class="list-group-item aa hidden-xs">
                    <a href="?id=<?php echo $num; ?>" ><?php echo $a['title'];?></a>
                </li>
            <?php } ?>
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
<!--加载footer即js文件-->
<?php include "./view/public/footer.php"?>

</body>
</html>


