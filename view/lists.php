<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>南山松</title>
    <link rel="stylesheet" href="./resource/css/bootstrap.min.css">
    <link rel="stylesheet" href="./resource/css/index.css">
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
<div class="main">
    <h1 class="text-center">文章列表</h1>
    <div class="container" style="margin-top: 20px;margin-bottom: 50px;">
        <div class="panel panel-info">
            <!-- Table -->
            <table class="table table-hover">
                <tr>
                    <!--留言板中各个模板的标题内容-->
                    <td>编号</td>
                    <td>昵称</td>
                    <td>内容</td>
                    <td>发布时间</td>
                    <td>最后一次修改</td>
                    <!-- <td>点赞/回复</td>-->
                    <td>操作</td>
                </tr>
                <?php $num =0; foreach ($article as $k=>$v){
                    if($v['author'] === $_SESSION['username']){
                    $num++;  ?>
                    <tr>
                        <td>
                            <?php
                            // 1.输出$num 留言的序号 2.使用$num有效保持序号的连续性
                            echo $num; ?>
                        </td>
                        <td>
                            <?php
                            // 1.判断昵称的长度，如果答应长度大于10 ，将其他内容隐藏 2.防止页面被过多内容撑开，影响页面效果 3.可也以在输入中限制输入的长度
                            if(mb_strlen($v['author'])>10){
                                // 1. 显示留言 昵称 2.如果超出长度，超出部分，用省略号代替其余部分
                                echo mb_substr($v['author'],0,10,'utf-8').'···';
                            }else{
                                // 1.显示昵称 2.正常情况下 昵称长度未超过10
                                echo $v['author'];
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            // 1. 判断留言内容长度 2. 如果内容超过30进行截取
                            if(mb_strlen($v['content'])>30){
                                // 1.内容超过30 进行字符串截取 2.同时添加超链接，用于点击查看详情
                                // 1. 更首页数据一致  2.$K+1 保存和首页数据一致
//                                $k+=1;
                                echo "<a href='?index&id=$k' class='sheng' title='点击查看详情'>".mb_substr($v['content'],0,30,'utf-8')."···</a>";

                            }else {
                                // 1.正常情况输出，2.没有超过30 同时没有查看具体详情的超链接
                                echo $v['content'];
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            // 1.格式化显示时间 2.如：2017-5-26 00:17:29 年月日 时分秒 2.显示文章的创建时间
                            echo date("Y-n-d H:i:s",$v['ctime']); ?>
                        </td>
                        <td>
                            <?php
                            // 1.如果数组中存在mtime 进行显示  2.当文章被修改时，就存在没mtime，显示文章的修改时间
                            if (isset($v['mtime'])){ echo date("Y-n-d H:i:s",$v['mtime']);} ?>
                        </td>

                        <td>
                            <a href="?m=editor&id=<?php
                            //  1. 将数据变回 2.与本页数据保存一致 :(
//                            $k-=1;
                            // 1. 生成编辑的每一个连接 2.$K的值与数据库文件中的索引值一一对应，
                            echo "$k"; ?>" class="btn btn-primary btn-xs bianji" >编辑</a>
                            <!--                        1.点击时弹出弹出 2.防止用户误操作-->
                            <a href='javascript:if(confirm("确定要删除吗?")) location.href ="?m=del&id=<?php
                            // 1.输出要删除的留言编号  2.确保能成功删除对应的内容  3.删除数据，添加数据 不要使用get请求
                            echo $k; ?>"' class="btn btn-danger  btn-xs  del" >删除</a>
                        </td>
                    </tr>
                <?php } } ?>
            </table>
        </div>
    </div>
    <a href="?m=store" class="btn btn-primary" style="display:block;margin: 0 auto;width: 100px">添加文章</a>
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

</body>
</html>
