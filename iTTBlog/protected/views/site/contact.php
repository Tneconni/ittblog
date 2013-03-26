<div id="contact" align="center">
    <div id="contact_desc" align="left">
        <span class="tmg">联系我们</span>
        <p>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;网站才开张，我都还不好意思写网站简介，
            稍等一段时间吧，我会先多放一些内容上来， 如果您能经常来我的网站看看呢，
            那就是对我最大的支持了... 如果您有任何问题请您务必告知……<br>
            ~~谢谢~~
        </p>
        <hr>
        <br>
        <p style="color:blue;">
            iTTBlog声明：您的来信我们非常高兴，我们绝对尊重您的隐私，不会将您的姓名和电子邮件公开或用作他途……
        </p>
    </div>
    <br>
    <div id="contactForm_div" align="left">
        <form id="contactForm" action="<?=Yii::app()->createUrl("site/contact")?>" method="post">
        <span>您的姓名：
        <input type="text" name="contactForm[name]" value="">
        </span>

        <span id="c_email">电子邮件：
        <input type="text" name="contactForm[email]" value="">
        </span>

        <span id="c_subject">邮件主题：
        <input type="text" name="contactForm[email]" value="">
        </span>

        <span id="email_content-editor">
        <?php
            $this->widget('ext.xheditor.XHeditor', array(
                'language' => 'zh-cn', // en, zh-cn, zh-tw, ru
                'config' => array(
                    'id' => 'email_content-xh1',
                    'name' => "contactForm[subject]",
                    'skin' => 'o2007silver', // default, nostyle, o2007blue, o2007silver, vista
                    'tools' => 'simple', // mini, , mfull, full or from XHeditor::$_tools, tool names are case sensitive
                    'width' => '97%',
                    'height' => '400'
                    //see XHeditor::$_configurableAttributes for more
                ),
                'contentValue' => '', // default value displayed in textarea/wysiwyg editor field
                'htmlOptions' => array('rows' => 100, 'cols' => 80), // to be applied to textarea
            ));
            ?>
            </span>
        <span> 验证码：
        <input type="text" name="contactForm[verifyCode]" value="">
            <?php $this->widget('CCaptcha', array('showRefreshButton' => false,
                'clickableImage' => true,
                'imageOptions' => array('alt' => '点击换图', 'title' => '看不清，点击换图',
                    'style' => 'cursor:pointer'))); ?>
            <input class="formButton" type="button" value="发送电子邮件">
        </span>
        </form>
    </div>
</div>