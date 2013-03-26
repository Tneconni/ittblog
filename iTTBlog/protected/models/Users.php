<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $name
 * @property string $nameFirstPY
 * @property string $alias
 * @property string $aliasFirstPY
 * @property string $userAccount
 * @property string $password
 * @property string $role
 * @property string $sex
 * @property string $birthday
 * @property integer $userGrade
 * @property string $mobilePhone
 * @property string $email
 * @property string $address
 * @property string $zipCode
 * @property string $identityNo
 * @property string $registerTime
 * @property string $lastLoginTime
 * @property string $lastIP
 * @property integer $status
 * @property integer $visitCount
 */
class Users extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('alias, password, email, registerTime', 'required'),
			array('userGrade, status, visitCount', 'numerical', 'integerOnly'=>true),
			array('name, nameFirstPY, alias, aliasFirstPY, userAccount, mobilePhone, lastIP', 'length', 'max'=>20),
			array('password', 'length', 'max'=>50),
			array('role, zipCode', 'length', 'max'=>8),
			array('sex', 'length', 'max'=>4),
			array('email', 'length', 'max'=>100),
			array('address', 'length', 'max'=>255),
			array('identityNo', 'length', 'max'=>36),
			array('birthday, lastLoginTime', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, nameFirstPY, alias, aliasFirstPY, userAccount, password, role, sex, birthday, userGrade, mobilePhone, email, address, zipCode, identityNo, registerTime, lastLoginTime, lastIP, status, visitCount', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '序号',
			'name' => '姓名',
			'nameFirstPY' => '姓名拼音缩写',
			'alias' => '别名',
			'aliasFirstPY' => '别名拼音缩写',
			'userAccount' => '帐号',
			'password' => 'Password',
			'role' => '角色',
			'sex' => '性别',
			'birthday' => '生日',
			'userGrade' => '用户级别',
			'mobilePhone' => '手机',
			'email' => 'Email',
			'address' => '地址',
			'zipCode' => '邮编',
			'identityNo' => '身份证号',
			'registerTime' => '注册时间',
			'lastLoginTime' => '最后登录时间',
			'lastIP' => '最后登录IP',
			'status' => '状态',
			'visitCount' => '登录次数',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('nameFirstPY',$this->nameFirstPY,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('aliasFirstPY',$this->aliasFirstPY,true);
		$criteria->compare('userAccount',$this->userAccount,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('role',$this->role,true);
		$criteria->compare('sex',$this->sex,true);
		$criteria->compare('birthday',$this->birthday,true);
		$criteria->compare('userGrade',$this->userGrade);
		$criteria->compare('mobilePhone',$this->mobilePhone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('zipCode',$this->zipCode,true);
		$criteria->compare('identityNo',$this->identityNo,true);
		$criteria->compare('registerTime',$this->registerTime,true);
		$criteria->compare('lastLoginTime',$this->lastLoginTime,true);
		$criteria->compare('lastIP',$this->lastIP,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('visitCount',$this->visitCount);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * 保存用户信息
     * @static
     * @param $user
     * @return bool
     */
    public static function saveUser($user)
    {
        if ($user->isNewRecord) {
            if (!$user->insert()) {
                return false;
            }
        } else {
            if (!$user->update()) {
                return false;
            }
        }
        return true;
    }

    /**
     * 删除用户，软删除，只是标记用户状态为删除不可用状态
     * @static
     * @param $user
     * @return bool
     */
    public static function deleteUser($user)
    {
        $user->status = 2;
        if (!$user->update()) {
            return false;
        }
        return true;
    }

    /**
     * 根据条件查找用户
     * @static
     * @param string $keyword
     * @param int $limit
     * @return string
     */
    public static function searchUser($keyword = '', $limit = 20)
    {
        if (empty($keyword)) {
            return '';
        }
        $criteria = new CDbCriteria();
        $criteria->condition = 'name like :str
                       or nameFirstPY like :str
                       or alias like :str
                       or aliasFirstPY like :str';

        $criteria->params = array(':str' => $keyword . '%');
        $criteria->limit = $limit;

        return Users::model()->findALl($criteria);
    }


    /**
     * 生成六位随机密码
     * @static
     * @return string
     */
    public static function GenerateNewPassword()
    {

        return RandomStringGenerator::getRandomString();

    }

    /**
     * 更新用户登录的时间和IP
     * @static
     * @param $id
     */
    public static function  updateLastLoginTimeAndIp($id)
    {
        $user = Users::model()->findByPk($id);
        $user->visitCount=$user->visitCount+1;
        $user->lastLoginTime = date('Y-m-d H:i:s');
        $user->lastIP = Yii::app()->request->userHostAddress;
        $user->update();
    }

    /**
     * 检查用户别名（昵称）是否存在
     * @static
     * @param $alias
     * @param null $id
     * @return boolean
     */
    public static function checkAlias($alias, $id = null)
    {

        $criteria = new CDbCriteria();
        if (!empty($id)) {
            $criteria->addCondition("id <> '" . $id . "'");
        }
        $criteria->addCondition("alias = '" . $alias . "'");
        return Users::model()->exists($criteria);

    }

    /**
     * 检查用户输入电子邮件是否已经存在
     * @static
     * @param $email
     * @param null $id
     * @return boolean
     */
    public static function checkEmail($email, $id = null)
    {

        $criteria = new CDbCriteria();
        if (!empty($id)) {
            $criteria->addCondition("id <> '" . $id . "'");
        }
        $criteria->addCondition("email = '" . $email . "'");
        return Users::model()->exists($criteria);

    }

    /**
     * 检查用户手机好是否已经存在
     * @static
     * @param $phone
     * @param null $id
     * @return boolean
     */
    public static function checkMobilePhone($phone, $id = null)
    {

        $criteria = new CDbCriteria();
        if (!empty($id)) {
            $criteria->addCondition("id <> '" . $id . "'");
        }
        $criteria->addCondition("mobilePhone = '" . $phone . "'");
        return Users::model()->exists($criteria);

    }

    /**
     * 检查用户的唯一识别好是否已经存在
     * @static
     * @param $identityNo
     * @param null $id
     * @return boolean
     */
    public static function checkIdentityNo($identityNo, $id = null)
    {
        $criteria = new CDbCriteria();
        if (!empty($id)) {
            $criteria->addCondition("id <> '" . $id . "'");
        }
        $criteria->addCondition("identityNo = '" . $identityNo . "'");
        return Users::model()->exists($criteria);

    }


    /**
     * 检查帐号是否存在
     * @static
     * @param $userAccount
     * @param null $id
     * @return mixed
     */
    public static function checkUserAccount($userAccount, $id = null)
    {
        $criteria = new CDbCriteria();
        if (!empty($id)) {
            $criteria->addCondition("id <> '" . $id . "'");
        }
        $criteria->addCondition("userAccount = '" . $userAccount . "'");
        return Users::model()->exists($criteria);

    }

    /**
     * 生成一个用户帐号
     * @static
     * @return int
     */
    public function getNewAccount()
    {
        $flag = true;
        do {
            $count = RandomStringGenerator::getRandomString();
            $num = Users::model()->count();
            if ($num <= 100000 || empty($num)) {
                $num = 100000 + 1;
            }
            if (!Users::checkUserAccount($num . $count)) {
                $flag = false;
            }
        } while ($flag);

        return $num . $count;
    }

}