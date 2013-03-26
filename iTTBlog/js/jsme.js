$(function () {
    var rootUrl = getRootPath();
//    当文本框触发事件时改变起border样式
    $("input").ready(
        function () {
            if ($(this).val() != '') {
                $(this).css('border', '1px solid blue');
            }
        }).focus(
        function () {
            $(this).css('border', '1px solid red');
        }).blur(function () {
            if ($(this).val() != '') {
                $(this).css('border', ' 1px solid blue');
            } else {
                $(this).css('border', ' 1px solid gray');
            }
        });

    //左侧边栏 登录按钮点击事件
    $("#loginButton").click(function () {
        if ($(this).val() == '登录') {
            var url = rootUrl + "/site/login";
            $.post(url, {pop:1}, function (data) {
                if (data != '' && data != 1) {
                    var login = art.dialog({
                        id:'loginForm_div',
                        lock:true,
                        focus:true,
                        content:data,
                        zIndex:1000,
                        drag:true
                    });
                    $("#loginCancel").click(function () {
                        login.close();
                        return false;
                    });
                    ;
                } else {
                    alert("网络故障，请稍候重试！");
                }
            }, 'json');
        }
    });

    //左侧边栏 注册按钮点击事件
    $("#regButton").click(function () {
        var url = rootUrl + "/site/reg";
        $.post(url, {pop:1}, function (data) {
            if (data != '' && data != 1) {
                var reg = art.dialog({
                    id:"regForm_div",
                    lock:true,
                    focus:true,
                    content:data,
                    zIndex:1000,
                    drag:true
                });
                $("#regExit").click(function () {
                    reg.close();
                    return false;
                });
                ;
            } else {
                alert("网络故障，请稍候重试！");
            }
        }, 'json');
    });

   //左侧边栏 搜索框获取焦点事件
    $("#input-text").focus(
        function () {
            $(this).attr('value', '');
        }).blur(function () {
            if ($(this).val() == "") {
                $(this).attr('value', '搜关键字……');
            } else {
                if ($(this).val() == '搜关键字……') {
                    alert("请正确输入您的搜索关键字");
                }
            }
        });

    //左侧边栏 搜索按钮点击点事件
    $("#input-btn").click(function () {
        var k = $("#input-text").val();
        if (k == '搜关键字……') {
            alert("请正确输入您的搜索关键字");
            return false;
        }
        $.post(rootUrl + "/article/searchArticle", {keyword:k},
            function (data) {
                if (data['errorCode'] == 0) {//没找到或有错误
                    art.dialog({
                        content:data['errorCode']
                    });
                } else if (data['errorCode'] == 1) {//找到数据
                    art.dialog({
                        content:data['errorCode']
                    });
                }
            }, 'json');
    });
    //登录框取消按钮点击事件1
    $("#loginCancel").click(function () {
        hideById("loginForm_div");
        window.location.href = getRootPath() + "/site/index";
    });

    //注册框退出按钮点击事件
    $("#regExit").click(function () {
        hideById("regForm_div");
        window.location.href = getRootPath() + "/site/index";

    });

    //左侧边栏 退出按钮点击事件
    $("#login_exitButton").click(function () {
        window.location.href = getRootPath() + "/site/logout";
    });

    //文章编辑取消按钮时间
    $("#articleEditCancel").click(function () {
        hideById("articleEdit_div");
        window.location.href = getRootPath() + "/site/index";

    });

    //上传图片按钮事件
    $("#upload_new_pic").click(function () {
        window.location.href = getRootPath() + "/attachment/uploadView";
    });

    //新建相册事件
    $("#photo-box-dropList select").change(function () {
       if($("#photo-box-dropList select option:selected").val()==='new-photo-box') {
           alert("new photo bix");
           window.location.href = getRootPath() + "/attachment/upload";
       }

    });
    //查看相册里面的图片
    $('img[title="相册"]').click(function () {
        window.location.href = getRootPath() + "/photo/photoView";
    });
});
