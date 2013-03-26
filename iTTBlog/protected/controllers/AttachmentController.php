<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nacky
 * Date: 12-5-5
 * Time: 上午1:33
 * To change this template use File | Settings | File Templates.
 */

class AttachmentController extends Controller
{

    /**
     *上传成功后保存文件信息
     * 进行裁剪、打水印等其它处理
     * @param $event
     * @return bool
     */
    private function saveFile($event)
    {
        //$event->sender['uploadedFile'] is CUploadedFile
        //$event->sender['uploadedFile']->name; the original name of the file being uploaded
        // $event->sender['name']  yourfilename.EXT
        // do something   ......
        $src = Yii::app()->basePath . '/../upload/' . $event->sender['name'];
        $im = imagecreatefromjpeg($src);
        $textColor = imagecolorallocate($im, 0, 0, 255);
        imagestring($im, 2, 0, 0, 'iTTBlog', $textColor);
        imagejpeg($im, $src);
        imagedestroy($im);
        return true;
    }

    public function actionUploadView()
    {
        $this->pageTitle = "itt文件上传。。。";
        $this->render("/photo/pUpload");
    }

    public function actionUpload()
    {
        try {
            $user = Users::model()->findByPk(Yii::app()->user->id);
            if (empty($user)) {
                $this->redirect(Yii::app()->createUrl("site/login", array('currentUrl' => $_SERVER['REQUEST_URI'])));
                return;
            }
            $rootPath = Yii::getPathOfAlias('webroot.uploadFile.photo.' . $user->userAccount);
            $realPath = Yii::app()->request->baseUrl . "/uploadFile/photo/" . $user->userAccount;
            if (!is_dir($rootPath)) {
                $rootPath = mkdir($rootPath);
            }
            $file = CUploadedFile::getInstanceByName('Filedata');
            if (!$file || $file->getHasError()) {
                throw new Exception('文件不存在！');
                Yii::app()->end();
            }


            $file_name = $file->name;
            $file_ext = $file->extensionName;
            $random = date('Ymd') . rand(0, 99999) . uniqid();
            $newFileName = $random . '.' . $file_ext;
            $temp_filePath = $rootPath . '/' . $newFileName;
            $real_filePath = $realPath . '/' . $newFileName;

            //保存上传文件信息
            $attachment = new Attachment();
            $attachment->userAccount =$user->userAccount;
            $attachment->articleId = 0;
            $attachment->attachmentType = 1;
            $attachment->displayName = $file_name;
            $attachment->filePath = $real_filePath;
            $attachment->status = 0;

            if (!$attachment->insert()) {
                throw new Exception('保存失败！');
            }

            //保存文件
            if (!$file->saveAs($temp_filePath)) {
                throw new Exception('保存失败！');
                Yii::app()->end();
            }
            foreach (Yii::app()->log->getRoutes() as $route) {
                $route->enabled = false;
            }

            echo "FILEID:" . $real_filePath;

        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
        Yii::app()->end();
    }

    /**
     * 上传头像
     */
    public function actionUploadHead(){
        try {
            $user = Users::model()->findByPk(Yii::app()->user->id);
            if (empty($user)) {
                $this->redirect(Yii::app()->createUrl("site/login", array('currentUrl' => $_SERVER['REQUEST_URI'])));
                return;
            }
            $rootPath = Yii::getPathOfAlias('webroot.uploadFile.photo.' . $user->userAccount);
            $realPath = Yii::app()->request->baseUrl . "/uploadFile/photo/" . $user->userAccount;
            if (!is_dir($rootPath)) {
                $rootPath = mkdir($rootPath);
            }
            $file = CUploadedFile::getInstanceByName('Filedata');
            if (!$file || $file->getHasError()) {
                throw new Exception('文件不存在！');
                Yii::app()->end();
            }


            $file_name = $file->name;
            $file_ext = $file->extensionName;
            $random = date('Ymd') . rand(0, 99999) . uniqid();
            $newFileName = $random . '.' . $file_ext;
            $temp_filePath = $rootPath . '/' . $newFileName;
            $real_filePath = $realPath . '/' . $newFileName;

            //保存上传文件信息
            $attachment = new Attachment();
            $attachment->userAccount =$user->userAccount;
            $attachment->articleId = 0;
            $attachment->attachmentType = 1;
            $attachment->displayName = $file_name;
            $attachment->filePath = $real_filePath;
            $attachment->status = 0;

            if (!$attachment->insert()) {
                throw new Exception('保存失败！');
            }

            //保存文件
            if (!$file->saveAs($temp_filePath)) {
                throw new Exception('保存失败！');
                Yii::app()->end();
            }
            foreach (Yii::app()->log->getRoutes() as $route) {
                $route->enabled = false;
            }

            echo "FILEID:" . $real_filePath;

        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
        Yii::app()->end();
    }
}
