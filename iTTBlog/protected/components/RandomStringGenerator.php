<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nacky
 * Date: 12-4-17
 * Time: 上午12:31
 * To change this template use File | Settings | File Templates.
 */
class RandomStringGenerator
{

    /**
     * 随机生成一个字符串
     * @static
     * @param int $len　生成随机字符串的长度
     * @param string $format ALL：为随机生成字符和数字还有其他特殊符号一起的
     * 　　　　　　　　　　　NUMBER：　纯随机数字
     * 　　　　　　　　　　　STR　：纯字母组合　　
     * @return string
     */
    public static function getRandomString($len = 6, $format = 'NUMBER')
    {
        //随机产生六位数密码Begin
        switch ($format) {
            case 'ALL':
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-＿+*!%^(){}[]\|/.,@#~';
                break;
            case 'CHAR':
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-@#~';
                break;
            case 'STR':
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
                break;
            case 'NUMBER':
                $chars = '0123456789';
                break;
            default :
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-@#~';
                break;
        }
        mt_srand((double)microtime() * 1000000 * getmypid());
        $str = "";
        while (strlen($str) < $len) {
            $str .= substr($chars, (mt_rand() % strlen($chars)), 1);
        }
        return $str;
    }
}
