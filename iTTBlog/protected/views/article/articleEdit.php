<div id="articleEdit_div" align="left">
    <form id="articleEditForm" action="" method="post" name="article">
        <span class="tmg">记录生活，发表心情，留着某天和他/她一起翻阅，一起回忆~</span>
        <span class="emg"><?=empty($errorLog) ? "当前时间：" . date("Y年m月d日 l H:i:s A") : $errorLog?> </span>

            <span id="article_edit_title">
                博文标题：
                <input id="articleTitle" name="article[title]" value="<?=$article->title?>">
                <input id="articleId" type="hidden" name="articleId" value="<?=empty($article->id)?0:$article->id?>">
            </span>
        <span id="article-editor">
        <?php
            $this->widget('ext.xheditor.XHeditor', array(
                'language' => 'zh-cn', // en, zh-cn, zh-tw, ru
                'config' => array(
                    'id' => 'article-xh1',
                    'name' => "article[content]",
                    'skin' => 'o2007silver', // default, nostyle, o2007blue, o2007silver, vista
                    'tools' => 'mfull', // mini, simple, mfull, full or from XHeditor::$_tools, tool names are case sensitive
                    'width' => '97%',
                    'height' => '600'
                    //see XHeditor::$_configurableAttributes for more
                ),
                'contentValue' => $article->content, // default value displayed in textarea/wysiwyg editor field
                'htmlOptions' => array('rows' => 100, 'cols' => 80), // to be applied to textarea
            ));
            ?>
            </span>
        <span>
            博文标签：
            <input id="tags" name="tags" value="<?=$tags?>">
            <input class="formButton" id="autoGetTags" title="点击自动获取标签" type="button" value="自动获取标签">
            <br>
            文章类别：
            <?=CHtml::dropDownList("article[typeId]", 'name',
            CHtml::listData($articleTypes, 'id', 'name', 'groupType'),
            array('id' => 'articleTypeId'))?>
            <input class="formButton" type="submit" value="发表">
            <input class="formButton" type="button" value="存草稿" id="draft">
            <input class="formButton" type="button" id="articleEditCancel" value="取消">
        </span>
    </form>
</div>
<script type="text/javascript">
    $(function () {
        var url = getRootPath()+"/article/saveDraft";
        setInterval(function () {
            var articleId = $("#articleId").val();
            var articleTitle=$("#articleTitle").val();
            var content = $("#article-xh1").val();
            var typeId=$("#articleTypeId option:selected").val();
            if (content != '' && content != null) {

                $.post(url, {articleId:articleId,title:articleTitle,typeId:typeId, content:content},
                    function (data) {
                        if (data==''||data == 1) {
                            art.dialog({
                                time:1500,
                                content: "草稿自动保存失败！"
                            });
                        } else {
                            $("#articleId").attr('value', data);
                            art.dialog({
                                time:1500,
                                content: "草稿自动保存成功！"
                            });
                        }
                    },'json');
            }
        }, 60000);
    });
    $('#draft').click(function () {
        var url = getRootPath()+"/article/saveDraft";
        var articleId = $("#articleId").val();
        var articleTitle=$("#articleTitle").val();
        var content = $("#article-xh1").val();
        var typeId=$("#articleTypeId option:selected").val();
        if (content == '' || content == null) {
            art.dialog({
                time:1000,
                content: "草稿保存失败！原因是文章内容为空！"
            });
            return false;
        }
        $.post(url, {articleId:articleId,title:articleTitle,typeId:typeId, content:content},
            function (data) {
                if (data==''||data == 1) {
                    art.dialog({
                        time:1500,
                        content: "网络故障,草稿保存失败！"
                    });
                } else {
                    if(confirm('草稿保存成功,是否要继续编辑？')){
                        return false;
                    }
                    window.location.href= getRootPath()+"/article/articleList";
                }
            },'json');

    });
</script>