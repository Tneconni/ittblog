<div id="photo-file-list" align="center">
    <?php
    if (!empty($photos)) {
//        foreach ($photos as $p) {
        $p = $photos;
        ?>
        <table>
            <tbody align="center">
            <tr>
                <td>
                    <img id="photo-left" src="<?=$p->filePath?>" alt="<?=$p->displayName?>">
                </td>
                <td>
                    <div id="photo_view">
                        <img id="photo-center" title="双击查看大图" src="<?=$p->filePath?>" alt="<?=$p->displayName?>">
                        <span><a href="#">编辑</a>||<a href="#">删除</a> </span>
                    </div>
                </td>
                <td>
                    <img id="photo-right" src="<?=$p->filePath?>" alt="<?=$p->displayName?>">
                </td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td align="center">
                    <input id="pre_pic" class="btn" style="width: 60px;" type="button" value="上一张">
                </td>
                <td align="center">
                    <input id="view_pic" class="btn" style="width: 150px;"  type="button" value="查看大图">
                </td>
                <td align="center">
                    <input id="next_pic" class="btn" style="width: 60px;" type="button" value="下一张">
                </td>
            </tr>
            </tfoot>
        </table>
        <?php
//        }
    } else {
        ?>
        <div style="color: #f5deb3;width: 800px;height: 500px;font-size: 72px;">
            亲，没有照片哦。。。
            <br>
             <span>
             <input id="upload_new_pic" class="btn" style="width: 140px;" type="button" value="上传新照片">
            </span>
        </div>
        <?php
    }
    ?>
</div>
<div id="big_preview" align="center"
     style="display:none;position: absolute;top:20%;left:30%;z-index: 999999;opacity: 1">
    <div id="big_close" onmouseover="changeStyle(this)" onmouseout="changeStyle2(this)"
         style="float: right;background-color: #f5deb3;position: relative;top: 26px; margin-left: 0px; margin-right: 4px;opacity: 0.4">
        <a href="#" >X关闭</a></div>
    <br>

    <div>
        <img width="100%" height="100%" id="photo-big" src="<?=$p->filePath?>" title="双击隐藏大图" alt="<?=$p->displayName?>">
    </div>
</div>
<script type="text/javascript">
    $("#view_pic").click(function () {
        showById("big_preview")
    });
   $("#photo-center").dblclick(function(){
       showById("big_preview")
   });
    $("#big_close a").click(function () {
        hideById("big_preview")
    });
    $("#photo-big").dblclick(function () {
        hideById("big_preview")
    });
    $("#pre_pic").click(function () {
        var pc = $("#photo-center");
        var big = $("#photo-big");
        $.post(getRootPath() + "/photo/getNextFilePath", {nq:pc.attr('src')}, function (data) {
            if (data != 1 && data != '') {
                pc.attr('src', data);
                big.attr('src', data);
            } else {
                alert("已经是最后一张")
            }
            return false;
        }, 'json');
    });

    $("#next_pic").click(function () {
        var pc = $("#photo-center");
        var big = $("#photo-big");
        $.post(getRootPath() + "/photo/getNextFilePath", {nq:pc.attr('src')}, function (data) {
            if (data != 1 && data != '') {
                pc.attr('src', data);
                big.attr('src', data);

            } else {
                alert("已经是最后一张")
            }
            return false;
        }, 'json');
    });

    function changeStyle(obj){
        $(obj).css('opacity',1);
    }

    function changeStyle2(obj){
        $(obj).css('opacity',0.4);
    }
</script>