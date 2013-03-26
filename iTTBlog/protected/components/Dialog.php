<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nacky
 * Date: 12-5-5
 * Time: 上午1:10
 * To change this template use File | Settings | File Templates.
 */
class Dialog
{
    /**
     * @static
     * @param $title
     * @param $message
     * @param int $id
     */
    public static function Message($message,$title='提示', $id = 0)
    {
        if ($id == 0){
            $id = rand(1, 999999);
        }
        Yii::app()->user->setflash($id, array('title' => $title, 'content' => $message));
    }

}
