<?php

/**
 * This is the model class for table "windows".
 *
 * The followings are the available columns in table 'windows':
 * @property integer $windowsId
 * @property string $userAccount
 * @property string $blogName
 * @property string $className
 * @property string $currentStatus
 */
class Windows extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Windows the static model class
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
		return 'windows';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userAccount, blogName, className', 'required'),
			array('userAccount', 'length', 'max'=>36),
			array('blogName, className', 'length', 'max'=>255),
			array('currentStatus', 'length', 'max'=>8),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('windowsId, userAccount, blogName, className, currentStatus', 'safe', 'on'=>'search'),
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
			'windowsId' => 'Windows',
			'userAccount' => 'User Account',
			'blogName' => 'Blog Name',
			'className' => 'Class Name',
			'currentStatus' => 'Current Status',
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

		$criteria->compare('windowsId',$this->windowsId);
		$criteria->compare('userAccount',$this->userAccount,true);
		$criteria->compare('blogName',$this->blogName,true);
		$criteria->compare('className',$this->className,true);
		$criteria->compare('currentStatus',$this->currentStatus,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}