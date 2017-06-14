/**
 * Created by ziyun on 2017/6/11.
 */
$(function () {

    // data 初始值
    // data 不干扰css样式，更简单更方便
    $('.auth').data({'s':0});

    // 验证验证码对错
    $('input[name=authcode]').blur(function () {
        var name = $(this);
        var authcode = name.val();
        $.post('index.php?c=member&a=reg',{'authcode':authcode},function (data) {
            if(data==1){
                name.data({'s':1});
                // $(this).parent().parent().find('.error').show().html(data);
                name.parent().parent().parent().find(".error").css({'color':"green"}).html("验证码正确").show();
            }else {
                name.data({'s':0});
                // $(this).parent().parent().find('.error').show("").html(data);
                name.parent().parent().parent().find(".error").css({'color':"red"}).html("验证码错误").show();
            }
        });

    });

    $('form').submit(function () {
        $('.auth').blur();

        // 收集 每个data值

        if ($('.auth').data('s')!=1){
            return false;
        }

    })
});