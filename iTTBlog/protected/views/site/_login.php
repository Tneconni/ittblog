<div id="loginForm_div" title="登录iTTBLOG">
    <form action="<?=Yii::app()->createUrl('site/login')?>" method="post" id="loginForm">

        <span class="tmg">登录iTTBLOG，绘心情曲线~</span>

        <span class="emg"><?=empty($errorLog) ? "当前时间：" . date("Y年m月d日 l H:i:s A") : $errorLog?> </span>

        <span>
            登录名称：
             <input id="userName" name="loginForm[account]" value="<?=$form['account']?>"
                    type="text"/>
        </span>
        <span>
            登录密码：
        <input id="passWord" type="password" name="loginForm[password]"/>
        </span>
        <span id="cookies">
            cookies：
            <?=CHtml::activeDropDownList($form, "rememberTime", LoginForm::getRememberTimeArr(),
            array('name' => "loginForm[rememberTime]", 'empty' => ' 不 保 存 '))?>
        </span>
        <br/>
        <span id="loginButton">
         <input class="formButton" type="submit" style="width:100px;" class="bt" value="登录"/>
          <input class="formButton" type="button" id="loginCancel" style="width:100px;" onclick='hideById("loginForm_div")' value="取消" />
        </span>
    </form>
</div>
