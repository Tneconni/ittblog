<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nacky
 * Date: 12-6-9
 * Time: 下午9:04
 * To change this template use File | Settings | File Templates.
 */
class photoController extends Controller
{


    /**
     * 相册列表
     * @return mixed
     */
    public function actionPhotoList()
    {
        try {
            if (Yii::app()->user->name == "Guest") {
                $this->redirect(Yii::app()->createUrl("site/login", array('currentUrl' => $_SERVER['REQUEST_URI'])));
                return;
            }
            $user = Users::model()->findByPk(Yii::app()->user->id);
            $photoFiles = Attachment::model()->findAllByAttributes(array('userAccount' => $user->userAccount, 'attachmentType' => 0));
        } catch (Exception $e) {
            Yii::log($e->getMessage(), 'error');
            Dialog::Message("网络故障，请稍候重试！");
        }
        $this->render("/photo/photoList", array('photoFiles' => $photoFiles));
    }

    /**
     * 照片预览
     * @return mixed
     */
    public function actionPhotoView()
    {
        try {
            $user = Users::model()->findByPk(Yii::app()->user->id);
            if (empty($user)) {
                $this->redirect(Yii::app()->createUrl("site/login", array('currentUrl' => $_SERVER['REQUEST_URI'])));
                return;
            }
            $sql = "select * from attachment where userAccount='" . $user->userAccount . "' and status= 0  and attachmentType=1";
            $photos = Attachment::model()->findBySql($sql);
         } catch (Exception $e) {
            Yii::log('图片错误：' . $e->getMessage(), 'error');
        }
        $this->render('/photo/picView', array('photos' => $photos));
    }

    /**
     * 下一张
     * @return mixed
     */
    public function actionGetNextFilePath()
    {
        $next = $_POST["nq"];
        try {
            $user = Users::model()->findByPk(Yii::app()->user->id);
            if (empty($user)) {
                $this->redirect(Yii::app()->createUrl("site/login", array('currentUrl' => $_SERVER['REQUEST_URI'])));
                return;
            }
            $sql = "select * from attachment where filePath<> '".$next."'  and  userAccount='" . $user->userAccount . "'
            and status= 0  and attachmentType=1 order by id limit 1 ";
            $photo = Attachment::model()->findBySql($sql);
            echo FastJSON::encode($photo->filePath);
            return;
        } catch (Exception $e) {
            Yii::log('图片错误：' . $e->getMessage(), 'error');
        }
       echo FastJSON::encode(1);
    }
}
