<?php
	if(isset($_POST['Reset'])){
		$host = "ogeechee-fair.cyxvjubgt7cw.us-east-1.rds.amazonaws.com";
		$user ="fair_admin";
		$passwordAdmin = "KiwanisClub";
		$db = "applications";
		$con = new mysqli($host, $user, $passwordAdmin, $db);
		session_start();
		
		$email = $con->escape_string($_POST['Email']);
		
		$sql = "SELECT * FROM applications.users WHERE email = '".$email."'";
		$result = $con->query($sql);
		
		if( $result->num_rows ==0){
		    echo '<script>alert("User with that email does not exist!");window.location.href="/views/forgot.php";</script>';
		}
		else{
			echo $sql;
			$user = $result->fetch_assoc();
			$email = $user['email'];
			$hash = $user['hash'];
			$first_name = $user['First_Name'];

		
			//$_SESSION['message'] = "<p> Please check your email <span>$email</span>"
			//."for a confirmation link to complete your password reset!<p>";
		
			$to = $email;
			$subject = 'Password Reset Link (Ogeechee Fair App)';
			$message_body = "
			You have reuqested a password reset!
			Please Click this link to reset your password:
			https://fathomless-citadel-34360.herokuapp.com/views/reset.php?email='".$email."'&hash='".$hash."'";
			$headers = "Ogeechee Fair";
		
			//$mail = mail($to,$subject,$message_body,$headers);
			$mail = new PHPMailer();

            //settings
			$mail->IsSMTP();
			$mail->CharSet = 'UTF-8';
			$mail->Host = 'smtp.sendgrid.net'; //SMTP server
			$mail->SMTPDebug = 0;
			$mail->SMTPAUth = true;
			$mail->Port = 25;
			$mail->Username = 'apikey';
			$mail->Password = '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';

			//Content
			$mail->isHTML(true);
			$mail->addAddress($email, '');
			$mail->Subject = $subject;
			$mail->Body = $message_body;
			$mail->

			$mail->send();

			//if($mail){
			//    echo '<script>alert("Email has been sent to that account.");window.location.href="/views/login.php";</script>';
				//$_SESSION['message'] = "Your Password Reset Link has been sent to this email!";
				//header("location: /views/login.php");
			//}
			//else{
			 //   echo '<script>alert("Email failed to send.");window.location.href="/views/forgot.php";</script>';
			//}
		}	
	}
?>