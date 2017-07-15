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

		$oldPassword = $this->fm->validation($oldPassword);
		$newPassword = $this->fm->validation($newPassword);
		$passwordRepeat = $this->fm->validation($passwordRepeat);

		$oldPassword = mysqli_real_escape_string($this->db->link,$oldPassword);
		$newPassword = mysqli_real_escape_string($this->db->link,$newPassword);
		$passwordRepeat = mysqli_real_escape_string($this->db->link,$passwordRepeat);

		$query = "SELECT password FROM users WHERE id = '$userId'";
		$result = $this->db->select($query);
		if ($result) {
			while ($val = $result->fetch_assoc()) {
				$oldPass = $val['password'];
			}
		}
		if ($oldPass!=$oldPassword) {
			$msg = "<div class='alert alert-danger' role='alert'>Your entered password is not matched to your old password.</div>";
			return $msg;
		}
		elseif (empty($oldPassword)) {
			$msg = "<div class='alert alert-danger' role='alert'>Old Password  field is required.</div>";
				return $msg;
		}
		
		elseif (empty($newPassword) || empty($passwordRepeat)) {
				$msg = "<div class='alert alert-danger' role='alert'>New Password or Repeat Password field is required.</div>";
				return $msg;
			}elseif(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/', $newPassword)) {
			$msg =  "<div class='alert alert-danger' role='alert'>The new password does not meet the requirements!(at least one number,one letter,one of the following: !@#$% and there have to be 8-12 characters)</div>";
		   	return $msg;
		}elseif ($newPassword != $passwordRepeat) {
			$msg = "<div class='alert alert-danger' role='alert'>New password and Repeat password does not match.</div>";
			return $msg;
		}else{
			$query = "UPDATE users SET password = '$newPassword',confirmPassword = '$passwordRepeat' WHERE id = '$userId'";
			$insertRow = $this->db->update($query);
			if ($insertRow) {
				$msg = "<div class='alert alert-success' role='alert'>You have successfully changed your password!!</div>";
				return $msg;
			}
		}	
	}

	public function changeAvatar($file,$userId){

		$permited  = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['avatar']['name'];
        $file_size = $_FILES['avatar']['size'];
        $file_temp = $_FILES['avatar']['tmp_name'];

        $div = explode('.', $file_name);
	    $file_ext = strtolower(end($div));
	    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
	    $uploaded_image = "Avatars/".$unique_image;

	    if (empty($file_name)) {
      		 $msg = "<div class='alert alert-danger' role='alert'>Please choose an image first for your Cover.</div>";
				return $msg;;
      }elseif ($file_size >10240000) {
       		$msg = "<div class='alert alert-danger' role='alert'>Image Size should be 10MB or less then 10MB!</div>";
				return $msg;
      } elseif (in_array($file_ext, $permited) === false) {
      		$msg = "<div class='alert alert-danger' role='alert'>You can upload only JPG,JPEG,PNG or GIF file!</div>";
				return $msg;
      } else{
      move_uploaded_file($file_temp, $uploaded_image);
      $query = "UPDATE users set avatar = '$uploaded_image' WHERE id= '$userId'";
      $update_rows = $this->db->update($query);
      if ($update_rows) {
       		$msg = "<div class='alert alert-success' role='alert'>You have successfully Changed Cover!!</div>";
				return $msg;

      }else {
   			$msg = "<div class='alert alert-danger' role='alert'>Something Went wrong.Please choose image properly!!</div>";
			return $msg;

     }   
     }

	}

	public function getProfileImage($userId){
		$query = "SELECT avatar FROM users WHERE id = '$userId'";
		$result = $this->db->select($query);
		return $result;
	}

	public function changeCover($file,$userId){
		$permited  = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['cover']['name'];
        $file_size = $_FILES['cover']['size'];
        $file_temp = $_FILES['cover']['tmp_name'];


      $div = explode('.', $file_name);
      $file_ext = strtolower(end($div));
      $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
      $uploaded_image = "CoverImages/".$unique_image;

      if (empty($file_name)) {
      		 $msg = "<div class='alert alert-danger' role='alert'>Please choose an image first for your Cover.</div>";
				return $msg;;
      }elseif ($file_size >10240000) {
       		$msg = "<div class='alert alert-danger' role='alert'>Image Size should be 10MB or less then 10MB!</div>";
				return $msg;
      } elseif (in_array($file_ext, $permited) === false) {
      		$msg = "<div class='alert alert-danger' role='alert'>You can upload only JPG,JPEG,PNG or GIF file!</div>";
				return $msg;
      } else{
      move_uploaded_file($file_temp, $uploaded_image);
      $query = "UPDATE users set cover = '$uploaded_image' WHERE id= '$userId'";
      $update_rows = $this->db->update($query);
      if ($update_rows) {
       		$msg = "<div class='alert alert-success' role='alert'>You have successfully Changed Cover!!</div>";
				return $msg;

      }else {
   			$msg = "<div class='alert alert-danger' role='alert'>Something Went wrong.Please choose image properly!!</div>";
			return $msg;

     }   
     }
	}

	public function getCoverImage($userId){
		$query = "SELECT cover FROM users WHERE id = '$userId'";
		$result = $this->db->select($query);
		return $result;
	}

}

?>