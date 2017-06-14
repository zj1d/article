<?php

/**
 * 基类
 * 提取出类中共同的方法，方便各个子类的继承使用
 * 定义成abstract类 ，防止父类被直接实例化
 * Class Base
 */
abstract class Base{
    /**
     * 载入模板功能
     */
    protected function view(){
        // include "./view/member/login.php"

        // 将常量转化成小写 因为文件名和文件夹名都是小写
        // 都转化成小写 和文件夹和文件名相符
        $c = strtolower(CONTROLLER);
        $a = strtolower(ACTION);
        $str = "./view/$c/$a.php";
        // 根据类名和方法名的不同 调用相应view文件夹下相应的模板文件
        // 所有view文件夹中的命名一定要和controller的类名方法名相符
        // 即文件夹 对应相应的类名 文件名对应相应类中的类方法名
        include $str;
    }
}