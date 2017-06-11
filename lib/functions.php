<?php

// 设置页面的格式编码，设置格式为utf-8格式
header("Content-type:text/html;charset=utf-8");

// 设置时区， 统一时间，均为东八区时间
date_default_timezone_set('PRC');

// 定义常量，判断有无POST数据提交，同时判断上传文件时有无post方式提交
define('ISPOST',$_SERVER['REQUEST_METHOD'] === 'POST'?true:false);

// 自动载入类函数
spl_autoload_register('load');


/**
 * 需要spl_autoload_register注册的类
 * @param $className string 出入的class名
 */
function load($className){
    // 拼接完整的加载路径，方便下面判断文件是否存在
    $file = "./controller/{$className}.class.php";
    // 判断在对应的目标中是否存在相应的文件
    if(is_file($file)){
    // 如果文件存在，加载使用相应的函数，个人或者网上都是使用require_once。毕竟类还是比较重要的
        require_once $file;
    }else{
    // 如果没有找到相应的文件，也就是没有找到相应的类，程序结束运行，同时显示错误信息
        die("没有找到{$file}文件");
    }
}

/**
 * 用于显示信息提醒
 * @param $str string 输入要弹出的字符串
 * @param $url string 用于跳转的链接
 */
function show($str,$url){

    $str1 = <<<con
<script> 
    alert("$str");
    location.href = "$url";
</script>
con;
    echo $str1;

}