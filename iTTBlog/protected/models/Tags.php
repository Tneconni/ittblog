<?php

/**
 * This is the model class for table "tags".
 *
 * The followings are the available columns in table 'tags':
 * @property integer $id
 * @property string $articleId
 * @property string $tagName
 * @property string $tagFirstPY
 */
class Tags extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Tags the static model class
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
        return 'tags';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('articleId', 'length', 'max' => 36),
            array(' tagName, tagFirstPY', 'length', 'max' => 200),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, articleId, tagName, tagFirstPY', 'safe', 'on' => 'search'),
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
            'id' => '标签ID',
            'articleId' => '博文',
            'tagName' => '标签名称',
            'tagFirstPY' => '标签拼音',
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
        $criteria->compare('tagName', $this->tagName, true);
        $criteria->compare('tagFirstPY', $this->tagFirstPY, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * 保存文章标签
     * @static
     * @param $article
     * @param string $tags
     * @return mixed
     */
    public static function saveTags($article, $tags = '')
    {
        if (empty($tags)) {
            //todo 自动从正文内容提取关键字
        }
        $t = Tags::model()->findByAttributes(array('articleId' => $article->id));
        if(!isset($t)){
            $t=new Tags();
            $t->articleId=$article->id;
        }
            $t->tagName=$tags;
            $tagArr=explode(',',$tags);
            if(count($tagArr)>0){
                $tagFirstPin='';
                foreach($tagArr as $ta){
                    if(!empty($ta)){
                        $tagFirstPin.=PinYinGenerator::FirstPinYin(trim($ta)).', ';
                    }
                   $t->tagFirstPY=$tagFirstPin;
                }
            }
        return  $t->isNewRecord?$t->insert():$t->update();
    }
}