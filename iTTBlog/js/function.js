/**
 * 根据窗口Id 隐藏窗口
 * @param id
 */
function hideById(id) {
    $("#" + id).hide('slow');
}

/**
 * 根据窗口Id 显示窗口
 * @param id
 */
function showById(id) {
    // $("#" + id).hide('slow');
    $("#" + id).css("display", 'block').show("slow");
}
/**
 *
 * @param id
 */
function hideOrShowById(id) {
    var i = $("#" + id).css('display');
    if (i != 'none') {
        hideById(id);
        return 0;
    } else {
        showById(id);
        return 1;
    }
}

/**
 * 获取当前时间
 */
function CurrentTime() {
    var now = new Date();
    var hours = now.getHours();
    var minutes = now.getMinutes();
    var seconds = now.getSeconds();

    var timeValue = '';
    if (hours >= 6 && hours <= 12) {
        timeValue += (" 上午");
    }
    if (hours > 12 && hours <= 18) {
        timeValue += (" 下午");
    }
    if (hours > 18 && hours <= 24) {
        timeValue += (" 晚上");
    }
    if (hours < 6) {
        timeValue += (" 深夜");
    }
    return timeValue + hours + ((minutes < 10) ? ":0" : ":")
        + minutes + ((seconds < 10) ? ":0" : ":") + seconds;
}


/**
 * 获取root路径
 */
function getRootPath() {
    var strFullPath = window.document.location.href;
    var strPath = window.document.location.pathname;
    var pos = strFullPath.indexOf(strPath);
    var prePath = strFullPath.substring(0, pos);
    var postPath = strPath.substring(0, strPath.substr(1).indexOf('/') + 1);
    return(prePath + postPath);
}

