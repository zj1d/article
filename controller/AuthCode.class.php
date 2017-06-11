<?php

/**
 * 验证码类
 * Class Code
 * 需要实现的功能：
 * 1.控制字符的显示位数 int
 * 2.图片的格式 png/jpeg/gif
 * 3.干扰元素['形状'=>位数;'形状'=>位数]
 * 4.是否可以实际使用静态类实现
 * 5.显示字符的字符集 []
 * 6.字体文件的设置 string
 * 7.验证码的宽高
 * 8.字体大小
 */
class AuthCode
{
    private $length;    // 1.定义私有属性 2.用于控制验证码的长度或显示位数
    private $style;     // 1.定义私有属性 2.用于控制图像的格式
    private $string = "1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";    // 1.定义私有属性 2.用于存放字符集
    private $height;    // 1.定义私有属性 2.用于设置验证码的高度
    private $width;    // 1.定义私有属性 2.用于设置验证码的宽度
    private $fontsize;  // 1.定义私有属性 2.用于设置验证码的显示的字体大小
    private $fontfile;  // 1.定义私有属性 2.用于设置显示验证码的字体 或者是设置字体库文件 *.ttf的位置
    private $bgcolor;   // 1.定义私有属性 2.用于设置验证码的背景色

    private $im;        // 1.定义私有属性 2.用于存放创建画布返回的资源句柄
    private $resString; // 1.用于保存验证码中的字符串 2.为验证验证字符串的正确性

    /**
     * AuthCode constructor.
     * @param int $width   1. 用于设置验证码的宽度 2.有默认参数：200 或者是设置开辟的画布的宽度
     * @param int $height   1. 用于设置验证码的高度 2.有默认参数：100 或者是设置开辟的画布的高度
     * @param int $fontsize 1. 用于设置验证码字体的大小 2.有默认值：30
     * @param int $length   1.用于设置验证码的位数  2.有默认参数：6
     * @param string $fontfile 1.设置是当前的字体库文件 2.设置时需要设置 用于控制使用的字体样式
     * @param array $style  1. 用于设置验证码的干扰素 ，是一个二维数组，有默认值 ，默认 干扰素是圆
     *                      2.如：[["style" => "circle", "num" => 10]] ，可以同时设置多种样式
     *                          style ：设置干扰素的类型：现在可以设置 circle，dot ,line (圆，点，线)
     *                          num : 用于设置干扰元素的个数 。
     * @param string $bgcolor  1.设置验证码的背景色 2.可以设置背景设 使用十六进制的颜色表示。如果不传参，颜色随机
     */
    public function __construct( $fontfile,$width = 200, $height = 100, $fontsize = 30, $length = 6,$style = [["style" => "circle", "num" => 10]], $bgcolor=null)
    {
        $this->fontfile = $fontfile;    // 1.将$fontfile参数保存到类的成员私有属性$fontflile中，2.用于设置字体文件的文字，控制字体的样式 3.没有默认值，因为字体文件不属于字体类，所有必须单独设置
        $this->height = $height;        // 1.将$height参数保存到类的成员私有属性$height中 2.有默认值,用于控制验证码的高度
        $this->width = $width;          // 1.将$width参数保存到类的成员私有属性$width中 2.有默认值，用于控制验证码的宽度
        $this->fontsize = $fontsize;    // 1.将$fontsize参数保存到类的成员私有属性$fontsize中 ，2.有默认值 用于设置验证码字体的大小
        $this->length = $length;        // 1.将$length参数保存类的成员私有属性$length中 ，2.有默认值 ，用于设置验证码中字母的格式
        $this->style = $style;          // 1.将$style参数保存到类的成员私有属性$style中 ，2.有默认值，用于设置验证码的干扰素，默认是圆圈
        $this->bgcolor = $bgcolor;      // 1.将$style参数保存到类的成员私有属性$bgcolor中，2.默认值为null, 用于设置验证码的背景色，如果设置必须是颜色的十六进制颜色表示，不设置背景色随机改变

    }

    /**
     *  1. 对外：验证码类的唯一开放方法，
     *  2. 对内：调用类中使用的各个方法，实现生成验证码的功能
     */
    public function show()
    {
        // 1. 发送头部 ，2.声明输出格式为图片
        header("Content-type:image/png");

        // 1.创建画布并填充背景色 2.开辟内存空间继续下一步操作
        $this->createBg();

        // 1.调用write私有方法，实现文字的写入 2.实现验证码的基本功能
        $this->write();

        // 1.调用makeTroub()私有方法，往验证码中添加一些干扰元素 2. 有效阻止机器的恶意行为
        $this->makeTrouble();

        // 1.调用showDestory()私有方法，实现图像的最终输出，同时销毁所占内存资源 2.最终完成验证码类的实现
        $this->showDestory();

       return $this->resString;
    }

    /**
     *  1. 实现验证码类的资源创建和背景色的填充
     *  2. 为创建验证码开出内存空间，为以后操作使用
     */
    private function createBg()
    {
        // 1.创建真彩画布 2.位下面操作开辟空间 经资源句柄保存到im属性中
        $this->im = imagecreatetruecolor($this->width, $this->height);
        // 1. 设置背景颜色， 2.用于填充验证码区域
        $bg = imagecolorallocate($this->im, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255));
        // 1.判断是否有构造函数中的传参，2. 如果有使用传过来的参数，如果没有参数使用随机数生成背景色
        $bg = $this->bgcolor?hexdec($this->bgcolor):$bg ;
        // 1 .填充背景  2.使图片有填充背景色
        imagefill($this->im, 0, 0, $bg);

    }

    /**
     * 1. 验证码文字写入部分
     * 2. 将字符写入画布中，文字均随机产出，位数收类成员私有属性$length控制
     */
    private function write()
    {
        // 1. 获取字符集的长度 2.用于控制随机数的范围，便于随机选出字符集中的字符
        $strlen = strlen($this->string) - 1;
        // 1.将类常用属性设置为空字符串 2.准备接受几次随机产出的字符串
        $this->resString ="";
        // 1.通过for循环随机产生字符串，并将字符串结果写入画布中，循环次数受类成员私有属性$length控制
        for ($i = 0; $i < $this->length; $i++) {
            // 1. 将验证码平分成$this->length分 ，2.用法格式化显示每个字符
            $mwidth = $this->width / $this->length;
            // 1. 计算出字符在画布中的高度位置 2.使写入文章的高度居中
            $phtight = ($this->height + $this->fontsize) / 2;
            // 1.产出字符准备写入画布 2.通过随机数随机生成
            $str = $this->string[mt_rand(0, $strlen)];
            // 1.将字符依次写入画布中 2.字符大小 ，字体格式收相应的成员属性控制 3.字符的旋转角度，字符，颜色均有随机产生
            imagettftext($this->im, $this->fontsize, mt_rand(-45, 45), $mwidth * $i + 10, $phtight, imagecolorallocate($this->im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255)), $this->fontfile, $str);
            // 通过产生的字符都保存到类成员属性$resString中
            $this->resString.=$str;
        }
    }

    /**
     *  1. 验证码 产生干扰素部分
     *  2. 进行过滤一部分机器软件的恶意行为，提高安全性
     */
    private function makeTrouble()
    {
        // 1.变量类成员属性$style，是一个二维数组 2.用于判断具体设置了哪种干扰元素和具体的数量
        foreach ($this->style as $K => $v) {
            //  1.当$style属性中 设置了的style的属性值是"circle" 圆时 2.执行随机产生圆的操作 产生的数量收 num的控制
            if ($v['style'] === 'circle') {

                // 画圆
                // 1.通过循环产生不同数量的圆 2.圆点数量收num控制 ，3圆的大小随机产出
                for ($k = 0; $k < $v['num']; $k++) {
                    // 1.设置随机产生圆的半径的取值范围 2.用于控制产生圆的半径 3.随机数范围大，可以呈现弧线的效果
                    $wh = mt_rand(0, 100);
                    // 1.产生的源的颜色 2.通过随机产生 方便下面使用
                    $color = imagecolorallocate($this->im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
                    // 1.开始画圆 2.通过随机数产出 画出不同位置，不同大小的圆
                    imageellipse($this->im, mt_rand(0, $this->width), mt_rand(0, $this->height), $wh, $wh, $color);
                }
            }

            // 1. 判读类型  2. 执行对应的方法
            // 1.当$style属性中 设置了的style的属性值是"dot" 点时 2.执行随机产生点的操作 产生的数量收 num的控制
            if ($v['style'] === 'dot') {
                // 1.输出点  2.使用点元素进行验证码的干扰
                for ($i = 0; $i < $v['num']; $i++) {
                    // 1.产生的圆的颜色 2.通过随机产生 方便下面使用
                    $colorl = imagecolorallocate($this->im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
                    // 1.开始在验证码范围内画点 2.可以生成不同颜色不同位置的像素点
                    imagesetpixel($this->im, mt_rand(0, $this->width), mt_rand(0, $this->height), $colorl);
                }
            }

            // 1.当$style属性中 设置了的style的属性值是"line" 线时 2.执行随机产生线的操作 产生的数量收 num的控制
            if ($v['style'] === 'line') {
                // 划线
                // 1.通过循环产生不同数量的线段 2.线段数量收num控制 ，3线段的长度随机产出
                for ($i = 0; $i < $v['num']; $i++) {
                    // 1.产生的线段的颜色 2.通过随机产生 方便下面使用
                    $colorl = imagecolorallocate($this->im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
                    // 1.开始在验证码范围内画线段 2.可以生成不同颜色不同位置不同长度的线段
                    imageline($this->im, mt_rand(0, $this->width), mt_rand(0, $this->height), mt_rand(0, $this->width), mt_rand(0, $this->height), $colorl);
                }
            }
        }


    }

    /**
     * 输出验证码 销毁内存资源
     * 是实现验证码的最后一步
     */
    private function showDestory()
    {
        // 1.显示验证码 2.实现验证码的显示 或对外输出
        imagepng($this->im);
        // 1.销毁资源 2.释放内存空间
        imagedestroy($this->im);
    }

}
