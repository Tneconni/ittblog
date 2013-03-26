<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nacky
 * Date: 12-4-23
 * Time: 下午11:35
 * To change this template use File | Settings | File Templates.
 */
?>
<div>
    <form id="add_comment_form" action="" method="post">
        <span style="display: none">
            <input name="comment[articleId]" value="<?=$articleId?>">
        </span>
            <span id="commenterCls">昵称：
                <input id="commenter" name="comment[commenter]" value="<?=Yii::app()->user->name?>">
            </span>
        <textarea id="add_comment_area" name="comment[content]" rows="10" cols="99">
        </textarea>
        <br>
        <input class="formButton" type="submit" name="提交评论">
    </form>
</div>
