<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nacky
 * Date: 12-4-25
 * Time: 上午12:04
 * To change this template use File | Settings | File Templates.
 */
class ExceptionManager extends Exception
{

    private $message;

    /**
     * @param $message
     */
    private function setMessage($message)
    {
        $this->$message = $message;
    }


    /**
     * @return mixed
     */
    private function getMessage()
    {
        return $this->message;
    }

}
