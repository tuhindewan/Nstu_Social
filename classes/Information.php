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
    if ($dob) {
      $query = "UPDATE user_information SET birthDate = '$dob' WHERE userId='$userId'";
          $result = $this->db->update($query);
          if ($result) {
            $msg = "<div class='alert alert-success' role='alert'>You successfully update your information.</div>";
            return $msg;
    }
  }else{
      $query = "UPDATE user_information SET gender='$gender',department='$department',session='$session',status='$status',email='$email',website='$website',phone='$phone',address='$live',about='$about' WHERE userId='$userId'";
          $result = $this->db->update($query);
          if ($result) {
            $msg = "<div class='alert alert-success' role='alert'>You successfully update your information.</div>";
            return $msg;
    }
  }

 if ($gender) {
      $query = "UPDATE user_information SET gender='$gender' WHERE userId='$userId'";
          $result = $this->db->update($query);
          if ($result) {
            $msg = "<div class='alert alert-success' role='alert'>You successfully update your information.</div>";
            return $msg;
    }
  }else{
      $query = "UPDATE user_information SET birthDate = '$dob',department='$department',session='$session',status='$status',email='$email',website='$website',phone='$phone',address='$live',about='$about' WHERE userId='$userId'";
          $result = $this->db->update($query);
          if ($result) {
            $msg = "<div class='alert alert-success' role='alert'>You successfully update your information.</div>";
            return $msg;
    }
  }
    if ($department) {
      $query = "UPDATE user_information SET department='$department' WHERE userId='$userId'";
          $result = $this->db->update($query);
          if ($result) {
            $msg = "<div class='alert alert-success' role='alert'>You successfully update your information.</div>";
            return $msg;
    }
  }else{
      $query = "UPDATE user_information SET birthDate = '$dob', gender='$gender',session='$session',status='$status',email='$email',website='$website',phone='$phone',address='$live',about='$about' WHERE userId='$userId'";
          $result = $this->db->update($query);
          if ($result) {
            $msg = "<div class='alert alert-success' role='alert'>You successfully update your information.</div>";
            return $msg;
    }
  }

      if ($session) {
      $query = "UPDATE user_information SET session='$session' WHERE userId='$userId'";
          $result = $this->db->update($query);
          if ($result) {
            $msg = "<div class='alert alert-success' role='alert'>You successfully update your information.</div>";
            return $msg;
    }
  }else{
      $query = "UPDATE user_information SET birthDate = '$dob', gender='$gender',department='$department',status='$status',email='$email',website='$website',phone='$phone',address='$live',about='$about' WHERE userId='$userId'";
          $result = $this->db->update($query);
          if ($result) {
            $msg = "<div class='alert alert-success' role='alert'>You successfully update your information.</div>";
            return $msg;
    }
  }   
  if ($status) {
      $query = "UPDATE user_information SET status='$status' WHERE userId='$userId'";
          $result = $this->db->update($query);
          if ($result) {
            $msg = "<div class='alert alert-success' role='alert'>You successfully update your information.</div>";
            return $msg;
    }
  }else{
      $query = "UPDATE user_information SET birthDate = '$dob', gender='$gender',department='$department',session='$session',email='$email',website='$website',phone='$phone',address='$live',about='$about' WHERE userId='$userId'";
          $result = $this->db->update($query);
          if ($result) {
            $msg = "<div class='alert alert-success' role='alert'>You successfully update your information.</div>";
            return $msg;
    }
  }

   if ($email) {
      $query = "UPDATE user_information SET email='$email' WHERE userId='$userId'";
          $result = $this->db->update($query);
          if ($result) {
            $msg = "<div class='alert alert-success' role='alert'>You successfully update your information.</div>";
            return $msg;
    }
  }else{
      $query = "UPDATE user_information SET birthDate = '$dob', gender='$gender',department='$department',session='$session',status='$status',website='$website',phone='$phone',address='$live',about='$about' WHERE userId='$userId'";
          $result = $this->db->update($query);
          if ($result) {
            $msg = "<div class='alert alert-success' role='alert'>You successfully update your information.</div>";
            return $msg;
    }
  }

     if ($phone) {
      $query = "UPDATE user_information SET phone='$phone' WHERE userId='$userId'";
          $result = $this->db->update($query);
          if ($result) {
            $msg = "<div class='alert alert-success' role='alert'>You successfully update your information.</div>";
            return $msg;
    }
  }else{
      $query = "UPDATE user_information SET birthDate = '$dob', gender='$gender',department='$department',session='$session',status='$status',website='$website',address='$live',about='$about' WHERE userId='$userId'";
          $result = $this->db->update($query);
          if ($result) {
            $msg = "<div class='alert alert-success' role='alert'>You successfully update your information.</div>";
            return $msg;
    }
  }

       if ($website) {
      $query = "UPDATE user_information SET website='$website' WHERE userId='$userId'";
          $result = $this->db->update($query);
          if ($result) {
            $msg = "<div class='alert alert-success' role='alert'>You successfully update your information.</div>";
            return $msg;
    }
  }else{
      $query = "UPDATE user_information SET birthDate = '$dob', gender='$gender',department='$department',session='$session',status='$status',phone='$phone',email='$email',address='$live',about='$about' WHERE userId='$userId'";
          $result = $this->db->update($query);
          if ($result) {
            $msg = "<div class='alert alert-success' role='alert'>You successfully update your information.</div>";
            return $msg;
    }
  }

         if ($live) {
      $query = "UPDATE user_information SET address='$live' WHERE userId='$userId'";
          $result = $this->db->update($query);
          if ($result) {
            $msg = "<div class='alert alert-success' role='alert'>You successfully update your information.</div>";
            return $msg;
    }
  }else{
      $query = "UPDATE user_information SET birthDate = '$dob', gender='$gender',department='$department',session='$session',status='$status',phone='$phone',email='$email',website='$website',about='$about' WHERE userId='$userId'";
          $result = $this->db->update($query);
          if ($result) {
            $msg = "<div class='alert alert-success' role='alert'>You successfully update your information.</div>";
            return $msg;
    }
  }

           if ($about) {
      $query = "UPDATE user_information SET about='$about' WHERE userId='$userId'";
          $result = $this->db->update($query);
          if ($result) {
            $msg = "<div class='alert alert-success' role='alert'>You successfully update your information.</div>";
            return $msg;
    }
  }else{
      $query = "UPDATE user_information SET birthDate = '$dob', gender='$gender',department='$department',session='$session',status='$status',phone='$phone',email='$email',website='$website',address='$live' WHERE userId='$userId'";
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

  public function getUserData($userNameId){

    $query = "SELECT * FROM user_information WHERE userId = '$userNameId'";
    $result = $this->db->select($query);
    return $result;
  }


}

?>