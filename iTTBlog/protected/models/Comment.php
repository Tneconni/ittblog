<?php

/**
 * This is the model class for table "comments".
 *
 * The followings are the available columns in table 'comments':
 * @property integer $id
 * @property string $articleId
 * @property string $commenter
 * @property string $content
 * @property string $publishTime
 * @property integer $delTag
 */
class Comment extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Comment the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'comments';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('articleId, content, publishTime', 'required'),
            array('delTag', 'numerical', 'integerOnly' => true),
            array('articleId, commenter', 'length', 'max' => 36),
            array('content', 'length', 'max' => 500),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, articleId, commenter, content, publishTime, delTag', 'safe', 'on' => 'search'),
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
            'commenter' => 'Commenter',
            'content' => 'Content',
            'publishTime' => 'Publish Time',
            'delTag' => 'Del Tag',
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('articleId', $this->articleId, true);
        $criteria->compare('commenter', $this->commenter, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('publishTime', $this->publishTime, true);
        $criteria->compare('delTag', $this->delTag);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * 统计点评数，或一篇文章的点评数
     * @static
     * @param null $articleId
     * @return mixed
     */
    public static function getCommentCount($articleId = null)
    {

        $criteria = new CDbCriteria();
        if (!empty($articleId)) {
            $criteria->addCondition("articleId='" . $articleId . "'");
        }
        $criteria->addCondition("delTag=0");
        return Comment::model()->count($criteria);
    }

    /**
     * 找出一篇文章的所有点评
     * @static
     * @param $articleId
     * @param int $limit
     * @return mixed
     */
    public static function getComments($articleId,$limit=50)
    {

        $criteria = new CDbCriteria();
        if (!empty($articleId)) {
            $criteria->addCondition("articleId='" . $articleId . "'");
        }
        $criteria->addCondition("delTag=0");
        $criteria->limit=$limit;
        $criteria->order="publishTime DESC";
        return Comment::model()->findAll($criteria);
    }
}