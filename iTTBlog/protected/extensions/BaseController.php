<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nacky
 * Date: 12-5-5
 * Time: 上午3:53
 * To change this template use File | Settings | File Templates.
 */

/**
 * 如果让所有controller继承BaseController 要修改 添加如下代码
  *           // asset path setting
              "assetManager" => array(
              "basePath" => "./scripts/core",
),
 */
class BaseController  extends CController
{

    public function init() {
        Yii::app()->clientScript->coreScriptUrl = Yii::app()->baseUrl . "/scripts/core";
        parent::init();
    }

}
