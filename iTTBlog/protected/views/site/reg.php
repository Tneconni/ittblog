<?php
$this->beginWidget('zii.widgets.jui.CJuiDraggable', array(
    // additional javascript options for the draggable plugin
    'options'=>array(
        'scope'=>'myScope',
    ),
));
include_once("_reg.php");

$this->endWidget();
?>