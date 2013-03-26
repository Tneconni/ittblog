<?php

/**
 * This is the model class for table "layouts".
 *
 * The followings are the available columns in table 'layouts':
 * @property integer $layoutId
 * @property string $userAccount
 * @property string $layoutLeft
 * @property string $layoutMiddle
 * @property string $layoutRight
 * @property string $currentStatus
 */
class Layouts extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Layouts the static model class
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
		return 'layouts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userAccount', 'length', 'max'=>36),
			array('layoutLeft, layoutMiddle, layoutRight', 'length', 'max'=>255),
			array('currentStatus', 'length', 'max'=>8),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('layoutId, userAccount, layoutLeft, layoutMiddle, layoutRight, currentStatus', 'safe', 'on'=>'search'),
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
			'layoutId' => 'Layout',
			'userAccount' => 'User Account',
			'layoutLeft' => 'Layout Left',
			'layoutMiddle' => 'Layout Middle',
			'layoutRight' => 'Layout Right',
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

		$criteria->compare('layoutId',$this->layoutId);
		$criteria->compare('userAccount',$this->userAccount,true);
		$criteria->compare('layoutLeft',$this->layoutLeft,true);
		$criteria->compare('layoutMiddle',$this->layoutMiddle,true);
		$criteria->compare('layoutRight',$this->layoutRight,true);
		$criteria->compare('currentStatus',$this->currentStatus,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}