<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nacky
 * Date: 12-4-23
 * Time: 下午11:41
 * To change this template use File | Settings | File Templates.
 */
class CommentController extends Controller
{
    /**
     * 评论列表
     */
    public function actionCommentList()
    {
        $errorLog = '';
        $commentArr=array();
        try {
            if (isset($_POST['articleId'])) {
                $commentsOfArticle = Comment::model()->findAllByAttributes(array('articleId' => $_POST['articleId']));
                if (empty($commentsOfArticle)) {
                    throw new Exception("该文章还没有点评");
                }
                foreach ($commentsOfArticle as $c) {
                    if (!empty($c)) {

                    }
                }
            }


        } catch (Exception $e) {
            $errorLog = $e->getMessage();
        }
        $this->render('comment/list');
    }


    /**
     * 删除评论
     */
    public function actionCommentDelete()
    {
        $this->render('comment/list');
    }

}
