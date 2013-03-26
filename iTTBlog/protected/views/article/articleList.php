<div id="article_list" align="left">
    <div align="center">
        <span id="all_article_count">
            所有文章数：<?=count($articles)?>
        </span>

        <div id="new_article" align="right" class="rmg">写博客
            <a href="<?=Yii::app()->createUrl("article/articleEdit")?>">
                <img src="<?=Yii::app()->request->baseUrl?>/images/icon/write.gif" alt="写博客">
            </a>
        </div>
    </div>
    <?php
    if (!empty($articles)) {
        foreach ($articles as $a) {
            if (!empty($a)) {
                ?>
                <table>
                    <thead>
                    <tr>
                        <td>
                           <span>
                               标题：
                            <a href="<?php echo Yii::app()->createUrl("article/viewArticle",
                                array('articleId' => $a->id))?>">
                                <?php
                                echo  $a->title;
                                ?></a>
                               <hr>
                           </span>
                        </td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <span>
                                 内容：
                                <?php
                                echo CHtml::decode(Articles::subString($a->content, 200));
                                ?>
                            </span>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td>
                            <hr>
                    <span>
                        <a href="#">作者：<?php
                            echo $a->author;
                            ?></a>&nbsp;|&nbsp;
                        <a href="#">发表时间：<?php
                            echo $a->publishTime;
                            ?></a>&nbsp;|&nbsp;
                         <a href="#">类型：<?php
                             echo $a->typeId;
                             ?></a>&nbsp;|&nbsp;
                        <a href="#">评论数：<?php
                            echo Comment::getCommentCount($a->id);
                            ?></a>&nbsp;|&nbsp;
                         <a href="#">点击次数：<?php
                             echo $a->viewCount;
                             ?></a>
                        </span>
                        </td>
                    </tr>
                    </tfoot>
                </table>
                <?php
            }
        }
    }
    ?>
</div>