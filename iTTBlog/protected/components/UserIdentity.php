<?php
class UserIdentity extends CUserIdentity
{
    private $duration;
    private $account;
    private $id;

    public function __construct($username, $password, $duration)
    {
        $this->username = $username;
        $this->password = $password;
        $this->duration = $duration;
    }

    /**
     * 实现父类方法
     * @return bool
     */
    public function authenticate()
    {
        $this->errorCode = self::ERROR_PASSWORD_INVALID;
        $criteria = new CDbCriteria();
        $criteria->addCondition('alias=:str or userAccount=:str or email=:str or identityNo =:str or mobilePhone=:str');
        $criteria->addCondition('password=:pwd');
        $criteria->addCondition('status = 0 or status = 1'); //0:未激活，1：正常
        $criteria->params = array(':str' => CHtml::encode($this->username), ':pwd' => md5(CHtml::encode($this->password)));
        $user = Users::model()->find($criteria);
        if (empty($user)) {
            throw new Exception('登录名称或密码错误！');
        }
        $this->account = $user->alias;
        $this->id = $user->id;
        if (empty($this->duration)) {
            $this->duration = 0;
        }
        $_SESSION['user']=$user;
        $this->setState('user', $user);
        $this->errorCode = self::ERROR_NONE;
    }

    /**
     * 重写父类方法
     * @return mixed
     */
    public function getName()
    {
        return $this->account;
    }

    /**
     * 重写父类方法
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 自定义方法，返回保存多长时间
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }
}

?>