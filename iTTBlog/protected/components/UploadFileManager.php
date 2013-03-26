<?php
/**
 * 上传的文件管理
 */
Yii::import('application.components.DirManager');
class UploadFileManager
{
    /**
     * @static
     * @param $pathAliasName 要上传的目标别名 如:'webroot.uploadfiles'
     * @param $filePostName  上传组件的name属性值: 默认为'Filedata'
     * @return bool|string   如果上传成功返回新的文件名称。否则返回false
     * @throws exception
     */
    public static function uploadByName($pathAliasName, $filePostName = 'Filedata')
    {
        try {
            $objFileIns = CUploadedFile::getInstanceByName($filePostName);
            if (!$objFileIns || $objFileIns->getHasError()) {
                throw new exception('错误: 上传的文件格式不支持。');
                return false;
            }

            // $objFileIns->name; // 上传上来的文件名

            $rootPath = Yii::getPathOfAlias($pathAliasName);
            $random = date('Ymd') . rand(0, 999);
            $newFileName = $random . '.' . $objFileIns->extensionName; // 新文件名的格式: 年月日随机数.扩展名

            $objFileIns->saveAs($rootPath . '/' . $newFileName);

            // 重置路由状态
            foreach (Yii::app()->log->getRoutes() as $route)
                $route->enabled = false;

            return $newFileName; // 返回新上传文件的名称(不是完整路径)
        } catch (Exception $ex) {
            throw $ex;
            return false;
        }
    }

    /**
     * 根据服务器上的路径删除文件
     * @static
     * @param $filename 要删除文件的完整路径 (以项目跟路径为起点的相对路径)
     * @return bool   删除成功返回true，否则返回false
     * @throws exception
     */
    public static function delFileByPath($filename)
    {
        try {
            $dirOption = new DirOption;
            $filename = $dirOption->dir_path($filename); // 从web相对路径转换为绝对路径
            if (is_file($filename) && !unlink($filename)) {
                if (chmod($filename, 0777)) {
                    unlink($filename);
                    return true;
                }
            } else {
                // 删除不掉等以后人工删除
                //throw new exception("删除文件时发生错误,删除失败!");
            }

            return false;

        } catch (Exception $ex) {
            throw $ex;
            return false;
        }
    }

}

?>