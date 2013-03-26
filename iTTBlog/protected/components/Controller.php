<?php
/**
 * Controller 是一个自定义的基础类base controller class.
 * 所有应用程序的控制器都是扩展息这个基础类base class.
 */
class Controller extends CController
{
    /**
     * 字符串变量，控制器视图默认的布局是'column1',
     * 意思是使用单列布局，请看'protected/views/layouts/column1.php'.
     */
    public $layout='column1';
    /**
     * 数组变量，上下文菜单项，这个属性将被分配给{@link CMenu::items}.
     */
    public $menu=array();
    /**
     * 当前页的数组变量breadcrumbs.这个属性的值将被分配给{@link CBreadcrumbs::links}. 请参考 {@link CBreadcrumbs::links}
     * 可以获取更多的细节，并指派给这个属性
     */
    public $breadcrumbs=array();
}