<?php

class Member extends Base
{

    private $userdata;
    public function __construct()
    {
        // 1.加载用户表数据库 用于判断用户是否存在
        $this->userdata = require('./database/user.php');
    }

    /**
     * 登陆功能
     * 为文章系统提供登陆功能
     */
    public function login(){
        // 1. 当用户有post数据时，2.进行登录验证
        if($_POST){
            // 登录次数代码
            // 0: 代表不验证验证码
            // 判断有无$_SESSION['error'] 如果没有设置为0 如果已设置保持不变
            if(!isset($_SESSION['error'])){
                $_SESSION['error']=0;
            }

            if(isset($_SESSION['error'])&&$_SESSION['error']!==0) {
                // 1. 获取验证码 2.进行进一步验证
                $authcode = strtolower(trim($_POST['authcode']));
                // 1.判断验证码是否正确 2.精益办验证验证码是否正确
                if ($authcode === strtolower($_SESSION['authcode'])) {
                    // 1.删除post数据中的authcode内容，2. 用于下一步验证,验证码不需要输入数据库
                    unset($_POST['authcode']);
                } else {
                    // 1.显示结果 2.如果验证码错误 跳转到注册页面
                    go('验证码错误', '?a=login');
                }
            }
            // $_SESSION['error'] 增加 时验证码显示
            $_SESSION['error']+=1;

            // 1.获取用户名，去除左右空格  2. 用于后续操作
            $username = strtolower(trim(htmlspecialchars($_POST['username'])));
            // 1.获取密码 2.用于后续操作
            $pwd = $_POST['pwd'];


            // 1.判断数据是否为空 2.如果为空返回登录页面
            if(isset($username) && isset($pwd)){
                // 1. 读取密码文件库 2.用于后续操作
                // 1.加载数据库 2.用于数据验证
                $userdb = $this->userdata;
                // 1.遍历数据库变量 2. 取出数据中的每一组数值
                foreach ($userdb as  $k=>$v){
                    // 1. 判断输入姓名是否存在 2. 进行进一步验证
                    if(in_array($username,$v)){
                        // 1. 将输入的密码进行MD5加密 2. 与数据库中的文件进行加密
//                        if(md5(md5($pwd)."3.14G") === $v['pwd']){
                        if(password_verify($pwd,$v['pwd'])){
                            // 1. 开启session 2.如果用了存储数据
                            // 1.将用户名写入session 2.进行数据的持久保存
                            $_SESSION['username']=$username;

                            // 当用户在登录时选择记住密码是  进行cookie的重写
                            if(isset($_POST["autologin"])){
                                // 设置cookie  重新设置右session自动设置在客户端中的cookie中的保存时间 保存时间为7天
                                setcookie(session_name(),session_id(),time()+3600*24*7,"/");
                            }

                            // 1. 显示结果 2. 跳转到首页
                            go("登录成功,欢迎{$username}的到来",'index.php');
                        }else{
                            // 1. 显示结果，密码错误 2. 跳转到登录页面
                            go("密码错误",'?c=member&a=login');
                        }
                    }
                }
                // 1.显示结果 没有找到用户名 2.进行跳转到登录页面 3.当所有遍历都没有匹配到时，执行
                go("用户名不存在",'?c=member&a=login');
            }else{
                // 1.如果用户名或者密码为空 2.进行显示 同时跳转到 登录界面
                go("不能为空",'?c=member&a=login');
            }
        }else{ // 1.当没有post数据时 2.进行正常加载登录界面
            // 1.将至登录页面 2.用于用户登录
            include './view/member/login.php';
        }
    }

    /**
     * 注销功能
     * 为系统系统注销功能，让用户账号取消登陆
     */
    public function logout(){
        // 1.删除session中的用户名 2.实现注销功能
        unset($_SESSION);
        session_destroy();
        // 1.注销后让页面提供跳转 2.跳转到首页 网站注销后均是跳转到首页 ，取消用户特权
        echo "<script>location.href='index.php'</script>";
    }

    // 注册
    public function reg(){
        // 1. 当有post数据请求时进行操作 2. 进行数据的验证
        if($_POST){


            // 1.当用户提交post数据时 2.进行数据的存储
            if(isset($_POST['username'])&&isset($_POST['pwd'])&&isset($_POST['repwd'])&&isset($_POST['authcode'])&&isset($_POST['emailname'])){

                // 接收用户数据
                // 1.接收数据 2 接收用户名 3.安全性过滤
                $username = strtolower(trim(htmlspecialchars($_POST['username'])));
                // 1.接收用户数据 2.接收用户密码
                $pwd = trim($_POST['pwd']);
                // 1.接收用户数据 2.接收用户重复密码
                $repwd = trim($_POST['repwd']);

                // 引入数据库
                $userdb = $this->userdata;
                // 再次检查是否有数据库重名
                // 1. 用户名是否存在检测  2.防止用户名重复
                foreach ($userdb as $v){
                    // 1.遍历data数组 2. 进行用户名判断 3.当用户名在数组中使 跳回到注册页面
                    if(in_array($username,$v)){
                        // 1.显示结果 2.如果用户名存在 跳转到注册页面
                        go('用户名已存在,请重新填写用户名','?a=reg');
                    }
                }

                // 首先验证 验证码 若果错误 直接推到登录页面
                // 1.接收用户数据 2.接收用户输入的验证码
                $authcode = strtolower(trim($_POST['authcode']));
                //1. 判断验证码是否正确  2.进一步检验安全性
                if($authcode=== strtolower($_SESSION['authcode'])){
                    // 1.删除post数据中的authcode内容，2. 用于下一步验证,验证码不需要输入数据库
                    unset($_POST['authcode']);
                }else{
                    // 1.显示结果 2.如果验证码错误 跳转到注册页面
                    go('验证码错误','?a=reg');
                }


                // 1. 判断用户名 2. 进一步判断
                if(mb_strlen(trim($username))>=3 && mb_strlen(trim($username))<=16){
                    // 1.判断两次密码是否正确 2.如果不正确跳回注册页面
                    if ($pwd === $repwd){
                        // 1.添加注册时间 2.保存注册信息
                        $_POST['ctime'] = time();
                        //1.删除$Post中的repwd 2.不需要进入数据库
                        unset($_POST['repwd']);
                        // 1. 数据加密 2.增加数据安全
//                        $_POST['pwd']=md5(md5($pwd)."3.14G");
                        $_POST['pwd'] = password_hash($_POST['pwd'],PASSWORD_DEFAULT );
                        // 1.将数据追加到$data 2.准备数据写入字符串
                        array_push($userdb,$_POST);
                        //1. 将字符串写入数据库文件，2.进行数据的持久保存
                        writedata("./database/user.php",$userdb);

                        go("注册成功，请{$username}进行登录",'?c=member&a=login');
                    }else{
                        // 1. 当两次密码不正确时 ，显示结果 2. 进行跳转到注册页面
                        go("两次密码不正确，请重新填写","?c=member&a=reg");
                    }
                }else{
                    // 1. 当用用户名 小于6位时 ，2 跳转到注册页面 进一步验证
                    go("用户名小于6位，请重新填写","?c=member&a=reg");
                }
                // htmlspecialchars()
                // 数据入库
                // 显示注册成功，跳转到登录页面进行登录

            }elseif (isset($_POST['username'])){ // 1. 当用户输入用户名时 2.检查用户名是否可用

                // 1.取出post数据 2.进行后续操作
                $name = $_POST['username'];
                // 引入数据库
                $userdb = $this->userdata;

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
                $userdb = $this->userdata;

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
            include './view/member/reg.php';
        }
    }


    /**
     * 验证码功能
     * 为登录或者注册提供验证功能
     */
    public function code(){
        // 加载验证码类 准备实例化验证码类
        require_once "./tools/AuthCode.php";
        // 1. 实例化验证码对象 2.调用用里面的函数实现验证码
        $auth = new AuthCode('./resource/font/Spectral-ExtraBold.ttf',100,36,18,4,[["style"=>"circle","num"=>4],["style"=>"dot","num"=>100]],"#dddddd");
// 1. 调用验证码中的show方法 2.最终实现验证码的输出
        $authcode = $auth->show();
        // 1.将验证码产生的字符串结果保存到session中 2.用于验证字符串结果的对错
        $_SESSION['authcode'] = $authcode;
    }

    /**
     * 找回密码方法
     */
    public function retrieve()
    {
        echo "找回密码";
    }

    /**
     * 删除用户账号功能
     */
    public function delete()
    {
        echo "删除用户";
    }


}