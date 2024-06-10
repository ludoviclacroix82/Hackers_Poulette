<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require './assets/vendor/PHPMailer/src/Exception.php';
require './assets/vendor/PHPMailer/src/PHPMailer.php';
require './assets/vendor/PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    session_start();
    $error = 0;

    //récuperation des data Post
    $gender = htmlspecialchars(trim($_POST['gender']));
    $genderSend = ($gender === 'noreply')?'':$gender; // Si le user n'a pas voulu mettre son genre 

    $gender = isset($_POST['gender']) ? htmlspecialchars(trim($_POST['gender'])) : '';
    $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
    $lastName = isset($_POST['lastName']) ? htmlspecialchars(trim($_POST['lastName'])) : '';
    $email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : '';
    $country = isset($_POST['country']) ? htmlspecialchars(trim($_POST['country'])) : '';
    $subject = isset($_POST['subject']) ? htmlspecialchars(trim($_POST['subject'])) : '';
    $message = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : '';

    $_SESSION['gender'] = $gender;
    $_SESSION['name'] = $name;
    $_SESSION['lastName'] = $lastName;
    $_SESSION['email'] = $email;
    $_SESSION['country'] = $country;
    $_SESSION['subject'] = $subject;
    $_SESSION['message'] = $message;


    $error += checkEmail($email);
    $error += issetInput($gender, 'gender', 'errorGender', 'Please note that the Gender field is mandatory.');
    $error += issetInput($name, 'name', 'errorName', 'Please note that the Name field is mandatory.');
    $error += issetInput($lastName, 'lastName', 'errorLastName', 'Please note that the last name field is mandatory.');
    $error += issetInput($country, 'country', 'errorCountry', 'Please note that the Country field is mandatory.');
    $error += issetInput($message, 'message', 'errorMessage', 'Please note that the Message field is mandatory.');
    $error += issetInput($subject, 'subject', 'errorSubject', 'Please note that the Subject field is mandatory.');



    if ($error === 0) {
        // Initialisation de l'objet PHPMailer
        $mail = new PHPMailer(true);
        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();
            $mail->Host = 'smtp.office365.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'lac_ludo@hotmail.com';
            $mail->Password = '';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Destinataires
            $mail->setFrom('lac_ludo@hotmail.com', 'support Hackeur Poulettes');
            $mail->addAddress('lac_ludo@hotmail.com', 'support Hackeur Poulettes');
            $mail->addAddress($email, $name .' ' .$lastName);


            // Contenu de l'email
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $genderSend.' '.$name . ' ' . $lastName . ' from:' . $country . '<br><br>' . $message;

            $mail->send();
            $_SESSION['sendMail'] = true;
            header("Location: index.php");
        } catch (Exception $e) {
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            $_SESSION['sendMail'] = false;
            header("Location: index.php");
        }
    } else {
        header("Location: index.php");
    }
} else {
    header("Location: index.php");
    exit();
}

function checkEmail(string $email)
{
    //verification d'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['errorEmail'] = 'The email is not valid.';
        return 1;
    } else {
        $_SESSION['errorEmail'] = '';
    }
}

function issetInput(string $input, string $session, string $errorSession, string $errorMessage)
{
    if (empty($input)) {
        $_SESSION[$errorSession] = $errorMessage;
        return 1;
    } else {
        $_SESSION[$errorSession] = '';
    }
}
?>