<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <?
//设置网页编码为UTF-8 优先级最高的设置方式
    header("Content-type: text/html; charset=utf-8");
    ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="en"/>
    <link rel="stylesheet" type="text/css" href="<?=Yii::app()->request->baseUrl ?>/css/main.css"/>
    <link rel="stylesheet" type="text/css" href="<?=Yii::app()->request->baseUrl ?>/css/form.css"/>
    <link rel="stylesheet" type="text/css" href="<?=Yii::app()->request->baseUrl ?>/css/style.css"/>
    <link rel="stylesheet" type="text/css" href="<?=Yii::app()->request->baseUrl ?>/css/article.css"/>
    <link rel="stylesheet" type="text/css" href="<?=Yii::app()->request->baseUrl ?>/css/index.css"/>
    <link rel="stylesheet" type="text/css" href="<?=Yii::app()->request->baseUrl ?>/css/photo.css"/>
    <link rel="stylesheet" type="text/css" href="<?=Yii::app()->request->baseUrl ?>/css/jqueryslidemenu.css"/>
    <link rel="stylesheet" type="text/css" href="<?=Yii::app()->request->baseUrl ?>/js/artDialog5.0/skins/simple.css"/>

    <script type="text/javascript" src="<?=Yii::app()->request->baseUrl ?>/js/jquery.js"></script>
    <script type="text/javascript" src="<?=Yii::app()->request->baseUrl ?>/js/jqueryslidemenu.js"></script>
    <script type="text/javascript" src="<?=Yii::app()->request->baseUrl ?>/js/artDialog5.0/artDialog.min.js"></script>
    <script type="text/javascript" src="<?=Yii::app()->request->baseUrl ?>/js/artDialog5.0/artDialog.plugins.min.js"></script>
    <!--   自定义的  -->
    <script type="text/javascript" src="<?=Yii::app()->request->baseUrl ?>/js/window.js"></script>
    <script type="text/javascript" src="<?=Yii::app()->request->baseUrl ?>/js/function.js"></script>
    <script type="text/javascript" src="<?=Yii::app()->request->baseUrl ?>/js/jsMe.js"></script>
    <!--    title-->
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<!--  导航栏  -->
<div id="leader" align="center">
    <div id="myslidemenu" class="jqueryslidemenu">
        <?php
        $menu = MenuManager::GetMenu();
        if (!empty($menu)) {
            $this->widget('zii.widgets.CMenu', array('items' => $menu));
        }
        ?>
    </div>
</div>
<?php
include_once("banner.php");
?>
<div align="center">
    <!--    content   -->
    <div id="content">
        <div id="left">
            <?php
            $this->beginWidget('zii.widgets.jui.CJuiDraggable', array(
                // additional javascript options for the draggable plugin
                'options'=>array(
                    'scope'=>'myScope',
                ),
            ));
            include_once("left.php");
            $this->endWidget();
            ?>
        </div>

        <?php
        include_once("banner.php");
        ?>
        <div>
            <?php   echo $content; ?>
        </div>
    </div>
    <!-- footer  -->
    <div id="footer">
    <span>
        <?=CHtml::link('关于我们', Yii::app()->createUrl('/site/about'), array('style' => 'text-decoration:none'))?>
        &nbsp;|
        <?=CHtml::link('联系我们', Yii::app()->createUrl('/site/contact'), array('style' => 'text-decoration:none'))?>
        &nbsp;|
            <a style="text-decoration:none" href="http://www.cnblogs.com/nackman">更多>></a>
    </span>
        <br>
        <span>Copyright &copy; <?=date('Y'); ?> &nbsp;空山幽泉&nbsp; All Rights Reserved.</span>
    </div>
</div>
<!--  dialog -->
<span style="display:none;">
    <?php
    $this->renderPartial("/site/dialog");
    ?>
    <input id="baseUrl" type="hidden" value="<?= Yii::app()->request->baseUrl?>">
</span>
</body>
</html>
