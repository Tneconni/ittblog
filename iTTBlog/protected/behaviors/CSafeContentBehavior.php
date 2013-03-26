<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nacky
 * Date: 12-5-5
 * Time: 上午1:26
 * To change this template use File | Settings | File Templates.
 */
class CSafeContentBehavior extends CActiveRecordBehavior
{
    public $attributes = array();
    protected $purifier;

    function __construct()
    {
        $this->purifier = new CHtmlPurifier;
    }

    public function beforeSave($event)
    {
        foreach ($this->attributes as $attribute) {
            $this->getOwner()->{$attribute} = $this->purifier->purify($this->getOwner()->{$attribute});
        }
    }
}
