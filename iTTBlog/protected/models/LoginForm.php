<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
    public $account;
    public $password;
    public $rememberTime;

    private $_identity;


    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     * @return array
     */
    public function rules()
    {
        return array(
            // username and password are required
            array('account, password', 'required'),
            // password needs to be authenticated
            array('password', 'authenticate'),
            //设置session过期时间
            array('rememberTime', 'numerical'),
        );
    }


    /**
     * Declares attribute labels.
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'account' => '登录帐号',
            'password' => '登录密码',
            'rememberTime' => '记住我，下次自动登录！',
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate()
    {
        if (!$this->hasErrors()) {
            $identity = new UserIdentity($this->account, $this->password, $this->rememberTime);
            $identity->authenticate();
            switch ($identity->errorCode)
            {
                case UserIdentity::ERROR_NONE:
                    $duration = $this->getRememberTime($this->rememberTime);
                    Yii::app()->user->login($identity, $duration);
                    break;
                case UserIdentity::ERROR_USERNAME_INVALID:
                    $this->addError('account', '登录名称或密码错误！');
                    break;
                default: // UserIdentity::ERROR_PASSWORD_INVALID
                    $this->addError('password', '登录名称或密码错误！');
                    break;
            }
        }
    }


    /**
     * 根据用户登录提交的信息获取保存cookie的时间
     * @param $timeStr
     * @return int
     */
    private function getRememberTime($timeStr = 1)
    {
        $time = 3600*2;
        if ($timeStr == 1) {
            $time = 3600 * 24 * 7;
        } elseif ($timeStr == 2) {
            $time = 3600 * 24 * 30;
        } elseif ($timeStr == 3) {
            $time = 3600 * 24 * 30 * 6;
        } elseif ($timeStr == 4) {
            $time = 3600 * 24 * 365;
        }
        return $time;
    }

    /**
     * 用户能够保存cookie的时间
     * @return array
     */
    public static function getRememberTimeArr()
    {
        return array(
            '1' => '保 存 七 天',
            '2' => '保 存 30 天',
            '3' => '保 存 半 年',
            '4' => '保 存 一 年',
        );
    }

    /**
     * 获取相应时间段的提示
     * @static
     * @return string
     */
    public static function getTimePointOut()
    {
        $t = date('H');
        if($t>2&&$t<6){
            return "凌晨好！现在还不睡觉，非养生之道哦！";
        }elseif ($t >=6 && $t <= 10) {
            return "早上好！新的一天开始啦，你准备好了吗？";
        } elseif ($t > 10 && $t <= 14) {
            return "中午好！中午小歇片刻，精神百倍哦！";
        } elseif ($t > 14 && $t <= 18) {
            return "下午好！忙碌的一天要结束了，加油~";
        } elseif ($t > 18 && $t <= 22) {
            return "晚上好！现在享受你的私人时空吧！";
        }elseif($t>22&&$t<=23){
            return "晚上好！夜深了，早起早睡方能养生哦~";
        }
        return "午夜好！夜深了，早点休息哦!";
    }
}
