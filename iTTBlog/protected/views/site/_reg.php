<div id="regForm_div" title="注册iTTBLOG">
    <form id="regForm" action="<?=Yii::app()->createUrl('site/reg')?>" method="post">
        <span class="tmg">注册iTTBLOG，每天收获一点点~</span>
        <span class="emg"><?=empty($errorLog) ? "当前时间：" . date("Y年m月d日 l H:i:s A") : $errorLog?> </span>

        <span> 邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;箱：
         <input type="text" name="reg[email]" value="<?=$reg->email?>">
        </span>

        <span>帐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;号：
        <input type="text" name="reg[alias]" value="<?=$reg->alias?>">
        </span>

        <span>密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码：
        <input type="password" name="reg[password]" value="">
        </span>

        <span>确认密码：
        <input type="password" name="reg[confirm]" value="">
        </span>
        <span id="reg_verification">验&nbsp;&nbsp;证&nbsp;&nbsp;码：
            <input type="text" name="reg[verifyCode]" value="">
            <?php $this->widget('CCaptcha',
                array('showRefreshButton' => false,
                    'clickableImage' => true,
                    'imageOptions' => array('alt' => '点击换图', 'title' => '看不清，点击换图',
                        'style' => 'cursor:pointer'))); ?>
        </span>
        <span style="display: none">
        </span>
         <span>
            <input class="formButton" type="submit" value="注册">
            <input  class="formButton" id="regExit" type="button" value="退出">
          </span>
    </form>
</div>
