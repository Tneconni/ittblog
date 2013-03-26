<div align="left">
<span id="ph">
     <img style="width: 180px;height:200px;"
          src="<?=Yii::app()->request->baseUrl?>/uploadFile/sys/IMG_177.jpg"
          alt="<?=Yii::app()->user->name?>"
          title="<?=Yii::app()->user->name?>">
</span>
    <br>
<span id="login-reg">
     &nbsp; &nbsp;
     <input id="<?=Yii::app()->user->name == 'Guest' ? 'loginButton' : 'login_exitButton' ?>" class="btn" type="button"
            value="<?=Yii::app()->user->name == 'Guest' ? '登录' : '退出' ?>">
    &nbsp; &nbsp;
     <input id="regButton" class="btn" type="button" value="注册">
</span>
    <br>
 <span id="search">
        <input id="input-text" type="text" name="keyword" value="搜关键字……">
        <input id="input-btn" class="btn" type="button" name="keyword" value="搜索">
 </span>
    <br>
<span id="rss">
      <h5 style="font-size: 30;background-color: #f8f8ff;">Rss订阅<hr style="margin: 1px"></h5>
     <?php include_once("RSS.php")?>
</span>
<span id="hot">
    <h5 style="font-size: 30;background-color: #f8f8ff;">热门博文<hr style="margin: 1px"></h5>
    <?php
    $hots = ArticleManager::GetHotArticleList();
    if (!empty($hots)) {
        foreach ($hots as $h) {
             ?>
            <a href="<?php echo Yii::app()->createUrl('article/viewArticle',array('articleId'=>$h->id))?>">
                <?php echo $h->title?></a><br>
            <?php
        }
    }
    ?>
</span>
</div>