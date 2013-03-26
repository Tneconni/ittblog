<?php
Yii::import('application.components.*');
class SiteController extends Controller
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
                'transparent' => true,
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
     * 这是处理外部异常的动作。比如访问不存在的页面会发生错误，就会执行下面的动作。
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * 显示《联系》页（此动作具有双重功能，一是渲染一个功能，二是接收用户提交的联系信息）
     */
    public function actionContact()
    {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) //如果该数组（$_POST['ContactForm']是数组名，是二维数组）不为空，则接收表单。
        {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $headers = "From: {$model->email}\r\nReply-To: {$model->email}"; //下面的函数需要本机安装收发邮件功能.否则会出错。
                mail(Yii::app()->params['adminEmail'], $model->subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', '感谢您联系我们，我们将尽快和您取得联系！');
                $this->refresh(); //当用户刷新时去掉提示，而不是重复提交。
            }
        }
        $this->render('contact', array('model' => $model)); //用户尚未提交，直接渲染表单。
    }

    /**
     * 显示登录页（此动作也具有双重功能，一是显示表单，二是接收用户数据）
     * @return mixed
     * @throws Exception
     */
    public function actionLogin()
    {

        try {
            $errorLog = '';
            $currentUrl='index';
            if(isset($_GET["currentUrl"])){
                $currentUrl=$_GET["currentUrl"];
            }
            $form = new LoginForm();

            if (isset($_POST['loginForm'])) {
                $form->attributes = $_POST['loginForm'];
                if (empty($form->account) || empty($form->password)) {
                    throw new Exception('登录名和登录密码不能为空！');
                }
                $form->authenticate(); //对用户进行验证
                Users::updateLastLoginTimeAndIp(Yii::app()->user->id); // 更新最后登陆时间
                $this->redirect($currentUrl);
                return;
            }
        } catch (Exception $ex) {
            $errorLog = $ex->getMessage();
        }
        unset($form->password);
        $this->pageTitle = "请登录";
        if(isset($_POST['pop'])&&$_POST['pop']==1){
         echo FastJSON::encode($this->renderPartial('login', array('form' => $form, 'errorLog' => $errorLog,'pop'=>1), true));
         return;
        }
        $this->render('login', array('form' => $form, 'errorLog' => $errorLog));
    }

    /**
     * 注销当前用户，并重定向到首页。
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect('index');
    }

    /**
     * 新用户注册
     * @return bool
     * @throws Exception
     */
    public function actionReg()
    {
        try {
            $errorLog = '';
            $reg = new RegForm();
            if (isset($_POST['reg'])) {
                $reg->attributes = $_POST['reg'];
                if ($reg->verifyCode != '000') {
                    throw new Exception("输入的验证码错误！");
                }
                if (empty($reg->email)) {
                    throw new Exception("电子邮件不能为空！");
                }
                if (empty($reg->alias)) {
                    throw new Exception("用户帐号不能为空");
                }
                if (empty($reg->password)) {
                    throw new Exception("用户密码不能为空");
                }
                if (Users::checkEmail($reg->email)) {
                    throw new Exception("您输入的电子邮件已经存在，请重新输入！");
                }
                if (Users::checkAlias($reg->alias)) {
                    throw new Exception("您输入的登录帐号已经存在，请重新输入！");
                }
                if (empty($reg->password)) {
                    throw new Exception("登录密码不能为空！");
                }
                if ($reg->password != $reg->confirm) {
                    throw new Exception("两次输入密码不一致！");
                }
                $user = new Users();
                $user->alias = $reg->alias;
                $user->aliasFirstPY = PinYinGenerator::FirstPinYin($reg->alias);
                $user->email = $reg->email;
                $user->registerTime = date('Y-m-d H:i:s');
                $user->password = md5($reg->password);
                $user->userAccount = $user->getNewAccount();
                if (Users::saveUser($user)) {
                    $this->redirect(Yii::app()->createUrl('site/login'));
                    $this->refresh(); //当用户刷新时去掉提示，而不是重复提交。
                    return true;
                } else {
                    throw new Exception("注册失败，请重试！");
                }
            }
        } catch (Exception $ex) {
            $errorLog = $ex->getMessage();
        }
        if(isset($_POST['pop'])&&$_POST['pop']==1){
            echo FastJSON::encode($this->renderPartial('reg', array('reg' => $reg, 'errorLog' => $errorLog,),true));
            return;
        }
        $this->render('reg', array('reg' => $reg, 'errorLog' => $errorLog));
    }

    /**
     * 首页展示
     */
    public function actionIndex()
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition("status=1");
        $criteria->order = "publishTime DESC";
        $articles = Articles::model()->findAll($criteria);
        $this->render('index', array('articles' => $articles));
    }


    public function actionAbout()
    {
        $about = "Hello!这是我的iTTBlog介绍页面！";
        $this->render('about', array('about' => $about));
    }

    /**
     * 帮助
     */
    public function actionHelp()
    {
        $help = "Hello!这是我的iTTBloghelp页面！";
        $user=new Users();
        $this->render('help', array('help' => $help,'user'=>$user));
    }

    /**
     * 用户找回密码
     * @return bool
     */
    public function actionLostPassword()
    {
        $this->pageTitle = '找回密码';
        $Msg = '';
        if (isset($_POST['email'])) {
            $email = $_POST['email'];

            $user = User::model()->findByAttributes(array('email' => $email));
            if (count($user) > 0) {
                //重置密码
                $password = Users::GenerateNewPassword();
                $user->password = md5($password);
                if ($user->update()) {
                    $title = '空山幽泉-iTTBlog：您的密码已经重置成功';
                    $content = '尊敬的客户：<br />您重置后的密码为：' . $password . ',请尝试重新登陆，如有问题请与我们联系。<br />';
                    if (!MailManager::factory()->ztPostMail($email, $user->userName, $title, $content)) {
                        $Msg = '重置密码失败，请稍后重试！';
                    }
                    else
                    {
                        $Msg .= '重置密码邮件发送成功，请登录邮箱查看!';
                    }
                }
                else
                {
                    $Msg .= '重置密码失败，请稍后重试！';
                }
            }
            else
            {
                $Msg .= '您输入的邮箱不正确，请重新输入！';
            }
        }
        $this->render('lostPassword', array('Msg' => $Msg));
        return true;
    }
}