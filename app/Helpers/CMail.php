<?php
namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class CMail
{
    public static function send($config) {
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host       = config('services.mail.host');
            $mail->SMTPAuth   = true;
            $mail->Username   = config('services.mail.username');
            $mail->Password   = config('services.mail.password');
            $mail->SMTPSecure = config('services.mail.encryption');
            $mail->Port       = config('services.mail.port');

            //Recipients
            $mail->setFrom(
                $config['from_address'] ?? config('services.mail.from_address'),
                $config['from_name'] ?? config('services.mail.from_name')
            );
            $mail->addAddress($config['recipient_address'], $config['recipient_name'] ?? null);

            //Content
            $mail->isHTML(true);
            $mail->Subject = $config['subject'];
            $mail->Body    = $config['body'];


            if( !$mail->send() ) {
                // echo "전송 실패!<br>";
                return false;
            } else {
                // echo "전송 성공<br>";
                return true;
            }
        } catch (Exception $e) {
            // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}<br>\n";
            return false;
        }
    }
}

