<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';

class EmailHelper {
    public static function sendOrderConfirmation($toEmail, $toName, $subject, $bodyHtml) {
        $mail = new PHPMailer(true);
        try {
            // Server config
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // dùng Gmail
            $mail->SMTPAuth = true;
            $mail->Username = 'your_email@gmail.com'; // 🔁 thay bằng email của bạn
            $mail->Password = 'your_app_password'; // 🔁 dùng App Password (không phải mật khẩu Gmail)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Người gửi
            $mail->setFrom('your_email@gmail.com', 'ShopeeFood');

            // Người nhận
            $mail->addAddress($toEmail, $toName);

            // Nội dung
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $bodyHtml;

            $mail->send();
        } catch (Exception $e) {
            error_log("Email error: {$mail->ErrorInfo}");
        }
    }
}
