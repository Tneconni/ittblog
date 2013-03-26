<?php
class MailManager
{
    public function factory()
    {
        static $obj;

        if (!$obj)
            $obj = new MailManager();

        return $obj;
    }
    /**
     * @param  $to  表示收件人地址
     * @param  $toName 表示收件人姓名
     * @param string $subject 表示邮件标题
     * @param string $body 表示邮件正文
     * @return bool
     */
    public function ztPostMail($to, $toName, $subject, $body)
    {
        try
        {
            error_reporting(E_STRICT);
            date_default_timezone_set("Asia/Shanghai"); //设定时区东八区
            require_once('PHPMailer/class.phpmailer.php');
            include("PHPMailer/class.smtp.php");
            $mail = new PHPMailer();
            $body = eregi_replace("[\]", '', $body); //对邮件内容进行必要的过滤
            $mail->CharSet = "UTF-8"; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
            $mail->IsSMTP(); // 设定使用SMTP服务
            $mail->SMTPDebug = 1; // 启用SMTP调试功能
            // 1 = errors and messages
            // 2 = messages only
            $mail->SMTPAuth = true; // 启用 SMTP 验证功能
            $mail->SMTPSecure = "ssl"; // 安全协议
            $mail->Host = "smtp.exmail.qq.com"; // SMTP 服务器
            $mail->Port = 465; // SMTP服务器的端口号
            $mail->Username = "nacky.long@foxmail.com"; // SMTP服务器用户名
            $mail->Password = "9150027198/*lrx"; // SMTP服务器密码
            $mail->SetFrom('nacky.long@foxmail.com', '空山幽泉-ITTBlog');
            $mail->AddReplyTo('nacky.long@foxmail.com', '空山幽泉-ITTBlog');
            $mail->Subject = $subject;
            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
            $mail->MsgHTML($body);
            $address = $to;
            $mail->AddAddress($address, $toName);
            //$mail->AddAttachment("images/phpmailer.gif");      // attachment
            //$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment
            if (!$mail->Send()) {
                Yii::log("Mailer Error: " . $mail->ErrorInfo, 'error');
                return false;
            } else {
                return true;
            }
        } catch (phpmailerException $e)
        {
            Yii::log("Mailer Error: " . $e->getMessage(), 'error');
            return false;
        }
    }
}

?>
