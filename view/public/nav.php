<!--导航开始-->
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
                <li class="active"><a href="index.php">首页 <span class="sr-only">(current)</span></a></li>
                <!--通过PHP遍历输出一级菜单-->
                <?php foreach ($data as  $k=>$val){ ?>
                    <li class="dropdown <?php  if($k>4){ echo 'hidden-sm';} ?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $val['top']; ?> <span class="caret"></span> </a>
                        <ul class="dropdown-menu">
                            <!--通过PHP遍历遍历输出二级菜单-->
                            <?php foreach ($val['son'] as $v){ ?>
                                <li >
                                    <a href="#"><?php echo $v; ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
            <?php if(isset($_SESSION['username'])){ ?>
                <ul class="nav navbar-nav navbar-right">


                    <li class="dropdown ">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">个人中心 <span class="caret"></span> </a>
                        <ul class="dropdown-menu">
                            <!--通过PHP遍历遍历输出二级菜单-->

                                <li >
                                    <a href="?m=lists">文章管理</a>
                                </li>
                                <li >
                                    <a href="?m=store">发布文章</a>
                                </li>
                                <li >
                                    <a href="?m=logout">注销</a>
                                </li>

                        </ul>
                    </li>
                </ul>
            <?php }else{ ?>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="?m=login">登录</a></li>
                    <li><a href="?m=register">注册</a></li>
                </ul>
            <?php } ?>

        </div><!-- /.navbar-collapse -->

    </div><!-- /.container-fluid -->
</nav>
<!--导航结束-->