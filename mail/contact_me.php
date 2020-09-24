<?php

error_reporting(-1);
ini_set('display_errors', 'On');
require_once "Mail.php";
require_once "Mail/mime.php";


// Check for empty fields
if (empty($_POST['name']) ||
    empty($_POST['email']) ||
    empty($_POST['subject']) ||
    empty($_POST['message']) ||
    !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    echo "No arguments Provided!";
    return false;
}

$name = strip_tags(htmlspecialchars($_POST['name']));
$email_address = strip_tags(htmlspecialchars($_POST['email']));
$subject = strip_tags(htmlspecialchars($_POST['subject']));
$message = strip_tags(htmlspecialchars($_POST['message']));



// Create the email and send the message
$to = 'gaeperez@uvigo.es';
$email_subject = "SINGulator Website Contact Form:  $name - " + $subject;
$email_body = "You have received a new message from SINGulator website contact form.\n\n" . "Here are the details:\n\nName: $name\n\nEmail: $email_address\n\n \nMessage:\n$message";


$headers = array(
      'From' => $email_address,
      'To' => $to,
      'Subject' => $email_subject
);

$smtp = Mail::factory('smtp', array(
          'host' => 'ssl://smtp.gmail.com',
          'port' => '465',
          'auth' => true,
          'username' => '',
          'password' => ''
    ));

$mail = $smtp->send($to, $headers, $email_body);

if (PEAR::isError($mail)) {
    echo('<p>' . $mail->getMessage() . '</p>');
} else {
    echo('<p>Message successfully sent!</p>');
}

return true;
?>


