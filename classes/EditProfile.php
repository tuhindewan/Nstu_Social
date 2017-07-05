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

	public function changeAvatar($file,$userId){

		if (empty($_FILES['avatar']['name'])) {
                $msg = "<div class='alert alert-danger' role='alert'>Please choose an image first for your Avatar.</div>";
				return $msg;
        }
        $permited  = array('jpg', 'jpeg', 'png', 'gif');
        $div = explode('.', $_FILES['avatar']['name']);
        $file_ext = strtolower(end($div));

        if (in_array($file_ext, $permited) === false) {
          $msg = "<div class='alert alert-danger' role='alert'>You can upload only JPG,JPEG,PNG or GIF file!</div>";
				return $msg;
          }
		  $image = base64_encode(file_get_contents($_FILES['avatar']['tmp_name']));
          $options = array('http'=>array(
                  'method'=>"POST",
                  'header'=>"Authorization: Bearer 52a3c0e5a21348520610dfe36d3f6fd8a23c2ce5\n".
                  "Content-Type: application/x-www-form-urlencoded",
                  'content'=>$image
          ));
          $context = stream_context_create($options);
          $imgurURL = "https://api.imgur.com/3/image";
          

          if (empty($_FILES['avatar']['name'])) {
                $msg = "<div class='alert alert-danger' role='alert'>Please choose an image first for your Avatar.</div>";
				return $msg;
        }
        if ($_FILES['avatar']['size'] > 10240000) {
                $msg = "<div class='alert alert-danger' role='alert'>Image Size should be 10MB or less then 10MB!</div>";
				return $msg;
        }

        $permited  = array('jpg', 'jpeg', 'png', 'gif');
        $div = explode('.', $_FILES['avatar']['name']);
        $file_ext = strtolower(end($div));

        if (in_array($file_ext, $permited) === false) {
          $msg = "<div class='alert alert-danger' role='alert'>You can upload only JPG,JPEG,PNG or GIF file!</div>";
				return $msg;
          }

          $response = file_get_contents($imgurURL, false, $context);
          $response = json_decode($response);

          $avatar = $response->data->link;

          $query = "UPDATE users set avatar = '$avatar' WHERE id= '$userId'";
          $updateRow = $this->db->update($query);

          if ($updateRow) {
				$msg = "<div class='alert alert-success' role='alert'>You have successfully changed your Avatar!!</div>";
				return $msg;
			}else{
				$msg = "<div class='alert alert-danger' role='alert'>Something Went wrong.Please choose image properly!!</div>";
				return $msg;
			}

	}

	public function getProfileImage($userId){
		$query = "SELECT avatar FROM users WHERE id = '$userId'";
		$result = $this->db->select($query);
		return $result;
	}

}

?>