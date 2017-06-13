<?php

/**
 * 文章操作类
 * Class ArticleController
 * 实现文章的增、删、改、查等功能
 */
class ArticleController
{
    private $dbdata;   // 1. 设置data属性 2. 用于接受保存数据库数据
    private $article;  // 1. 设置data属性 2. 用于接受保存数据库数据
    private $user;

    /**
     * ArticleController constructor.
     * 类的构造函数，用于初始化数据，根据$method方法的不同自动加载不同的功能页面
     * @param string $method  控制构造函数，加载不同的功能 默认是首页 index
     * @param string $dbPath  设置数据库文件的路径，默认是 "./lib/data.php"
     */
    public function __construct($method='index')
    {

        // 加载数据库文件 ，并将数据库文件保存到成员属性$data中
        // 1. 实现初始化时，加载数据库 2.导航栏数据
        $this->dbdata = require("./database/nav.php");
        // 1. 加载文章数据 2.用于显示文章
        $this->article = require("./database/article.php");
        // 1.加载用户表数据库 用于判断用户是否存在
        $this->user = require('./database/user.php');

        // 检查是否有cookie 2.如果有username信息 设置$session
        if(isset($_COOKIE['username'])){
            // 1.读取$_COOKIE中的username中的数值 2.url解码还原真实数据
            $luser = urldecode($_COOKIE['username']);
            // 1.变量数据库 2.判断cookie中存储的用户名是否在数据库中
            foreach ($this->user as $v){
                // 1.将用户中的数据库中的用户名加密 2.和cookie中的值比较
                $vs =md5(md5($v['username'])."666");
                // 1.如果cookie中的值 和数据库中的值完全相等 2.进行设置$session操作
                if($luser ===$vs){
                    // 1.将$v即用户数据库中指定的用户名设置到$_SESSION中 2.即实现用户的免登陆
                    $_SESSION['username']=$v['username'];
                }
            }
        }

        // 更加传参$method参数的不同，自动加载不同的类，实现不同的功能。利用变量函数的概念
        $this->$method();
    }


    /**
     *  文章首页功能
     *
     *  用于文章的展示功能和加载相应的页面模板
     */
    private function index()
    {
        // 1. 加载数据库，获取数据库中的内容，2. 为首页提供文章数据
        $data = $this->dbdata;
        // 1.加载文章数据库 2.位页面中的文章显示提供数据
        $article = $this->article;
        // 1.判断有无get请求 2.如果没有默认是 0 用于刚登陆时默认的显示数据
        $id = isset($_GET['id'])?$_GET['id']:0;
        // 测试是否能加载数据
        // var_dump($data);

        // 在模板中将数据变量出来，通过HTML混编的方式

        // 加载首页模板,
        // 发现没有对应的样式，因为页面加载是相对于首页中的index.php,
        // 而模板中的数据时相对于它们的当前页面加载样式的，所有加载的样式路径需要修改
        include './view/index.php';

    }

    /**
     * 登陆功能
     * 为文章系统提供登陆功能
     */
    private function login(){
        // 1. 当用户有post数据时，2.进行登录验证
        if($_POST){
            // 1.接收post数据
            // var_dump($_POST);

            // 1.获取用户名，去除左右空格  2. 用于后续操作
            $username = strtolower(trim(htmlspecialchars($_POST['username'])));
            // 1.获取密码 2.用于后续操作
            $pwd = $_POST['pwd'];
            // 1. 获取验证码 2.进行进一步验证
            $authcode = strtolower(trim($_POST['authcode']));
            // 1.判断验证码是否正确 2.精益办验证验证码是否正确
            if($authcode=== strtolower($_SESSION['authcode'])){
                // 1.删除post数据中的authcode内容，2. 用于下一步验证,验证码不需要输入数据库
                unset($_POST['authcode']);
            }else{
                // 1.显示结果 2.如果验证码错误 跳转到注册页面
                show('验证码错误','?a=login');exit;
            }
            // 1.判断数据是否为空 2.如果为空返回登录页面
            if(isset($username) && isset($pwd)){
                // 1. 读取密码文件库 2.用于后续操作
                // 1.加载数据库 2.用于数据验证
                $userdb = $this->user;
                // 1.遍历数据库变量 2. 取出数据中的每一组数值
                foreach ($userdb as  $k=>$v){
                    // 1. 判断输入姓名是否存在 2. 进行进一步验证
                    if(in_array($username,$v)){
                        // 1. 将输入的密码进行MD5加密 2. 与数据库中的文件进行加密
                        if(md5(md5($pwd)."3.14G") === $v['pwd']){
                            // 1. 开启session 2.如果用了存储数据
                            // 1.将用户名写入session 2.进行数据的持久保存
                            $_SESSION['username']=$username;

                            // *************cookie*****************
                            // 1. 将用户名经过双重md5加密，有效期 3消失 作用域整个域名内
                            // 2. 用户在此登录时，读取cookie值，判断是否在数据库中，如果在设置session
                            // 3. 实现简单的免登陆
                            $val = md5(md5($username)."666");
                            setcookie("username",$val,time()+3600*3,"/");

                            //*************************************

                            // 1. 显示结果 2. 跳转到首页
                            show("登录成功,欢迎{$username}的到来",'./index.php');
                        }else{
                            // 1. 显示结果，密码错误 2. 跳转到登录页面
                            show("密码错误",'?m=login');
                        }
                    }
                }
                // 1.显示结果 没有找到用户名 2.进行跳转到登录页面 3.当所有遍历都没有匹配到时，执行
                show("用户名不存在",'?m=login');
            }else{
                // 1.如果用户名或者密码为空 2.进行显示 同时跳转到 登录界面
                show("不能为空",'?m=login');
            }
        }else{ // 1.当没有post数据时 2.进行正常加载登录界面
            // 1.将至登录页面 2.用于用户登录
            include './view/login.php';
        }
    }

    /**
     * 注销功能
     * 为系统系统注销功能，让用户账号取消登陆
     */
    private function logout(){
        // 1.删除session中的用户名 2.实现注销功能
        unset($_SESSION['username']);
        setcookie("username","",666,"/");
        // 1.注销后让页面提供跳转 2.跳转到首页 网站注销后均是跳转到首页 ，取消用户特权
        echo "<script>location.href='index.php'</script>";
    }

    // 注册
    private function register(){
        // 1. 当有post数据请求时进行操作 2. 进行数据的验证
        if($_POST){

            // 1.当用户提交post数据时 2.进行数据的存储
            if(isset($_POST['username'])&&isset($_POST['pwd'])&&isset($_POST['repwd'])&&isset($_POST['authcode'])&&isset($_POST['emailname'])){
;
                // 接收用户数据
                // 1.接收数据 2 接收用户名 3.安全性过滤
                $username = strtolower(trim(htmlspecialchars($_POST['username'])));
                // 1.接收用户数据 2.接收用户密码
                $pwd = trim($_POST['pwd']);
                // 1.接收用户数据 2.接收用户重复密码
                $repwd = trim($_POST['repwd']);
                // 1.接收用户数据 2.接收用户输入的验证码
                $authcode = strtolower(trim($_POST['authcode']));

                // 引入数据库
                $userdb = $this->user;
                // 再次检查是否有数据库重名
                // 1. 用户名是否存在检测  2.防止用户名重复
                foreach ($userdb as $v){
                    // 1.遍历data数组 2. 进行用户名判断 3.当用户名在数组中使 跳回到注册页面
                    if(in_array($username,$v)){
                        // 1.显示结果 2.如果用户名存在 跳转到注册页面
                        show('用户名已存在,请重新填写用户名','?a=register');exit;
                    }
                }

                //1. 判断验证码是否正确  2.进一步检验安全性
                if($authcode=== strtolower($_SESSION['authcode'])){
                   // 1.删除post数据中的authcode内容，2. 用于下一步验证,验证码不需要输入数据库
                    unset($_POST['authcode']);
                }else{
                    // 1.显示结果 2.如果验证码错误 跳转到注册页面
                    show('验证码错误','?a=register');exit;
                }

                // 验证邮箱是否正确

                // 1. 判断用户名 2. 进一步判断
                if(mb_strlen(trim($username))>=3 && mb_strlen(trim($username))<=16){
                    // 1.判断两次密码是否正确 2.如果不正确跳回注册页面
                    if ($pwd === $repwd){
                        // 1.添加注册时间 2.保存注册信息
                        $_POST['ctime'] = time();
                        //1.删除$Post中的repwd 2.不需要进入数据库
                        unset($_POST['repwd']);
                        // 1. 数据加密 2.增加数据安全
                        $_POST['pwd']=md5(md5($pwd)."3.14G");
                        // 1.将数据追加到$data 2.准备数据写入字符串
                        array_push($userdb,$_POST);
                        // 1.将$data数组变成字符串 , 2.方便将数据保存到数据库文件中
                        $code = var_export($userdb,true);
                        // 1.字符串拼接，2.保持数据库文件格式的一致
                        $code = <<<con
<?php
    return $code;
con;

                        //1. 将字符串写入数据库文件，2.进行数据的持久保存
                        file_put_contents('./database/user.php',$code);
                        // 1.显示操作结果 2.跳转到首页进行登录
                        show("注册成功，请{$username}进行登录",'?m=login');
                    }else{
                        // 1. 当两次密码不正确时 ，显示结果 2. 进行跳转到注册页面
                        show("两次密码不正确，请重新填写","?m=register");
                    }
                }else{
                    // 1. 当用用户名 小于6位时 ，2 跳转到注册页面 进一步验证
                    show("用户名小于6位，请重新填写","?m=register");
                }
                // htmlspecialchars()
                // 数据入库
                // 显示注册成功，跳转到登录页面进行登录

            }elseif (isset($_POST['username'])){ // 1. 当用户输入用户名时 2.检查用户名是否可用

                // 1.取出post数据 2.进行后续操作
                $name = $_POST['username'];
                // 引入数据库
                $userdb = $this->user;

                // 再次检查是否有数据库重名
                // 1. 用户名是否存在检测  2.防止用户名重复
                foreach ($userdb as $v){
                    // 1.遍历data数组 2. 进行用户名判断 3.当用户名在数组中使 跳回到注册页面
                    if(in_array($name,$v)){
                        // 1.显示结果 2.如果用户名存在 则输出2
                       echo 2; exit;
                    }
                }

                // 1. 验证网址正则 2.用于验证网址是否合法
                $preg = "/^\w{3,16}$/i";
                // 1.进行正则判断，2.验证用户名是否合法
                if(preg_match($preg,$name)){
                    // 1.输出显示结果 2.返回给客户端
                    echo 1;
                }else{
                    // 1.输出显示结果 2.返回给客户端
                    echo 0;
                }


            }elseif (isset($_POST['authcode'])){ // 1.当用户输入验证码时 2.验证验证码是否正确
                // 1. 当用户手动输入验证码时 2.通过ajax实时显示是否正确 方便用户
                if(strtolower($_POST['authcode'])=== strtolower($_SESSION['authcode'])){
                    // 1.当用户输入正确时 显示1 2.传递到页面有js操作页面的具体操作
                    echo 1;
                }else{
                    // 1.当用户输入失败时 显示0 2.传递到页面有js操作页面的具体操作
                    echo 0;
                }
            }elseif (isset($_POST['emailname'])){ // 1.当用户输入邮箱时 2.验证邮箱是否正确
                // 1.取出post数据 2.进行后续操作
                $email = strtolower($_POST['emailname']);
                // 1. 引入数据库 2.为用户验证是否重复提供数据
                $userdb = $this->user;

                // 再次检查是否有数据库重名
                // 1. 用户名是否存在检测  2.防止用户名重复
                foreach ($userdb as $v){
                    // 1.遍历data数组 2. 进行用户名判断 3.当用户名在数组中使 跳回到注册页面
                    if(in_array($email,$v)){
                        // 1.显示结果 2.如果用户名存在 则输出2
                        echo 2; exit;
                    }
                }

                // 1.验证邮箱正则表达式 2.用于验证邮箱的合法性
                $pattern ="/^[\w-]+@\w+(\.[a-z]+)?\.\w+$/i";
                // 1.进行正则判断，2.验证email是否合法
                if(preg_match($pattern,$email)){
                    // 1.输出显示结果 2.返回给客户端
                    echo 1;
                }else{
                    // 1.输出显示结果 2.返回给客户端
                    echo 0;
                }
            }
        }else{
            // 1. 将没有post数据提交时 2.加载用户注册页面
            include './view/register.php';
        }
    }


    /**
     * 文章列表功能
     * 用于实现具体文章的显示，同时加载相应的展示模板页面
     */
    private function lists()
    {
        // 1.检查$_SESSION是否有username值 2.用来判断用户有无权限进入该页面
        if(!isset($_SESSION['username'])){
            // 1.将页面跳转到主页 2.如果用户没有登录的情况下
            echo "<script>alert('请登录后进入');location.href='index.php'</script>";
        }
        // 加载数据库，获取数据库中的内容，为导航条提供数据
        $data = $this->dbdata;
        // 加载数据库，获取数据库中的内容，为首页提供文章数据
        $article = $this->article;
        // 1.加载文章列表功能 2.实现文章列表的展示
        include './view/lists.php';
    }


    /**
     * 文章添加页面功能
     *
     * 用于文章的加载和文章添加页面的加载
     */
    private function store()
    {
        // 加载数据库，获取数据库中的内容，为导航条提供数据
        $data = $this->dbdata;
        // 加载数据库，获取数据库中的内容，为首页提供文章数据
        $article = $this->article;
        // 当有post数据传递过来时，进行操作
        if ($_SERVER['REQUEST_METHOD'] === 'POST' ? true : false) {

            // 将追加当前时间的时间戳，当做文章的创建时间
            $_POST['ctime'] = time();
            // 将$POST数组中的数据追加到$data数组中，实现数据的添加
            $article[] = $_POST;
            // 将$data数据合法化，准备重新写入数据库
            $newData = var_export($article, true);
            // 拼接数据库的结构，准备写入数据库
            $newData = <<<data
<?php 
    return {$newData};
data;
            // 将合法化的数据重新写入数据库，实现数据的保存
            file_put_contents('./database/article.php', $newData);

            // 将文章保存成功后，跳转到首页
            echo <<<str
<script>
    alert('添加文章成功');
    window.location.href = 'index.php';
    
</script>
str;
        }
        // 1. 加载文章添加页面模板 2.显示页面添加页面
        include './view/store.php';
    }

    /**
     * 文章编辑功能
     *
     */
    private function editor()
    {
        // 1. 接收id数据 2.用于取出数据库中的指定数据
        $id = $_GET['id'];

        // 1. 加载数据库 2.准备取出指定的文章
        $data = $this->dbdata;
        // 加载数据库，获取数据库中的内容，为首页提供文章数据
        $article = $this->article;

        // 如果有post数据提交过来，进行添加数据库操作
        if($_SERVER['REQUEST_METHOD'] === 'POST' ? true : false){

            // 将追加当前时间的时间戳，当做文章的创建时间
            $_POST['mtime'] = time();
            // 将id的数据提交出来
            $sid =$_POST['id'];
            // 将post中id删除
            unset($_POST['id']);
            // 将$POST数组中的数据追加到$data数组中，实现数据的添加
            $article[$sid] = $_POST;
            // 将$data数据合法化，准备重新写入数据库
            $newData = var_export($article, true);
            // 拼接数据库的结构，准备写入数据库
            $newData = <<<data
<?php 
    return {$newData};
data;
            // 将合法化的数据重新写入数据库，实现数据的保存
            file_put_contents('./database/article.php', $newData);

            // 将文章保存成功后，跳转到首页
            echo <<<str
<script>
    alert('修改文章成功');
    window.location.href = 'index.php?m=lists';
    
</script>
str;
        }

        // 1。获取所有索引值 2.用于判断有否有指定id的文章
        $key = array_keys($article);

        // 现将id转整,再判断$GET数据中的id值，是否在数据库中，如果在，就显示，
        // 如果不在显示404 或者 返回首页
        if (in_array(intval($id), $key)){
            // 1.取出数据库中的指定文章 2.用于显示到编辑页面
            $art = $article[intval($id)];
            // 1. 加载文章编辑页面 2.用于文章的编辑
            include './view/editor.php';

        }else{
            // 1.当输入不存在的id时 2.进行页面跳转 防止恶意操作
            echo <<<str
<script>
    alert('找不到该篇文章');
    window.location.href = '?m=list';
    
</script> 
str;
        }

    }


    /**
     * 文章删除功能
     * 实现删除具体文章的功能
     */
    private function del()
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

            // 1. 将$data数据重新写入数据库 2.合法化数据
            $newData = var_export($this->article, true);
            // 1. 拼接数据库的结构，2.准备写入数据库
            $newData = <<<data
<?php 
    return {$newData};
data;
            // 将合法化的数据重新写入数据库，实现数据的保存
            file_put_contents('./database/article.php', $newData);

            // 将文章删除成功后，跳转到首页
            echo <<<str
<script>
    alert('删除文章成功');
    window.location.href = 'index.php?m=lists';
    
</script>

        } else {
        // 1.当用户输入不存在的id时 2.进行跳转到首页 防止恶意操作 
            echo <<<str
<script>
    alert('找不到该篇文章，点击跳回首页');
    window.location.href = 'index.php';
    
</script> 
str;
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