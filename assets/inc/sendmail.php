<?php

require_once('phpmailer/class.phpmailer.php');

$mail = new PHPMailer();  // no $mail->isSMTP() here

$message = "";
$status = "false";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['form_name'] != '' && $_POST['form_email'] != '' && $_POST['form_subject'] != '') {

        $name = $_POST['form_name'];
        $email = $_POST['form_email'];
        $subject = $_POST['form_subject'];
        $phone = $_POST['form_phone'];
        $msg = $_POST['form_message'];

        $botcheck = $_POST['form_botcheck'];

        $toemail = 'wearvetx@gmail.com'; // <-- your email
        $toname = 'V TEX';

        if ($botcheck == '') {
            $mail->SetFrom($email, $name);
            $mail->AddReplyTo($email, $name);
            $mail->AddAddress($toemail, $toname);
            $mail->Subject = $subject;

            $body = "Name: $name<br><br>Email: $email<br><br>Phone: $phone<br><br>Message:<br>$msg";
            $mail->MsgHTML($body);

            if ($mail->Send()) {
                $message = 'We have <strong>successfully</strong> received your Message and will get Back to you soon.';
                $status = "true";
            } else {
                $message = 'Email <strong>could not</strong> be sent. Reason:<br>' . $mail->ErrorInfo;
                $status = "false";
            }
        } else {
            $message = 'Bot Detected.';
            $status = "false";
        }

    } else {
        $message = 'Please fill in all required fields.';
        $status = "false";
    }
} else {
    $message = 'Unexpected error occurred. Try again later.';
    $status = "false";
}

echo json_encode(['message' => $message, 'status' => $status]);
?>
