<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	
	class Notification {

		public $mail;

		public function __construct() {
			$mail = new PHPMailer(true);
			
		    $mail->isSMTP();
		    $mail->Host = 'smtp.gmail.com';
		    $mail->SMTPAuth = true; 
		    $mail->Username = Config::get("email"); 
		    $mail->Password = Config::get("email_password");
		    $mail->SMTPSecure = 'tls';
		    $mail->Port = 587;
			if(Config::get("debug")) $mail->SMTPDebug = 2;

			if(Config::get("disable_ssl")) {
				$mail->SMTPOptions = array(
	                'ssl' => array(
	                    'verify_peer' => false,
	                    'verify_peer_name' => false,
	                    'allow_self_signed' => true
	                )
	            );
			}

		    $this->mail = $mail;
			
		}

		public function getMail() {
			return $this->mail;
		}

		public static function sendNotification($subject, $body) {
			try {

				$notification = new Notification();
				$mail = $notification->getMail();

			    //Recipients
			    $mail->setFrom(Config::get("email"), Config::get("from_email_name"));

			    // $mail->addAddress(Config::get("to_email"));
			    $mail->addAddress(Config::get("to_phone"));
			    //$mail->addReplyTo('bla@bla.com', 'Sweet');
			    //$mail->addCC('cc@cool');
			    //$mail->addBCC('bcc@cool');

			    //$mail->addAttachment('file_path', 'name');

			    $mail->isHTML(true); 
			    $mail->Subject = $subject;
			    $mail->Body    = $body;

			    $mail->send();
			    echo 'Message has been sent';
			}
			catch (Exception $e) {
				if(Config::get("debug")) dd($e);
				else {
					throw $e;
				}
			}
		}

	}

?>