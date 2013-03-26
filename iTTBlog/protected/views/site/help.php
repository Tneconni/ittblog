<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nacky
 * Date: 12-5-7
 * Time: 下午6:04
 * To change this template use File | Settings | File Templates.
 */
echo $help;
echo "<br>";
$this->widget('ext.EasySlider.EasySlider', array(
    'width' => '950px',
    'height' => '300px',
    'data' => array(
        array(
            'title' => 'Click Url will return index!',
            'url' => Yii::app()->createUrl('site/index'),
            'image' =>  Yii::app()->request->baseUrl.'/images/bg/long.gif'
        ),
    )));

echo "<br>";
$this->widget('ext.flowing-calendar.FlowingCalendarWidget', array("month"=>01, "year"=>1999));
echo "<br>";

echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
