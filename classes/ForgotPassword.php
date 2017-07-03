<?php 
require_once 'lib/session.php';
Session::checkLogin();
require_once 'lib/database.php';
require_once 'helpers/format.php';
require_once 'PHPMailer/PHPMailerAutoload.php';
$mail = new PHPMailer;
?>

<?php 

class ForgotPassword
{
	private $db;
	private $fm;
	function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}


	public function resetUserPassword($email){
		$email = $this->fm->validation($email);
        $email = mysqli_real_escape_string($this->db->link,$email);

        if (empty($email)) {
        	$msg = "<div class='alert alert-danger' role='alert'>Please Enter your email.</div>";
			return $msg;
        }elseif (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
	    	$msg = "<div class='alert alert-danger' role='alert'>Invalid Email Address. Please enter a valid address.</div>";
			return $msg;
        }else{
        	$query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
            $mailchk = $this->db->select($query);
        }

        if ($mailchk!=false) {
        	while ($value = $mailchk->fetch_assoc()) {
              $userid = $value['id'];
              $username = $value['fullName'];
            }
              $text = substr($email, 0,3);
	          $rand = rand(10000,99999);
	          $newpass = "$text$rand";
	          $password = $newpass;

	          $updatequery = "UPDATE users SET password='$password', confirmPassword='$password' WHERE id = '$userid'";
	          $update_row  = $this->db->update($updatequery);

	          $to = '$email';
                                  
	          $from = 'nstu@gmail.com';
	          $headers = "From: $from\n";
	          $headers .= "MIME-Version: 1.0" . "\r\n";
              $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
              $subject = "Your Password";
              $message = "Hello,".$username." Your new password is".$password."Please save it";

              $sendmail = mail($to, $subject, $message, $headers);

              if ($sendmail) {
                $msg = "<div class='alert alert-success' role='alert'>New Password send to your email.Please Check.!.</div>";
			return $msg;

              }else{
                $msg = "<div class='alert alert-success' role='alert'>New Password send to your email.Please Check.!.</div>";
			return $msg;
       
              }
        }else{
        	$msg = "<div class='alert alert-danger' role='alert'>Email address not found.</div>";
			return $msg;
        }
				
			
	}


	
}
?>