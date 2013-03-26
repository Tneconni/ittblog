<?php
class WebUser extends CWebUser
{

    /**
     * 登录成功后调用该方法
     * @param $fromCookie
     */
    protected function afterLogin($fromCookie)
    {
        return $fromCookie;
    }

    /**
     * 退出（注销）成功后调用该方法
     */
    protected function afterLogout()
    {
    }

    /**
     * 登录之前调用该方法
     * @param $id  用户ID. 这个和 getId()方法返回的是一样的.
     * @param $states UserIdentity 提供的name-value形式的数组.
     * @param bool $fromCookie 是否为基于cookie的登陆
     * @return bool 用户是否可以登陆
     */
    protected function beforeLogin($id, $states, $fromCookie)
    {
        return true;
    }

    /**
     * 退出（注销）前调用该方法
     * @return bool 是否注销用户
     */
    protected function beforeLogout()
    {
        return true;
    }

    /**
     * 当用户调用logout注销时，将唤醒该方法. 如果该方法返回false, 注销动作将被取消.
     * @param $id
     * @param $name
     * @param $states
     */
    protected function changeIdentity($id, $name, $states)
    {
        Yii::app()->getSession()->regenerateID();
        $this->setId($id);
        $this->setName($name);
        $this->loadIdentityStates($states);
    }

    /**
     *用户的身份信息将被持久的保存，在用户会话期间。默认情况下，存储是简单的会话存储。
     * 如果duration参数大于0，将生成一个cookie，为以后基于cookie登陆做准备.
     * 注意, 你必须设置 allowAutoLogin 为true 如果你想用户可以基于cookie登录的话.
     * @param $identity
     * @param int $duration
     * @throws CException
     */
    public function login($identity,$duration=0)
    {
        $id = $identity->getId();
        $states = $identity->getPersistentStates();
        if ($this->beforeLogin($id, $states, false)) {
            $this->changeIdentity($id, $identity->getName(), $states);
            if ($duration > 0) {
                if ($this->allowAutoLogin) {
                    $this->saveToCookie($duration);
                } else {
                    throw new CException(Yii::t('yii', '{class}.allowAutoLogin must be set true in order to use cookie-based authentication.',
                        array('{class}' => get_class($this))));
                }
            }
            return true;
        }
    }

    public function __get($name)
    {
        if ($this->hasState('__userInfo')) {
            $user = $this->getState('__userInfo', array());
            if (isset($user[$name])) {
                return $user[$name];
            }
        }
        return parent::__get($name);
    }
}
