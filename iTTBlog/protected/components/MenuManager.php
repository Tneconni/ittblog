<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nacky
 * Date: 12-5-6
 * Time: 下午3:03
 * To change this template use File | Settings | File Templates.
 */
class MenuManager
{
    public static function GetMenu()
    {
        $menu = array();
        $login = Yii::app()->user->name == 'Guest' ? (array('label' => '登录iTT博客', 'url' => array('/site/login'),
            'items' => array(array('label' => '注册iTT帐号', 'url' => array('/site/reg'))))) :
            array('label' => Yii::app()->user->name . "(退出)", 'url' => array('/site/logout'));

        $home = array('label' => 'iTT首页', 'url' => array('/site/index'));

        $essy = array('label' => 'iTT随笔', 'url' => array(''),
            'items' => array(
                array('label' => '最新随笔', 'url' => array('/essay/essayList')),
                array('label' => 'iTT随笔', 'url' => array('/essay/essayEdit')),
            ),);

        $article = array('label' => 'iTT博文', 'url' => array(''),
            'items' => array(
                array('label' => '我的博文', 'url' => array('/article/articleList')),
                array('label' => '发表博文', 'url' => array('/article/articleEdit')),
            ),);

        $photo = array('label' => 'iTT相册', 'url' => array(''),
            'items' => array(
                array('label' => '我的相册', 'url' => array('/photo/photoList')),
                array('label' => 'iTT自画像', 'url' => array('/photo/photoList')),
            ));

        $date = array('label' => '相约iTT', 'url' => array(''),
            'items' => array(
                array('label' => 'iTT贴吧', 'url' => array('')),
                array('label' => 'iTT空间', 'url' => array('')),
                array('label' => 'iTT商城', 'url' => array('')),
                array('label' => 'iTT聊天室', 'url' => array('')),
            ));
        $private = array('label' => '个人中心', 'url' => array(''),
            'items' => array(
                array('label' => '注销', 'url' => array('/site/logout')),
                array('label' => '个性设置', 'url' => array('/site/logout')),
                array('label' => '个人资料', 'url' => array('/user/manager')),
            ));
        $about = array('label' => '关于iTT', 'url' => array(''),
            'items' => array(
                array('label' => '关于我们', 'url' => array('/site/about')),
                array('label' => '联系我们', 'url' => array('/site/contact')),
                array('label' => 'ITT帮助', 'url' => array('/site/help')),
            ));

        $currentUser= Yii::app()->user->getState('user');
        if (!empty($currentUser) and $currentUser->role == "a") {
            $admin = array('label' => '用户管理', 'url' => array('/user/userList'));
            array_push($menu, $admin);
        }


        array_push($menu, $login);
        array_push($menu, $home);
        array_push($menu, $essy);
        array_push($menu, $article);
        array_push($menu, $photo);
        array_push($menu, $date);
        array_push($menu, $private);
        array_push($menu, $about);
        return $menu;
    }
}
