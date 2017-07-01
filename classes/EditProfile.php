<?php 
require_once 'lib/session.php';
require_once 'lib/database.php';
require_once 'helpers/format.php';
?>

<?php 

class EditProfile
{
	private $db;
	private $fm;
	function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}

	public function updatePassword($data,$userId){
		$oldPassword =  $_POST['oldPassword'];
		$newPassword =  $_POST['newPassword'];
		$passwordRepeat =  $_POST['passwordRepeat'];

		$newPassword = $this->fm->validation($newPassword);
		$passwordRepeat = $this->fm->validation($passwordRepeat);

		$newPassword = mysqli_real_escape_string($this->db->link,$newPassword);
		$passwordRepeat = mysqli_real_escape_string($this->db->link,$passwordRepeat);

		if (empty($newPassword) || empty($passwordRepeat)) {
				$msg = "<div class='alert alert-danger' role='alert'>New Password or Repeat Password field is required.</div>";
				return $msg;
			}elseif(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/', $newPassword)) {
			$msg =  "<div class='alert alert-danger' role='alert'>The new password does not meet the requirements!(at least one number,one letter,one of the following: !@#$% and there have to be 8-12 characters)</div>";
		   	return $msg;
		}elseif ($newPassword != $passwordRepeat) {
			$msg = "<div class='alert alert-danger' role='alert'>New password and Repeat password does not match.</div>";
			return $msg;
		}else{
			$query = "UPDATE users SET password = '$newPassword' WHERE id = '$userId'";
			$insertRow = $this->db->update($query);
			if ($insertRow) {
				$msg = "<div class='alert alert-success' role='alert'>You have successfully changed your password!!</div>";
				return $msg;
			}
		}	
	}

}

?>