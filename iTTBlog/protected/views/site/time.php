<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nacky
 * Date: 12-5-5
 * Time: 下午5:53
 * To change this template use File | Settings | File Templates.
 */
?>
<script type="text/javascript">
    $(function () {
        $("#time").html(CurrentTime());
        setInterval(function () {
            var currentTime = CurrentTime();
            $("#time").html("");
            $("#time").html(currentTime);
        }, 1000);
    });
    $("#currentTime").mouseover(function(){

    });
</script>
<div id="currentTime">
    <span id="ymd"><?=date('Y年m月d日 l')?></span>
    <br>
    <span id="time"></span>
    <?php
        $this->widget('ext.my97DatePicker.JMy97DatePicker', array(
            'name' => 'time',
            'value' =>'',
            'options' => array('dateFmt' => 'yyyy-MM-dd H:m:s'),
            'htmlOptions' => array(
                'id' => 'calender',
                 'width'=>'180px',
            )
        ));
        ?>
</div>
