<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 20/8/2018
 * Time: 11:02 AM
 */

use PHPMailer\PHPMailer\PHPMailer;
require APPPATH . 'third_party/phpmailer/src/PHPMailer.php';
require APPPATH . 'third_party/phpmailer/src/SMTP.php';
require APPPATH . 'third_party/phpmailer/src/Exception.php';

class My_phpmailer
{
    public function send_mail($email_to, $email_to_name, $subject, $body, $is_html=false, $attachmentPath=NULL)
    {

        $mail = new PHPMailer;

        $mail->isSMTP();

        // $mail -> Host = 'localhost' ;

        // $mail -> SMTPAuth = false ;

        // $mail -> SMTPAutoTLS = false ; 

        // $mail -> Cổng = 25 ;

        $mail->SMTPDebug = config_item('sys_sender_email_debug');

        $mail->Host = 'smtp.gmail.com';

        $mail->Port = 587;

        $mail->SMTPSecure = 'tls';

        $mail->SMTPAuth = true;

        $mail->Username = config_item('sys_sender_email');

        $mail->Password = config_item('sys_sender_email_pass');

        $mail->setFrom(config_item('sys_sender_email'), config_item('system_mail_name'));

        //$mail->addReplyTo('replyto@mynkcms.com', 'MynkCMS Reply');
        $mail->addAddress($email_to, $email_to_name);
        $mail->Subject = $subject;
        if ($is_html)
            $mail->msgHTML($body);
        else
            $mail->AltBody = $body;

        if ($attachmentPath)
            $mail->addAttachment($attachmentPath);
        if (!$mail->send()) {
            // echo "Mailer Error: " . $mail->ErrorInfo;
            return false;
        } else {
            return true;
        }
    }

    public function send_mail_test()
    {
        //Create a new PHPMailer instance
        $mail = new PHPMailer;

//Tell PHPMailer to use SMTP
        $mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
        $mail->SMTPDebug = 2;

//Set the hostname of the mail server
        $mail->Host = 'smtp.gmail.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $mail->Port = 587;

//Set the encryption system to use - ssl (deprecated) or tls
        $mail->SMTPSecure = 'tls';

//Whether to use SMTP authentication
        $mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
        $mail->Username = "vuminhndvn@gmail.com";

//Password to use for SMTP authentication
        $mail->Password = "Canhh0adau";

//Set who the message is to be sent from
        $mail->setFrom('vuminhndvn@gmail.com', 'MynkCMS');

//Set an alternative reply-to address
        $mail->addReplyTo('replyto@mynkcms.com', 'MynkCMS Reply');

//Set who the message is to be sent to
        $mail->addAddress('tuanviet9791@gmail.com', 'Tuấn Việt');

//Set the subject line
        $mail->Subject = 'PHPMailer GMail SMTP test';

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
        $mail->msgHTML(file_get_contents(APPPATH . 'third_party/phpmailer/examples/contents.html'), __DIR__);

//Replace the plain text body with one created manually
        $mail->AltBody = 'This is a plain-text message body';

//Attach an image file
        $mail->addAttachment(APPPATH . 'third_party/phpmailer/examples/images/phpmailer_mini.png');

//send the message, check for errors
        if (!$mail->send()) {
            //echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message sent!";
            //Section 2: IMAP
            //Uncomment these to save your message in the 'Sent Mail' folder.
            #if (save_mail($mail)) {
            #    echo "Message saved!";
            #}
        }
    }

//Section 2: IMAP
//IMAP commands requires the PHP IMAP Extension, found at: https://php.net/manual/en/imap.setup.php
//Function to call which uses the PHP imap_*() functions to save messages: https://php.net/manual/en/book.imap.php
//You can use imap_getmailboxes($imapStream, '/imap/ssl') to get a list of available folders or labels, this can
//be useful if you are trying to get this working on a non-Gmail IMAP server.
    public function save_mail($mail)
    {
        //You can change 'Sent Mail' to any other folder or tag
        $path = "{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail";

        //Tell your server to open an IMAP connection using the same username and password as you used for SMTP
        $imapStream = imap_open($path, $mail->Username, $mail->Password);

        $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
        imap_close($imapStream);

        return $result;
    }


}