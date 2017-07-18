<?php 
require_once 'lib/session.php';
Session::checkLogin();
require_once 'lib/database.php';
require_once 'helpers/format.php';
?>

<?php 

class User
{
	private $db;
	private $fm;
	function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}


	public function userRegistration($data){

			$fullname = $_POST['fullname'];
			$username = $_POST['username'];
			$email = $_POST['email'];
			$password =  $_POST['password'];
			$confirmPassword = $_POST['confirmPassword'];

			$fullname = $this->fm->validation($fullname);
			$username = $this->fm->validation($username);
			$email = $this->fm->validation($email);
			$password = $this->fm->validation($password);
			$confirmPassword = $this->fm->validation($confirmPassword);

			$fullname = mysqli_real_escape_string($this->db->link,$fullname);
			$username = mysqli_real_escape_string($this->db->link,$username);
			$email = mysqli_real_escape_string($this->db->link,$email);
			$password = mysqli_real_escape_string($this->db->link,$password);
			$confirmPassword = mysqli_real_escape_string($this->db->link,$confirmPassword);

			if (empty($fullname) || empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
				$msg = "<div class='alert alert-danger' role='alert'>All fields are required.</div>";
				return $msg;
			}

			if (!preg_match("#^[-A-Za-z' ]*$#",$fullname))
				{
					$msg = "<div class='alert alert-danger' role='alert'>Your full name may contain only letters from a to z.</div>";
					return $msg;
				}

			if (!preg_match('/^[a-z0-9]{6,10}$/', $username))
				{
					$msg = "<div class='alert alert-danger' role='alert'>Your Username must have Numbers from 0 - 9,No capital letters,no special symbols at all,min of 6 characters,max of 10 characters.</div>";
					return $msg;
				}


			if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^",$email))
				{ 
					$msg = "<div class='alert alert-danger' role='alert'>Invalid Email Address. Please enter a valid address.</div>";
					return $msg;
				}
				if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/', $password)) {
					   $msg =  "<div class='alert alert-danger' role='alert'>The password does not meet the requirements!(at least one number,one letter,one of the following: !@#$% and there have to be 8-12 characters)</div>";
					   return $msg;
					}
					

			$userQuery = "SELECT username FROM users WHERE username = '$username'";
			$userChk = $this->db->select($userQuery);

		if ($userChk==true) {
			$msg = "<div class='alert alert-danger' role='alert'>Username Already in Used.</div>";
			return $msg;
		}

			$query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
			$mailchk = $this->db->select($query);
			
		if ($mailchk==true) {
			$msg = "<div class='alert alert-danger' role='alert'>Email Already in Used.</div>";
			return $msg;
		}elseif ($password != $confirmPassword) {
			$msg = "<div class='alert alert-danger' role='alert'>Password does not match.</div>";
			return $msg;
		}else{

			$query = "INSERT INTO users (fullname,username,email,password,confirmPassword) VALUES ('$fullname','$username','$email','$password','$confirmPassword')";
			$insertRow = $this->db->insert($query);
			if ($insertRow) {
				$msg = "<div class='alert alert-success' role='alert'>Congratulations ! You successfully registered.</div>";
				return $msg;
			}else{
				$msg = "<div class='alert alert-danger' role='alert'>Something Went Wromg!!</div>";
				return $msg;
			}
 	}
}

public function getUserInformation($userNameId){
	$query = "SELECT * FROM users WHERE id = '$userNameId'";
	$result = $this->db->select($query);
	return $result;
}

}

?>