<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nacky
 * Date: 12-5-5
 * Time: 上午1:12
 * To change this template use File | Settings | File Templates.
 */
if ($flashes = Yii::app()->user->getFlashes()) {
    foreach ($flashes as $key => $message) {
        if ($key != 'counters') {
            $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id' => $key,
                'options' => array(
                    'show' => 'blind',
                    'hide' => 'explode',
                    'modal' => 'true',
                    'title' => $message['title'],
                    'autoOpen' => true,
                    'height' => 'auto',
                    'closeOnEscape' => false,
                    'buttons' => array('确定' => 'js:function(){$(this).dialog("close")}'),
                ),
            ));

            //要输出的内容
            printf('<span class="dialog">%s</span>', $message['content']);

            $this->endWidget('zii.widgets.jui.CJuiDialog');
        }
    }
}
?>