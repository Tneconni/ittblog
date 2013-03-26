<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nacky
 * Date: 12-4-15
 * Time: 上午10:16
 * To change this template use File | Settings | File Templates.
 */
class UserController extends Controller
{

    public $layout = 'column1';

    /**
     * 用户管理列表
     * 仅管理员有权限
     */
    public function actionUserList()
    {

        $currentUser = Users::model()->findByPk(Yii::app()->user->id);
        if (empty($currentUser) or $currentUser->role != "a") {
            Dialog::Message("非管理员用户，没有权限进行此操作！");
            $this->redirect($this->createUrl("/site/index"));
            return;
        }
        $dataProvider = new CActiveDataProvider('Users', array(
            'criteria' => array(
                'condition' => 'status=0 or status=1',
                'order' => 'lastLoginTime DESC',
            ),
            'pagination' => array(
                'pageSize' => 20,
            ),
        ));
        $this->render("/user/userList", array('dataProvider' => $dataProvider));
    }

    /**
     * 编辑用户
     * @return bool
     * @throws Exception
     */
    public function actionUserEdit()
    {

        $userId = '';
        $errorLog = '';
        $currentUser = Users::model()->findByPk(Yii::app()->user->id);
        if (empty($currentUser) or $currentUser->role != "a") {
            Dialog::Message("非管理员用户，没有权限进行此操作！");
            $this->redirect($this->createUrl("/site/index"));
            return;
        }
        if (isset($_GET['id'])) {
            $userId = $_GET['id'];
            $user = Users::model()->findByPk($userId);
        } else {
            $user = new Users();
        }
        try {
            if (isset($_POST["user"])) {
                $user->attributes = $_POST['user'];
                if ($user->isNewRecord) {
                    $userId = $user->id;
                }

                if (empty($user->alias)) {
                    throw new Exception("用户帐号不能为空！");
                }
                if (Users::checkAlias($user->alias, $userId)) {
                    throw new Exception("您输入的用户帐号已经已经存在，请重新输入！");
                }
                if (!empty($user->identityNo)) {
                    if (Users::checkIdentityNo($user->identityNo, $userId)) {
                        throw new Exception("您输入身份标识已经存在，请重新输入！");
                    }
                }
                if (empty($user->email) or empty($user->userAccount)) {
                    Dialog::Message("不合法用户，请先注册在编辑");
                    $this->redirect($this->createUrl("/site/reg"));
                    return;
                }
                if (Users::checkEmail($user->email, $userId)) {
                    throw new Exception("您输入的电子邮件已经存在，请重新输入！");
                }
                if (!empty($user->mobilePhone)) {
                    if (Users::checkMobilePhone($user->mobilePhone, $userId)) {
                        throw new Exception("您输入的手机号已经被使用！");
                    }
                }
                if (!Users::saveUser($user)) {
                    throw new Exception("网络故障，保存用户失败，请稍候重试！");
                }
                $this->redirect($this->createUrl("userList", array('page' => PageManager::CurrentPage('page'))));
                return true;
            }
        } catch (Exception $e) {
            Yii::log('错误提示信息：' . $e->getMessage(), 'error');
            $errorLog = $e->getMessage();
        }
        $this->pageTitle = "用户信息";
        $this->render('/user/userEdit', array('user' => $user, 'errorLog' => $errorLog));
    }


    public function actionUserDelete()
    {
        $currentUser = Users::model()->findByPk(Yii::app()->user->id);
        if (empty($currentUser) or $currentUser->role != "a") {
            Dialog::Message("非管理员用户，没有权限进行此操作！");
            $this->redirect($this->createUrl("/site/index"));
            return;
        }
        try {
            $errorLog = '删除成功！';
            if (isset($_GET['id'])) {
                $userId = $_GET['id'];
                $user = Users::model()->findByPk($userId);
                if (!Users::deleteUser($user)) {
                    throw new Exception("网络故障，删除用户失败，请稍候重试！");
                }
            }
        } catch (Exception $e) {
            Yii::log('错误提示信息：' . $e->getMessage(), 'error');
            $errorLog = $e->getMessage();
        }
        Dialog::Message($errorLog, '提示信息：');
        $this->redirect($this->createUrl("userList", array('page' => PageManager::CurrentPage('page'))));
    }
}
