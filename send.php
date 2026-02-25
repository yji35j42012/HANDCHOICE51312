<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 引入 PHPMailer 類別
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

$firstname = $_POST['firstname'] ?? '';
$lastname  = $_POST['lastname'] ?? '';
$email     = $_POST['email'] ?? '';
$phone     = $_POST['phone'] ?? '';
$country   = $_POST['country'] ?? '';
$company   = $_POST['company'] ?? '';
$message   = $_POST['message'] ?? '';

// 郵件內容
$body = '
<html>
<body style="margin:0;padding:0;background-color:#f4f6f8;font-family:Arial,Helvetica,sans-serif;">
  <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f8;padding:20px;">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:8px;overflow:hidden;">
          
          <!-- Header -->
          <tr>
            <td style="background:#222;color:#ffffff;padding:20px;">
              <h2 style="margin:0;font-size:20px;">【Contact Us】</h2>
              <p style="margin:5px 0 0;font-size:13px;color:#cccccc;">
                handchoice51312.com
              </p>
            </td>
          </tr>

          <!-- Content -->
          <tr>
            <td style="padding:20px;">
              <table width="100%" cellpadding="0" cellspacing="0" style="font-size:14px;color:#333;">
                
                <tr>
                  <td style="padding:8px 0;font-weight:bold;width:150px;">First Name</td>
                  <td style="padding:8px 0;">' . htmlspecialchars($firstname) . '</td>
                </tr>

                <tr>
                  <td style="padding:8px 0;font-weight:bold;">Last Name</td>
                  <td style="padding:8px 0;">' . htmlspecialchars($lastname) . '</td>
                </tr>

                <tr>
                  <td style="padding:8px 0;font-weight:bold;">Email</td>
                  <td style="padding:8px 0;">' . htmlspecialchars($email) . '</td>
                </tr>

                <tr>
                  <td style="padding:8px 0;font-weight:bold;">Phone Number</td>
                  <td style="padding:8px 0;">' . htmlspecialchars($phone) . '</td>
                </tr>

                <tr>
                  <td style="padding:8px 0;font-weight:bold;">Country</td>
                  <td style="padding:8px 0;">' . htmlspecialchars($country) . '</td>
                </tr>

                <tr>
                  <td style="padding:8px 0;font-weight:bold;">Company name</td>
                  <td style="padding:8px 0;">' . htmlspecialchars($company) . '</td>
                </tr>
              </table>

              <!-- Message box -->
              <div style="margin-top:20px;">
                <p style="font-weight:bold;margin-bottom:8px;">Message</p>
                <div style="background:#f4f6f8;border-radius:6px;padding:15px;line-height:1.6;">
                  ' . nl2br(htmlspecialchars($message)) . '
                </div>
              </div>

            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="background:#f0f0f0;padding:15px;font-size:12px;color:#777;text-align:center;">
              This email was sent from handchoice51312.com contact form.
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>
</body>
</html>
';

// 目標信箱陣列
$recipients = [
    'iopiop0806@gmail.com'
];

// 郵件主題
$subject = '【Contact Us】';
$mail = new PHPMailer(true);


try {
    // 使用 PHP mail() 函式，不用 SMTP
    $mail->isMail();
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';

    // 設定寄件者（網域的信箱）
    $mail->setFrom('service@handchoice51312.com', 'handchoice51312.com');

     // 將陣列內每個收件人加入
    foreach ($recipients as $to) {
        $mail->addAddress($to);
    }

    $mail->addReplyTo($email);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $body;

    $mail->send();

    echo json_encode([
        'data' => [
            'status' => true,
            'received' => "Mailer OK"
        ]
    ]);
} catch (Exception $e) {
    echo json_encode([
        'data' => [
            'status' => false,
            'error' => "Mailer Error: {$mail->ErrorInfo}"
        ]
    ]);
}
