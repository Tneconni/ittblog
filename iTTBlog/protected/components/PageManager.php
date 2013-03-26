<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nacky
 * Date: 12-4-25
 * Time: 上午1:37
 * To change this template use File | Settings | File Templates.
 */
class PageManager
{

    /**
     * 获取页码
     * @static
     * @param $pageStr
     * @return int
     */
    public static function CurrentPage($pageStr)
    {
        $page=0;
        if (isset($_POST[$pageStr])) {
            $page = $_POST[$pageStr];
        } elseif(isset($_GET[$pageStr])){
            $page = $_GET[$pageStr];
        }
        return $page;
    }
}
