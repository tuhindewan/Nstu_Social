<?php 
require_once 'lib/session.php';
Session::init();
require_once 'lib/database.php';
require_once 'helpers/format.php';
?>

<?php 

class Information
{

	private $db;
	private $fm;
	function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}

  public function addInformation($data,$userId){
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $department = $_POST['department'];
    $session = $_POST['session'];
    $status = $_POST['status'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $website = $_POST['website'];
    $live = $_POST['live'];
    $about = $_POST['about'];


    $email = $this->fm->validation($email);
    $phone = $this->fm->validation($phone);
    $website = $this->fm->validation($website);
    $live = $this->fm->validation($live);
    $about = $this->fm->validation($about);


    $email = mysqli_real_escape_string($this->db->link,$email);
    $phone = mysqli_real_escape_string($this->db->link,$phone);
    $website = mysqli_real_escape_string($this->db->link,$website);
    $live = mysqli_real_escape_string($this->db->link,$live);
    $about = mysqli_real_escape_string($this->db->link,$about);

    
      if($email!='' && !preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^",$email))
        { 
          $msg = "<div class='alert alert-danger' role='alert'>Invalid Email Address. Please enter a valid address.</div>";
          return $msg;
        }elseif ($website!='' && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
              $msg = "<div class='alert alert-danger' role='alert'>Invalid URL Address. Please enter a valid address.</div>";
            return $msg;
         }else{
          $query = "INSERT INTO user_information (birthDate,gender,department,session,status,email,website,phone,address,about,userId) VALUES ('$dob','$gender','$department','$session','$status','$email','$website','$phone','$live','$about','$userId')";
          $result = $this->db->insert($query);
          if ($result) {
            $msg = "<div class='alert alert-success' role='alert'>You successfully save your information.</div>";
            return $msg;
          }
         }


    

  }

  public function getInformation($userId){
    $query = "SELECT * FROM user_information WHERE userId = '$userId'";
    $result = $this->db->select($query);
    return $result;
  }

  public function updateInformation($data,$userId){
      $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $department = $_POST['department'];
    $session = $_POST['session'];
    $status = $_POST['status'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $website = $_POST['website'];
    $live = $_POST['live'];
    $about = $_POST['about'];


    $email = $this->fm->validation($email);
    $phone = $this->fm->validation($phone);
    $website = $this->fm->validation($website);
    $live = $this->fm->validation($live);
    $about = $this->fm->validation($about);


    $email = mysqli_real_escape_string($this->db->link,$email);
    $phone = mysqli_real_escape_string($this->db->link,$phone);
    $website = mysqli_real_escape_string($this->db->link,$website);
    $live = mysqli_real_escape_string($this->db->link,$live);
    $about = mysqli_real_escape_string($this->db->link,$about);

    
      if($email!='' && !preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^",$email))
        { 
          $msg = "<div class='alert alert-danger' role='alert'>Invalid Email Address. Please enter a valid address.</div>";
          return $msg;
        }elseif ($website!='' && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
              $msg = "<div class='alert alert-danger' role='alert'>Invalid URL Address. Please enter a valid address.</div>";
            return $msg;
         }else{
          $query = "INSERT INTO user_information (birthDate,gender,department,session,status,email,website,phone,address,about,userId) VALUES ('$dob','$gender','$department','$session','$status','$email','$website','$phone','$live','$about','$userId')";

          $query = "UPDATE user_information SET birthDate = '$dob',gender='$gender',department='$department',session='$session',status='$status',email='$email',website='$website',phone='$phone',address='$live',about='$about',userId='$userId'";
          $result = $this->db->update($query);
          if ($result) {
            $msg = "<div class='alert alert-success' role='alert'>You successfully update your information.</div>";
            return $msg;
          }
         }
  }

  public  function getUserAbout($userNameId){
    $query = "SELECT * FROM user_information WHERE userId = '$userNameId'";
    $result = $this->db->select($query);
    return $result;
  }


}

?>