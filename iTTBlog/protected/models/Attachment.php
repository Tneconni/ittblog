<?php

/**
 * This is the model class for table "attachment".
 *
 * The followings are the available columns in table 'attachment':
 * @property integer $id
 * @property integer $articleId
 * @property integer $userAccount
 * @property string $attachmentType
 * @property string $displayName
 * @property string $filePath
 * @property integer $status
 */
class Attachment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Attachment the static model class
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
		return 'attachment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('articleId, userAccount, status', 'numerical', 'integerOnly'=>true),
			array('attachmentType', 'length', 'max'=>8),
			array('displayName, filePath', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, articleId, userAccount, attachmentType, displayName, filePath, status', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'articleId' => 'Article',
			'userAccount' => 'User Account',
			'attachmentType' => 'Attachment Type',
			'displayName' => 'Display Name',
			'filePath' => 'File Path',
			'status' => 'Status',
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
		$criteria->compare('articleId',$this->articleId);
		$criteria->compare('userAccount',$this->userAccount);
		$criteria->compare('attachmentType',$this->attachmentType,true);
		$criteria->compare('displayName',$this->displayName,true);
		$criteria->compare('filePath',$this->filePath,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}