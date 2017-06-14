<?php

/**
 * 文章操作类
 * Class ArticleController
 * 实现文章的增、删、改、查等功能
 */
class Article extends Base
{
    private $dbdata;   // 1. 设置data属性 2. 用于接受保存数据库数据
    private $article;  // 1. 设置data属性 2. 用于接受保存数据库数据

    /**
     * ArticleController constructor.
     * 类的构造函数，用于初始化数据，根据$method方法的不同自动加载不同的功能页面
     */
    public function __construct()
    {

        // 加载数据库文件 ，并将数据库文件保存到成员属性$data中
        // 1. 实现初始化时，加载数据库 2.导航栏数据
        $this->dbdata = require("./database/nav.php");
        // 1. 加载文章数据 2.用于显示文章
        $this->article = require("./database/article.php");

    }


    /**
     *  文章首页功能
     *
     *  用于文章的展示功能和加载相应的页面模板
     */
    public function index()
    {
        // 1. 加载数据库，获取数据库中的内容，2. 为首页提供文章数据
        $data = $this->dbdata;
        // 1.加载文章数据库 2.位页面中的文章显示提供数据
        $article = $this->article;
        // 1.判断有无get请求 2.如果没有默认是 0 用于刚登陆时默认的显示数据
        $id = isset($_GET['id'])?$_GET['id']:0;

        // 在模板中将数据变量出来，通过HTML混编的方式


        // 使用继承父类的方法 当时模板获取不到数据 ):):):):
//        $this->view();

        // 加载首页模板,
        // 发现没有对应的样式，因为页面加载是相对于首页中的index.php,
        // 而模板中的数据时相对于它们的当前页面加载样式的，所有加载的样式路径需要修改
        include "./view/article/index.php";
    }




    /**
     * 文章列表功能
     * 用于实现具体文章的显示，同时加载相应的展示模板页面
     */
    public function lists()
    {
        // 1.检查$_SESSION是否有username值 2.用来判断用户有无权限进入该页面
        if(!isset($_SESSION['username'])){
            // 1.将页面跳转到主页 2.如果用户没有登录的情况下
            go('请登录后进入','index.php');
        }
        // 加载数据库，获取数据库中的内容，为导航条提供数据
        $data = $this->dbdata;
        // 加载数据库，获取数据库中的内容，为首页提供文章数据
        $article = $this->article;
        // 1.加载文章列表功能 2.实现文章列表的展示
        include './view/article/lists.php';
    }


    /**
     * 文章添加页面功能
     *
     * 用于文章的加载和文章添加页面的加载
     */
    public function store()
    {
        // 加载数据库，获取数据库中的内容，为导航条提供数据
        $data = $this->dbdata;
        // 加载数据库，获取数据库中的内容，为首页提供文章数据
        $article = $this->article;
        // 当有post数据传递过来时，进行操作
        if (IS_POST) {

            // 将追加当前时间的时间戳，当做文章的创建时间
            $_POST['ctime'] = time();
            // 将$POST数组中的数据追加到$data数组中，实现数据的添加
            $article[] = $_POST;
            // 将文章数据保存到数据库 实现数据的永久保存
            writedata('./database/article.php', $article);

            // 将文章保存成功后，跳转到首页
            go('添加文章成功',"index.php");
        }
        // 1. 加载文章添加页面模板 2.显示页面添加页面
        include './view/article/store.php';
    }

    /**
     * 文章编辑功能
     *
     */
    public function editor()
    {
        // 1. 接收id数据 2.用于取出数据库中的指定数据
        $id = $_GET['id'];

        // 1. 加载数据库 2.准备取出指定的文章
        $data = $this->dbdata;
        // 加载数据库，获取数据库中的内容，为首页提供文章数据
        $article = $this->article;

        // 如果有post数据提交过来，进行添加数据库操作
        if(IS_POST){

            // 将追加当前时间的时间戳，当做文章的创建时间
            $_POST['mtime'] = time();
            // 将id的数据提交出来
            $sid =$_POST['id'];
            // 将post中id删除
            unset($_POST['id']);
            // 将$POST数组中的数据追加到$data数组中，实现数据的添加
            $article[$sid] = $_POST;
            // 将文章数据保存到数据库 实现数据的永久保存
            writedata('./database/article.php', $article);

            // 将文章保存成功后，跳转到列表页
            go('修改文章成功',"?a=lists");
        }

        // 1。获取所有索引值 2.用于判断有否有指定id的文章
        $key = array_keys($article);

        // 现将id转整,再判断$GET数据中的id值，是否在数据库中，如果在，就显示，
        // 如果不在显示404 或者 返回首页
        if (in_array(intval($id), $key)){
            // 1.取出数据库中的指定文章 2.用于显示到编辑页面
            $art = $article[intval($id)];
            // 1. 加载文章编辑页面 2.用于文章的编辑
            include './view/article/editor.php';

        }else{
            // 1.当输入不存在的id时 2.进行页面跳转 防止恶意操作
            go('找不到该篇文章',"?a=lists");
        }
    }


    /**
     * 文章删除功能
     * 实现删除具体文章的功能
     */
    public function del()
    {

        // 接收id数据
        $id = $_GET['id'];


        // 1. 获取所有索引值 2.用于判断是否有指定id的文章
        $key = array_keys($this->article);

        // 现将id转整,再判断$GET数据中的id值，是否在数据库中，如果在，就显示，
        // 如果不在显示404 或者 返回首页
        if (in_array(intval($id), $key)) {
            // 1. 删除$data中的数据 2.实现删除文章的第一步
            unset($this->article[$id]);

            // 将文章数据保存到数据库 实现数据的永久保存
            writedata('./database/article.php', $this->article);

            // 将文章删除成功后，跳转到列表页
//            go('删除文章成功','?a=lists');
            echo "<script>location.href='?a=lists'</script>";


        } else {
        // 1.当用户输入不存在的id时 2.进行跳转到首页 防止恶意操作
            go('找不到该篇文章，点击跳回首页','index.php');

        }
    }


    /**
     * 非法请求时，显示错误，并跳转到首页
     * @param $method string 参数是要调用的方法名称
     * @param $parameters array 参数是一个枚举数组，包含着要传递给方法 $name 的参数
     */
    public function __call($method, $parameters){
        //  echo "非法请求，没有找到{$method}方法,5秒后跳回首页";
        echo "非法请求,3秒后跳回首页";
        //  使用meta标签的跳转功能 实现页面的跳转
        echo "<meta http-equiv='refresh' content='3;url=index.php'>";

    }

}