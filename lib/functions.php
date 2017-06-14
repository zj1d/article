<?php

// 设置时区， 统一时间，均为东八区时间
date_default_timezone_set('PRC');

//*********************************************************************************

// 自动载入类函数
spl_autoload_register("load");
/**
 * 需要spl_autoload_register注册的函数
 * @param $className string 传入的class名
 * $className有系统自动传入
 */
function load($className){
    // 拼接处需要加载类的完整路径，方便判断对应的文件是否存在
    $file = "./controller/{$className}.php";
    // 判断对应的文件是否存在
    if(is_file($file)){
        require_once $file;
    }else{
        exit("没有找到{$className}类");
    }
}

//***********************************************************************************

/**
 * 用于显示信息提醒
 * @param $str string 输入要弹出的字符串
 * @param $url string 用于跳转的链接
 * 使用exit 输出 防止程序继续执行
 */
function go($msg,$url){
// 在调用函数时设置heade,不是所有的地方都需要设置header ，能省则省
    header("Content-type:text/html;charset=utf-8");
    $str1 = <<<con
<script> 
    alert("$msg");
    location.href = "$url";
</script>
con;
    exit($str1);

}

//************************************************************************************

// 定义常量 用于判断有无post数据
define('IS_POST',$_SERVER["REQUEST_METHOD"]==='POST'?true:false);

//************************************************************************************

/**
 * 将数据写入数据库中
 * @param $database  string  需要写入数据的数据库文件
 * @param $data  array  将要写入数据库中的数据
 */
function writedata($database,$data){
    // 首先将数据合法化 变成可用的字符串类型 方便写入数据库
    $data = var_export($data,true);
    // 拼接字符串 拼接处符合数据库数据结构的数据
    $str =<<<str
<?php 
    return $data;
str;
    // 将合法化的 和原有数据结构相同的变量数据 由内存写入数据库文件 实现持久保存
    file_put_contents($database,$str);

}

//************************************************************************************