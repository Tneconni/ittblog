<?php

/**
 * This is the model class for table "articles".
 *
 * The followings are the available columns in table 'articles':
 * @property integer $id
 * @property string $author
 * @property string $title
 * @property string $content
 * @property string $publishTime
 * @property string $typeId
 * @property string $viewCount
 * @property integer $status
 */
class Articles extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Articles the static model class
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
        return 'articles';
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
            array('id,viewCount, status', 'numerical', 'integerOnly' => true),
            array('author', 'length', 'max' => 20),
            array('title', 'length', 'max' => 255),
            array('typeId', 'length', 'max' => 36),
            array('viewCount', 'length', 'max' => 8),
            array('content, publishTime', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, author, title, content, publishTime, typeId, status', 'safe', 'on' => 'search'),
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
            'user' => array(self::BELONGS_TO, 'Users', '', 'on' => 't.author=Users.userAccount'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => '博文ID',
            'author' => '作者',
            'title' => '标题',
            'content' => '正文内容',
            'publishTime' => 'Publish Time',
            'typeId' => '所属类型',
            'viewCount' => '被访问次数',
            'status' => '博文状态',
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
        $criteria->compare('author', $this->author, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('publishTime', $this->publishTime, true);
        $criteria->compare('typeId', $this->typeId, true);
        $criteria->compare('viewCount', $this->viewCount, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * 安全过滤
     * @return array
     */
//    public function behaviors()
//    {
//        return array(
//            'CSafeContentBehavior' => array(
//                'class' => 'application.behaviors.CSafeContentBehavior',
//                'attributes' => array('id, author, title, content, publishTime, typeId, status'),
//            ),
//        );
//    }

    /**
     *
     * 检查文章内容是否为空，
     * 判断标题是否为空，若标题为空则去正文内容前100字符作为标题
     * @return bool|int
     */
    public function  checkArticle()
    {
        if (trim($this->content) == '') {
            return false;
        }
        if (trim($this->title) == '') {
            $this->title = mb_substr(trim($this->content), 0, 100, 'utf-8') . "……";
            return true;
        }
        return true;
    }

    /**
     * 保存
     * @static
     * @param $article
     * @return mixed
     */
    public static function saveArticle($article)
    {
        if ($article->isNewRecord) {
            if (!$article->insert()) {
                return false;
            }
        } else {
            if (!$article->update()) {
                return false;
            }
        }
        return true;

    }

    /**
     * 删除
     * @static
     * @param $id
     * @return mixed
     */
    public static function deleteArticle($id)
    {
        $article = Articles::model()->findByPk($id);
        $article->status = 2;
        return Articles::saveArticle($article);
    }

    /**
     * 截取指定长度字符串串
     * @static
     * @param $str
     * @param int $length
     * @return string
     */
    public static function subString($str, $length =100)
    {
        if (!empty($str)) {
            if(strlen($str)<$length){
                $result=$str;
            }else{
                $result=mb_substr($str,0,$length,"utf-8")."……";
            }
           return $result;
        }
    }

}