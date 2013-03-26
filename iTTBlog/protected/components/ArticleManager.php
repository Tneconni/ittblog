<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nacky
 * Date: 12-6-10
 * Time: 上午10:47
 * To change this template use File | Settings | File Templates.
 */
class ArticleManager
{
    /**
     * 获取热门文章
     * @return mixed
     */
   public static  function GetHotArticleList(){
       $sql="select * from articles where status=1 order by viewCount DESC ,publishTime DESC  limit 10";
       $hots=Articles::model()->findAllBySql($sql);
       return $hots;
   }
}
