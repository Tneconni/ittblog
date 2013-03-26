<?php
$this->beginWidget('zii.widgets.jui.CJuiDraggable', array(
    // additional javascript options for the draggable plugin
    'options'=>array(
        'scope'=>'myScope',
    ),
));
echo 'Your draggable content here';
$this->endWidget();
?>