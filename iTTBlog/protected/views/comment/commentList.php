<?php
if (!empty($comments)) {
    foreach ($comments as $c) {
        ?>
    <table id="comment_item">
        <thead>
        <tr style="font-size: 12px;">
            <td>
                <span style="color:blue;">
                            <?php echo $c->commenter?>
                        </span>
               于：
                        <span>
                         <?php echo $c->publishTime?>
                        </span>
                发表了对该文章的评论！
            </td>
            <td align="right">
                <img src="<?=Yii::app()->request->baseUrl?>/images/icon/del.ico" alt="删除该条评论" title="删除该条评论">
            </td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <hr>
            </td>
        </tr>

        <tr>
            <td>
                评论内容：<span>
                         <?php echo $c->content?>
                        </span>
            </td>
        </tr>
<!--        <tr>-->
<!--            <td>-->
<!---->
<!--            </td>-->
<!--            <td>-->
<!--                <a href="#">回复</a>-->
<!--            </td>-->
<!--        </tr>-->
        </tbody>
        <tfoot style="display:none;">
        <tr style="display: none">
            <input type="hidden" name="commentId" value="<?=$c->id?>">
        </tr>

        </tfoot>
    </table>
    <?php
    }
}
?>
<script type="text/javascript">
    $("img[title='删除该条评论']").click(function () {
        alert("删除该条评论");
    });
</script>