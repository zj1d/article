<?php

// 1. 引入函数库 2.使用函数中的函数自动加载功能  设置页面编码 以及设置默认时区的功能
require_once "./lib/functions.php";

// 1.开启session 2.用于保存验证码信息 方便验证
session_start();




// 1. 如果有auth的get请求 2.则生成验证码 否则加载模板功能
if(isset($_GET['auth']) && $_GET['auth']==='authcode'){
    // 1. 实例化验证码对象 2.调用用里面的函数实现验证码
    $auth = new AuthCode('./resource/font/OpenSans-Regular.ttf',100,36,18,4,[["style"=>"circle","num"=>4],["style"=>"dot","num"=>100]],"#dddddd");
// 1. 调用验证码中的show方法 2.最终实现验证码的输出
    $authcode = $auth->show();
    // 1.将验证码产生的字符串结果保存到session中 2.用于验证字符串结果的对错
    $_SESSION['authcode'] = $authcode;

}else{
    // 1. 判断get请求 2.如果没哟参数 默认请求index
    $action = isset($_GET['m'])?$_GET['m']:'index';
    // 1.实例化ArticleController类，生成对象 2. 根据参数的不同调用对象中的不同功能
    $main = new ArticleController($action);
}

