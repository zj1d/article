<?php

// 1. 引入函数库 2.使用函数中的函数自动加载功能  设置页面编码 以及设置默认时区的功能
require_once "./lib/functions.php";

// 设置session的名称 是再客户端中的cookie不容易识别 增加安全性
session_name('zy');

// 1.开启session 2.用于保存验证码信息 方便验证
session_start();




// 控制器 c controller
// 根据传入不同的参数 调用不同的类 类首字母大写 所有使用ucfirst首字母大写
$c = isset($_GET['c'])?ucfirst($_GET['c']):'Article';


// 方法 a action
// 根据get参数中a的值 调用不同的类中的功能
$a = isset($_GET['a'])?$_GET['a']:"index";

// 定义方法常量 方便类中使用调用相应的视图模板
define("ACTION",$a);

// 定义类常量 方便类中使用调用相应的视图模板
define("CONTROLLER",$c);

// call_user_func_array([对象，方法],[参数]);
// 实例化$c对代表的对象 ，并且调用 对象中的$a中对对应的成员方法
// [] 代表所需要传递的参数
// 如果直接访问index.php没有带任何get参数，会默认访问Home类中的entry方法
call_user_func_array([new $c,$a],[]);