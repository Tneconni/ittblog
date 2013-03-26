<?php

/**
 * This is the model class for table "types".
 *
 * The followings are the available columns in table 'types':
 * @property integer $id
 * @property string $userAccount
 * @property string $name
 * @property string $nameFirstPY
 * @property string $groupType
 * @property integer $typeTag
 * @property integer $displayOrder
 */
class Types extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Types the static model class
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
		return 'types';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'required'),
			array('id, typeTag, displayOrder', 'numerical', 'integerOnly'=>true),
			array('userAccount', 'length', 'max'=>36),
			array('name, nameFirstPY, groupType', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, userAccount, name, nameFirstPY, groupType, typeTag, displayOrder', 'safe', 'on'=>'search'),
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
			'userAccount' => 'User Account',
			'name' => 'Name',
			'nameFirstPY' => 'Name First Py',
			'groupType' => 'Group Type',
			'typeTag' => 'Type Tag',
			'displayOrder' => 'Display Order',
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
		$criteria->compare('userAccount',$this->userAccount,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('nameFirstPY',$this->nameFirstPY,true);
		$criteria->compare('groupType',$this->groupType,true);
		$criteria->compare('typeTag',$this->typeTag);
		$criteria->compare('displayOrder',$this->displayOrder);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * 获取文章类别
     * @static
     * @param int $userAccount
     * @return mixed
     */
    public static function GetArticleTypes($userAccount = 0)
    {
        $criteria=new CDbCriteria();
        $criteria->addCondition("typeTag=0");
        if(!empty($userAccount)){
            $criteria->addCondition("userAccount='0' or userAccount='".$userAccount."'");
        }else{
            $criteria->addCondition("userAccount='0'");
        }
        $criteria->order="displayOrder,name DESC";
        return Types::model()->findAll($criteria);
    }
}