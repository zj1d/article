/**
 * Created by ziyun on 2017/5/9.
 */
$(function () {
    // data 初始值
    // data 不干扰css样式，更简单更方便
    $('.auth').data({'s':0});

    // 验证用户名
    $('input[name=username]').blur(function () {
        var name = $(this);
        var val = name.val();

        if(val.length<3 || val.length>16){
            name.data({'s':0});
            name.parent().parent().find('.error').html("用户名有3-16位字符组成").show().siblings(".tixing").hide();
        }else {
            $.post('index.php?m=register',{'username':val},function (data){
                if(data==1){
                    name.data({'s':1});
                    name.parent().parent().find(".error").css({'color':"green"}).html("用户名可用").show().siblings(".tixing").hide();
                }else if (data==2){
                    name.data({'s':0});
                    name.parent().parent().find(".error").css({'color':"red"}).html("用户名已存在").show().siblings(".tixing").hide();
                }else {
                    $(this).data({'s':0});
                    name.parent().parent().find(".error").css({'color':"red"}).html("用户名有3-16位字符组成").show().siblings(".tixing").hide();
                }
            });
        }

    });

    // 验证邮箱

    // 验证邮箱
    $('input[name=emailname]').blur(function () {
        var name = $(this);
        $.post("index.php?m=register",{'emailname':name.val()},function (data) {
            // $name.parent().parent().find(".error").html(a).show();
            if(data==1){
                name.data({'s':1});
                name.parent().parent().find(".error").css({'color':"green"}).html("email可用").show();
            }else if (data==2){
                name.data({'s':0});
                name.parent().parent().find(".error").css({'color':"red"}).html("email已使用在，请更换email").show();
            }else {
                name.data({'s':0});
                name.parent().parent().find(".error").css({'color':"red"}).html("email格式不正确").show();
            }
        });
    });

    // 验证密码
    $('input[name=pwd]').blur(function () {
        var val = $(this).val();
        if(val.length<8){
            $(this).data({'s':0});
            $(this).parent().parent().find('.error').show();
        }else {
            $(this).data({'s':1});
            $(this).parent().parent().find('.error').hide();
        }
    });
    // 验证确认密码
    $('input[name=repwd]').blur(function () {
        var val1 = $('input[name=pwd]').val();
        var val2 = $(this).val();
        if(val1!==val2){
            $(this).data({'s':0});
            $(this).parent().parent().find('.error').show();
        }else {
            $(this).data({'s':1});
            $(this).parent().parent().find('.error').hide();
        }
    });

// 验证验证码对错
    $('input[name=authcode]').blur(function () {
        var name = $(this);
        var authcode = name.val();
        $.post('index.php?m=register',{'authcode':authcode},function (data) {
            if(data==1){
                name.data({'s':1});
                // $(this).parent().parent().find('.error').show().html(data);
                name.parent().parent().parent().find(".error").css({'color':"green"}).html("验证码正确").show();
            }else {
                name.data({'s':0});
                // $(this).parent().parent().find('.error').show("").html(data);
                name.parent().parent().parent().find(".error").html("验证码错误").show();
            }
        });

    });

    // 验证提交
    // 表单提交时 再进行验证
    // 两次提交都为空 所以验证密码没有报错

    // 如何判断条件都满足
    // 方法：各自在自己身上加一个标签 添加data标签

    $('form').submit(function () {
        $('.auth').blur();
        // 收集 每个data值
        var tot =0;
        $('.auth').each(function () {
            tot+=$(this).data('s');
        });

        if (tot!=4){
            return false;
        }

    })

});