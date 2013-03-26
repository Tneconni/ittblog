<?php
$uploadUrl = Yii::app()->request->baseUrl . "/uploadFile";
?>
<div id="photo-desc">
    <span>
        <a id="upload_new_dir" href="#">添加相册</a>
    </span>
    <span>
        <a id="upload_new_pic" href="#">上传新照片</a>
    </span>
</div>
<div id="photo-dir-list">
    <table>
        <tbody>
        <tr>
            <?php
            for ($i = 0; $i < 8; $i++) {
                ?>
                <td align="center">
                    <span name="photo-dir-name">相册<?=$i?></span>
                    <br>
                    <img title="相册" src="<?=$uploadUrl?>/sys/IMG_156.jpg" alt="相册<?=$i?>">
                    <br>
                    <span name="photo-dir-edit">编辑</span>
                    <span>|</span>
                    <span name="photo-dir-delete">删除</span>
                </td>
                <?php
            }?>
        </tr>
        </tbody>
    </table>
</div>
<br>
