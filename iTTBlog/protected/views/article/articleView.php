<script type="text/javascript">
    $(function () {
        var imgDown = "<?=Yii::app()->baseUrl?>/images/icon/Icon_Arrows_down.ico";
        var imgUp = "<?=Yii::app()->baseUrl?>/images/icon/Icon_Arrows_up.ico";
        $("#arrow-article").click(function () {
            var ia = hideOrShowById("article_view_content");
            if (ia == 0) {
                $(this).attr("title", "展开文章正文");
                $(this).children("h4").html("").html("展开文章正文");
                $(this).children("img").attr("src", imgDown);
            } else {
                $(this).attr("title", "收起文章正文");
                $(this).children("h4").html("").html("收起文章正文");
                $(this).children("img").attr("src", imgUp);
            }

//            var ja = hideOrShowById("comment_list");
//            if (ja == 0) {
//                $("#arrow-comment").attr("title","展开评论");
//                $("#arrow-comment").children("h4").html("").html("展开评论");
//                $("#arrow-comment").children("img").attr("src",imgDown);
//            } else {
//                $("#arrow-comment").attr("title","收起评论");
//                $("#arrow-comment").children("h4").html("").html("收起评论");
//                $("#arrow-comment").children("img").attr("src",imgUp);
//            }

        });

        $("#arrow-comment").click(function () {

            var commentCount = "<?=Comment::getCommentCount($article->id)?>";
            if (commentCount <= 0) {
                alert("该文章还没有评论或已被删除");
                return false;
            }
            var jc = hideOrShowById("comment_list");
            if (jc == 0) {
                $(this).attr("title", "展开评论");
                $(this).children("h4").html("").html("展开评论");
                $(this).children("img").attr("src", imgDown);
            } else {
                $(this).attr("title", "收起评论");
                $(this).children("h4").html("").html("收起评论");
                $(this).children("img").attr("src", imgUp);
            }

//            var ic = hideOrShowById("article_view_content");
//            if (ic == 0) {
//                $("#arrow-article").attr("title","展开文章正文");
//                $("#arrow-article").children("h4").html("").html("展开文章正文");
//                $("#arrow-article").children("img").attr("src",imgDown);
//            } else {
//                $("#arrow-article").attr("title","收起文章正文");
//                $("#arrow-article").children("h4").html("").html("收起文章正文");
//                $("#arrow-article").children("img").attr("src",imgUp);
//            }

        });
        $("#add_comment_form_img").click(function () {
            var icc = hideOrShowById("add_comment_form");
            if (icc == 0) {
                $(this).attr("title", "展开编辑器").attr("src", imgDown);
            } else {
                $(this).attr("title", "收起编辑器").attr("src", imgUp);
            }

        });
    });
</script>
<div id='article_view_outer' align="center">
    <div id="new_article" align="right" class="rmg">写博客
        <a href="<?=Yii::app()->createUrl("article/articleEdit")?>">
            <img src="<?=Yii::app()->request->baseUrl?>/images/icon/write.gif" alt="写博客" style="cursor: pointer">
        </a>
    </div>
    <div id="article_view_inner">
        <div id="article_view_inner_title" title="文章标题" style="color:blue">
            <?=empty($article) ? '文章或被已作者删除！' : ' &nbsp;文章标题：' . Articles::subString($article->title)?>
            <span id="arrow-article" style="color: gray;background: white;font-size:10px;cursor: pointer"
                  title="收起文章正文">
            <img src="<?=Yii::app()->baseUrl?>/images/icon/Icon_Arrows_up.ico" alt="收起文章正文">
           <h4>收起文章正文</h4> </span>
        </div>
        <hr>
        <div id="article_view_content" title="文章内容" style="overflow:auto;padding:10px;">
            <span>
            <?=empty($article->content) ? "没有任何内容!" : $article->content;?>
            </span>
            <hr>
             <span style="font-size:12px;">
                <a href="#">作者：<?php
                    echo $article->author;
                    ?></a>&nbsp;|&nbsp;
                <a href="#">发表时间：<?php
                    echo $article->publishTime;
                    ?></a>&nbsp;|&nbsp;
                 <a href="#">类型：<?php
                     echo $article->typeId;
                     ?></a>&nbsp;|&nbsp;
                 <a href="#">点击次数：<?php
                     echo $article->viewCount;
                     ?></a>
            </span>
        </div>
        <div style="color: gray;" align="center">
            已有评论条数：<?php $count = Comment::getCommentCount($article->id);echo $count?>
            <span id="arrow-comment" style="color: gray;background: white;font-size:10px;cursor: pointer" title="收起评论">
            <img src="<?=Yii::app()->baseUrl?>/images/icon/Icon_Arrows_down.ico" alt="评论">
            <h4>展开评论</h4>
            </span>
        </div>
        <div id="comment_list" style="display: none" title="评论列表">
            <?php
            if (empty($count)) {
                echo "该文章还没有评论或已被作者删除作者……";
            } else {
                $this->renderPartial('/comment/commentList', array('comments' => $comments));
            }
            ?>
        </div>
    </div>
    <div id="add_comment" align="left">
        <span id="new_comment" class="rmg">
            发表评论
          <img id="add_comment_form_img"
               src="<?=Yii::app()->request->baseUrl?>/images/icon/Icon_Arrows_up.ico" alt="评论" title="收起编辑器">
        </span>
        <br>
        <div align="left">
            <form id="add_comment_form" name="comment"
                  action="<?=Yii::app()->createUrl('article/saveComment')?>" method="post">
        <span style="display: none">
            <input type="hidden" name="comment[articleId]" value="<?=$article->id?>">
        </span>
            <span id="commenterCls">昵称：
                <input id="commenter" name="comment[commenter]" value="<?=Yii::app()->user->name?>">
            </span>
                <span id="comment_edit_area" style="width: 790px;">
                   <?php
                    $this->widget('ext.xheditor.XHeditor', array(
                        'language' => 'zh-cn', // en, zh-cn, zh-tw, ru
                        'config' => array(
                            'id' => 'xh1',
                            'name' => "comment[content]",
                            'skin' => 'o2007silver', // default, nostyle, o2007blue, o2007silver, vista
                            'tools' => 'simple', // mini, simple, mfull, full or from XHeditor::$_tools, tool names are case sensitive
                            'width' => '100%',
                            //see XHeditor::$_configurableAttributes for more
                        ),
                        'contentValue' => $commentContent, // default value displayed in textarea/wysiwyg editor field
                        'htmlOptions' => array('rows' => 5, 'cols' => 80), // to be applied to textarea
                    ));
                    ?>
                </span>
                <br>
             <span id="reg_verification">验&nbsp;证&nbsp;码：
            <input type="text" name="verifyCode" value="">
                 <?php $this->widget('CCaptcha',
                     array('showRefreshButton' => false,
                         'clickableImage' => true,
                         'imageOptions' => array('alt' => '点击换图', 'title' => '看不清，点击换图',
                             'style' => 'cursor:pointer'))); ?>
                 </span>
                <input class="formButton" type="submit" value="发表评论">
                <br>
                <br>
            </form>
        </div>
    </div>
</div>
