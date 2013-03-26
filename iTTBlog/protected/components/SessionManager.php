<?php
/**
 * Session 管理
 */
class SessionManager{

    public function __construct(){

    }

    public function factory(){
        static $obj;

        if (!$obj)
            $obj = new SessionManager();

        return $obj;
    }

    /**
     * 解决多账号同时在线的冲突问题(后登陆的踢掉前面登陆的)
     * @param $cardId
     */
    static public function solveConflictForLogin($cardId){

        // 构建多表级联删除
        $sessionTable = Yii::app()->session->sessionTableName;
        $txtSqlcmd = "delete from ".$sessionTable." using ".$sessionTable." left join user_accessinfo on ".
                     $sessionTable.".id = user_accessinfo.sessionId where user_accessinfo.cardId = '".$cardId."'";

// todo : 需要开启清理session，同一用户只能有一个终端在线的限制时，就将下面注释放开。
//        Yii::app()->db->createCommand($txtSqlcmd)->execute();
    }
}

?>