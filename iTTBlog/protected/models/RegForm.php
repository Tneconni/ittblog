<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nacky
 * Date: 12-5-3
 * Time: 上午12:38
 * To change this template use File | Settings | File Templates.
 */
class RegForm   extends CFormModel
{

    public $email;
    public $alias;
    public $password;
    public $confirm;
    public $verifyCode;

    /**
     * 解析规则
     * @return array
     */
    public function rules()
    {
        return array(

            //必填项
            array('email, alias, password ,confirm,verifyCode', 'required'),
            // email has to be a valid email address
            array('email', 'email'),
            // verifyCode needs to be entered correctly
            array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'verifyCode'=>'验证码',
        );
    }
}
