<?php

namespace App\Models;

class Mailer {
    static function sendEmail($to, $codeOtp, $link, $subject = "Verification Code")
    {
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        try {
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'cryanfajri1540@gmail.com';                     //SMTP username
            $mail->Password   = 'paksi12345';                               //SMTP password
            $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            //Recipients
            $mail->setFrom('cryanfajr1540@gmail.com', 'Cryan Fajri');
            $mail->addAddress($to);        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = '
            <div style="font-family:poppins;text-align:center;">
                <h1>Reset your password</h1>
                    <div style="border: 1px solid #000; border-radius:0.751rem; width: 75%; margin: auto; padding: 1rem;">
                        <h2 style="text-align:left; font-weight: 500;">Every bit of joy counts as we each do our part to prevent the spread of COVID-19. So our team is working hard at home to find ways to make your time indoors (and ours!) fly by.</h2>
                        <h2 style="text-align:left; font-weight: 500;">Stay safe,</h2>
                        <h2 style="text-align:left; font-weight: 500;">Cryan Fajri</h2>
                        <h3 style="text-align:left;">This is your OTP-CODE</h3>
                        <h3 style="text-align:left;">'.$codeOtp.'</h3>
                    </div>
            </div>
            ';
            $mail->send();
            return 'Message has been sent';
        } catch (PHPMailer\PHPMailer\Exception $e) {
            return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}

?>