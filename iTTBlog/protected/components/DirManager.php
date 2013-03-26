<?php
class DirManager
{

    /**
     * 换算实际路径
     * @param $path
     * @return string
     */
    function dir_path($path)
    {
        $adir = explode('/', $path);

        for ($i = 0; $i < count($adir); $i++)
        {
            $key = false;
            if ($adir[$i] == "..") $key = $i;

            if ($key !== false) {
                $newadir = array();
                for ($j = 0; $j < count($adir); $j++)
                {
                    if ($j == $key - 1 || $j == $key) continue;
                    $newadir[] = $adir[$j];
                }
                $adir = $newadir;
                $newadir = false;
                $i = $i - 2;
            }
        }
        return $path = implode("/", $adir);
    }


    /*
     *按指定路径生成目录
     */
    function dir_mkDirs($path)
    {
        $path = $this->dir_path($path);
        $adir = explode('/', $path);
        $dirlist = '';
        $rootdir = array_shift($adir);
        //if (!file_exists($rootdir)) {
        //    mkdir($rootdir, 0777);
        //}
        //Yii::log('rootpath目录：'. $path);
        foreach ($adir as $val)
        {
            $dirlist .= "/" . $val;
            $dirpath = $rootdir . $dirlist;
            if (!is_dir($dirpath)) {
                mkdir($dirpath, 0777);
                chmod($dirpath, 0777);
            }
        }
    }

    /**
     * 去除特殊字符（主要用于下载文件重命名）
     * @param $fileName
     * @return mixed
     */
    public static function  ReplaceBadCharOfFileName($fileName)
    {
        $str = $fileName;
        $str = str_replace("\\", "_", $str);
        $str = str_replace("/", "_", $str);
        $str = str_replace(":", "_", $str);
        $str = str_replace("*", "_", $str);
        $str = str_replace("?", "_", $str);
        $str = str_replace("\"", "_", $str);
        $str = str_replace("<", "_", $str);
        $str = str_replace(">", "_", $str);
        $str = str_replace("|", "_", $str);
        $str = str_replace("%", "_", $str);
        $str = str_replace(" ", "_", $str); //前面的替换会产生空格,最后将其一并替换掉
        $str = trim($str,"\x00..\x1F");
        return $str;
    }
}

?>