<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nacky
 * Date: 12-4-20
 * Time: 下午11:43
 * To change this template use File | Settings | File Templates.
 */
class FileManager
{

    private $baseUrl;

    /**
     * 调用此方法导入 js 文件
     * @static
     * @param $dirPathName
     * @return string
     */
    public static function importJs($dirPathName)
    {
        $baseUrl = Yii::app()->request->baseUrl;
        $cs = Yii::app()->clientScript;
        $cs->coreScriptPosition = CClientScript::POS_HEAD;
        $cs->scriptMap = array();
        try {
            $fileArr = self::GetFilePathOfDir($dirPathName, 'js');
            if (!empty($fileArr)) {
                for ($i = 0; $i < count($fileArr); $i++) {
                    $cs->registerScriptFile($baseUrl . $fileArr[$i]);
                }
            }
        } catch (Exception $ex) {
            Yii::log('错误信息：' . $ex->getMessage(), 'error');
        }
    }


    /**
     * 调用次方法导入css 文件
     * @static
     * @param $dirPathName
     * @return string
     */
    public static function importCss($dirPathName)
    {
        $baseUrl = Yii::app()->request->baseUrl;
        $cs = Yii::app()->clientScript;
        $cs->coreScriptPosition = CClientScript::POS_HEAD;
        $cs->scriptMap = array();
        try {
            $fileArr = self::GetFilePathOfDir($dirPathName, 'css');
            if (!empty($fileArr)) {
                for ($i = 0; $i < count($fileArr); $i++) {
                    $cs->registerScriptFile($baseUrl . $fileArr[$i]);
                }
            }
        } catch (Exception $ex) {
            Yii::log('错误信息：' . $ex->getMessage(), 'error');
        }
    }


    /**
     * 获取给定的路径下的指定文件类型的文件，默认所有文件
     * @param $dirPath
     * @param string $type
     * @return array
     */
    public static function GetFilePathOfDir($dirPath = '', $type = '*')
    {
        $filePath = array();
        if ($dirPath == '') {
            $files = scandir("." . Yii::app()->baseUrl);
            for ($i = 0; $i < count($files); $i++) {
                if (preg_match('/(.*)(\.)' . $type . '$/i', $files[$i])) {
                    $filePath[] = $files[$i];
                }
            }
        } else {
            $files = scandir("." . '/' . $dirPath);
            for ($i = 0; $i < count($files); $i++) {
                if (preg_match('/(.*)(\.)' . $type . '$/i', $files[$i])) {
                    $filePath[] = Yii::app()->baseUrl . '/' . $dirPath . '/' . $files[$i];
                }
            }
        }
        return $filePath;
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }
}
