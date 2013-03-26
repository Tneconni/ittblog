<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nacky
 * Date: 12-5-6
 * Time: 下午10:08
 * To change this template use File | Settings | File Templates.
 */
class GeneralMessage
{
    /**
     * 常用体是信息
     * @static
     * @param $num
     * @return mixed
     */
    public static function formalMessage($num){

       $message= array(
           '0'=>"记录生活，发表心情，留着某天和他/她一起翻阅，一起回忆~",
           '1'=>"欢迎来到iTTBlog家园，在这里记录生活，发表心情，留着某天和他/她一起翻阅，一起回忆~",
           '2'=>"",
           '3'=>"",
           '4'=>"",
           '5'=>"",
           '6'=>"",
           '7'=>"",
           '8'=>"",
           '9'=>"",
       );

        return $message[$num];
    }
}
