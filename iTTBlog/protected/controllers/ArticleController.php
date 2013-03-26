<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nacky
 * Date: 12-4-23
 * Time: 下午11:24
 * To change this template use File | Settings | File Templates.
 */
class ArticleController extends Controller
{

    public $layout = 'column1';

    /**
     * 声明所有基于类的动作。
     * @return array
     */
    public function actions()
    {
        return array(
            // 验证码（captcha）动作渲染 CAPTCHA 图像，显示在《联系》页中。
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'transparent' => false,
                'maxLength' => 8,
                'minLength' => 6,
                'offset' => 0,
                'width' => '140',
                'height' => '50',
            ),
            // page 动作渲染存储在'protected/views/site/pages'下面的“静态”页。
            // 它们通过如下地址访问：index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }


    /**
     * 博文列表
     */
    public function actionArticleList()
    {

        $errorLog = '';
        if (isset($_GET['errorLog'])) {
            $errorLog = $_GET['errorLog'];
        }
        try {
            $user = Yii::app()->user->getState('user');
            $criteria = new CDbCriteria();
            if (!empty($user)) {
                $criteria->addCondition("author='" . $user->alias . "'");
                $criteria->addCondition("status=1");
                $criteria->order = "publishTime DESC";
                $articles = Articles::model()->findAll($criteria);
            } else {
                Dialog::Message("您没有执行该项操作的权限，请先登录！");
                $this->redirect(Yii::app()->createUrl('/site/login'));
                return;
            }
        } catch (Exception $e) {
            $errorLog = $e->getMessage();
        }
        if ($errorLog != '') {
            Dialog::Message($errorLog);
        }
        $this->pageTitle = "博客文章列表";
        $this->render('/article/articleList', array('articles' => $articles, 'errorLog' => $errorLog));
    }


    /**
     * 添加、编辑博文
     * @return mixed
     * @throws Exception
     */
    public function actionArticleEdit()
    {
        $errorLog = '';
        $this->pageTitle = "发表文章";
        $page = PageManager::CurrentPage('page');
        try {
            $user = Yii::app()->user->getState('user');
            if (empty($user)) { //未登录用户不允许添加编辑博文
                $this->redirect(Yii::app()->createUrl("/site/login", array('errorLog' => '请先登录！')));
                return;
            }

            if (!empty($_GET['articleId'])) {
                $article = Articles::model()->findByPk($_GET['articleId']);
                $tags = $article->tags->tanName;
            } else if (!empty($_POST['articleId'])) {
                $article = Articles::model()->findByPk($_GET['articleId']);
                $tags = '';
            } else {
                $article = new Articles();
                $tags = '';
            }

            if (isset($_POST['article'])) {
                $article->attributes = $_POST['article'];
                if ($article->checkArticle() === false) {
                    throw new Exception("博文正文内容不能为空！");
                }

                $article->author = $user->alias;
                $article->publishTime = date("Y-m-d H:i:s");
                $article->status = 1;
                //保存文章
                if (!Articles::saveArticle($article)) {
                    throw new Exception("文章发表失败！");
                }
                $tags = $_POST['tags'];
                Tags::saveTags($article, $tags);
                $this->redirect($this->createUrl('articleList', array('page' => $page)));
                return;
            }
        } catch (Exception $ex) {
            $errorLog = $ex->getMessage();
        }

        $this->render('/article/articleEdit', array('article' => $article,
            'page' => $page,
            'tags' => $tags,
            'errorLog' => $errorLog,
            'articleTypes' => Types::GetArticleTypes($user->userAccount),
        ));
    }

    /**
     * 保存草稿
     */
    public function actionSaveDraft()
    {
        try {
            $author = Yii::app()->user->name;
            if (!empty($_POST['articleId'])) {
                $article = Articles::model()->findByPk($_POST['articleId']);
            } else {
                $article = new Articles();
                $article->author = $author;
            }
            $article->title = $_POST['title'];
            $article->content = $_POST['content'];
            $article->publishTime = date("Y-m-d H:i:s");
            $article->typeId = $_POST['typeId'];
            $article->status = 0;
            if (!Articles::saveArticle($article)) {
                echo FastJSON::encode(1);
            } else {
                echo FastJSON::encode($article->id);
            }

        } catch (Exception $e) {
            Yii::log($e->getMessage(), 'error');
            echo FastJSON::encode(1);
        }

    }

    /**
     * 查看文章
     * @return mixed
     */
    public function actionViewArticle()
    {
        $commentContent = '';
        try {
            $page = PageManager::CurrentPage('page');
            if (!isset($_GET["articleId"])) {
                Dialog::Message("您访问的链接不存在！");
                $this->redirect('articleList', array('page' => $page));
                echo FastJSON::encode(0);
                return;
            }

            $article = Articles::model()->findByPk($_GET['articleId']);
            if (empty($article)) {
                Dialog::Message("您要查看的文章不存在，或已被文章作者删除！");
                $this->redirect('articleList', array('page' => $page));
                echo FastJSON::encode(0);
                return;
            }

        } catch (Exception $e) {
            Dialog::Message("网络故障,请稍候重试！");
            Yii::log("系统错误提示：" . $e->getMessage(), 'error');
            $this->redirect('articleList');
        }
        if (isset($_GET['commentContent'])) {
            $commentContent = $_GET['commentContent'];
        }
        $this->render('articleView', array('article' => $article,
            'commentContent' => $commentContent,
            'comments' => Comment::getComments($article->id)));
    }

    /**
     * 删除博文
     */
    public function actionArticleDelete()
    {
        $errorLog = '删除成功！';
        if (isset($_POST['articleId'])) {
            if (!Articles::deleteArticle($_POST['articleId'])) {
                $errorLog = '删除失败！';
            }
        }
        $this->redirect($this->createUrl('articleList', array('errorLog' => $errorLog,
            'page' => PageManager::CurrentPage('page')
        )));
    }

    /**
     * 保存点评
     * @return mixed
     * @throws Exception
     */
    public function actionSaveComment()
    {
        $errorLog = '评论发表成功！';
        try {
            $comment = new Comment();
            if (isset($_POST['comment'])) {
                $comment->attributes = $_POST['comment'];
                if (empty($comment->content)) {
                    throw new Exception("评论内容不能为空！");
                }
                if (isset($_POST['verifyCode'])) {
                    if ($_POST['verifyCode'] != "000") {
                        throw new Exception("验证码错误，请重新输入验证码！");
                    }
                } else {
                    throw new Exception("验证码不能为空，请输入验证码！");
                }
                $comment->publishTime = date("Y-m-d H:m:s");
                if (!$comment->insert()) {
                    throw new Exception("网络故障，评论发表失败请稍候重试");
                }
                Dialog::Message($errorLog);
                $this->redirect($this->createUrl("article/viewArticle", array('articleId' => $comment->articleId)));
                return;
            }
        } catch (Exception $e) {
            $errorLog = $e->getMessage();
        }
        Dialog::Message($errorLog);
        $this->redirect($this->createUrl("article/viewArticle", array('articleId' => $comment->articleId,
            'commentContent' => $comment->content)));
    }

    public function actionSearchArticle()
    {
        try {
            $result = array();
            $result['errorCode'] = 0;
            $keyword = $_POST['keyword'];
            if (empty($keyword)) {
                throw new Exception("请输入搜索关键字");
            }
            $criteria = new CDbCriteria();
            $criteria->addCondition("title like '%" . $keyword . "%'  or
                            content like '%" . $keyword . "%'  or
                            author like '" . $keyword . "%' ");
            $criteria->order = "publishTime,author DESC";
            $articles = Articles::model()->findAll($criteria);
            if (empty($articles)) {
                throw new Exception("非常抱歉，没有您要找的东西！");
            }
            $this->pageTitle = "搜索列表";
            $result['errorCode'] = 1;
            $result['content'] = $this->render('/article/articleList', array('articles' => $articles));
        } catch (Exception $ex) {
            $result['content'] = $ex->getMessage();
        }
        echo FastJSON::encode($result);
    }

}
