<?php 
require_once 'lib/session.php';
require_once 'lib/database.php';
require_once 'helpers/format.php';
?>

<?php 

class Post
{
	private $db;
	private $fm;
	function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}

	public function UserSinglePost($data,$id,$topics){
		$body = $_POST['body'];
		$body = trim($body);
		if (empty($body)) {
				$msg = "<div class='alert alert-danger' role='alert'>You cannot post an empty Field.</div>";
				return $msg;
			}

		$query = "INSERT INTO posts (body,posted_at,user_id,likes,topics) VALUES ('$body',NOW(),'$id',0,'$topics')";
		$result = $this->db->insert($query);
	}

	public function getSinglePost($userId){
		$query = "SELECT * FROM posts WHERE user_id = '$userId' ORDER BY id DESC";
		$result= $this->db->select($query);
		return $result;
	}
	public function getFollowingData($userId){
		$query = "SELECT posts.body,posts.id,posts.likes,posts.posted_at,posts.postImage,users.fullName,users.avatar FROM users,posts,followers WHERE posts.user_id = followers.user_id AND users.id = posts.user_id AND follower_id='$userId' ORDER BY posts.posted_at DESC";
		$result = $this->db->select($query);
		return $result;
	}

	public function createImagePost($data,$id,$topics){
		$body = $_POST['body'];

		$query = "INSERT INTO posts (body,posted_at,user_id,likes,topics) VALUES ('$body',NOW(),'$id',0,'$topics')";
		$result = $this->db->insert($query);

		$query = "SELECT id FROM posts WHERE user_id='$id' ORDER BY id DESC LIMIT 1";
		$postId = $this->db->select($query);
		return $postId;
	}

	public function uploadPostImage($file,$postImgId,$userId){

	  $permited  = array('jpg', 'jpeg', 'png', 'gif');
      $file_name = $_FILES['postImage']['name'];
      $file_size = $_FILES['postImage']['size'];
      $file_temp = $_FILES['postImage']['tmp_name'];


      $div = explode('.', $file_name);
      $file_ext = strtolower(end($div));
      $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
      $uploaded_image = "PostImages/".$unique_image;

      if (empty($file_name)) {
      		 $msg = "<div class='alert alert-danger' role='alert'>Please choose an image first for your Post.</div>";
				return $msg;;
      }elseif ($file_size >10240000) {
       		$msg = "<div class='alert alert-danger' role='alert'>Image Size should be 10MB or less then 10MB!</div>";
				return $msg;
      } elseif (in_array($file_ext, $permited) === false) {
      		$msg = "<div class='alert alert-danger' role='alert'>You can upload only JPG,JPEG,PNG or GIF file!</div>";
				return $msg;
      } else{
      move_uploaded_file($file_temp, $uploaded_image);
      $query = "UPDATE posts SET postImage = '$uploaded_image' WHERE user_id = '$userId' AND id= '$postImgId'";
      $update_rows = $this->db->update($query);
      if ($update_rows) {
       		$msg = "<div class='alert alert-success' role='alert'>You have successfully Posted an Image!!</div>";
				return $msg;

      }else {
   			$msg = "<div class='alert alert-danger' role='alert'>Something Went wrong.Please choose image properly!!</div>";
			return $msg;

     }   
     }


	}

	public function getPostTopics($topic){
		$query = "SELECT topics FROM posts WHERE FIND_IN_SET('$topic', topics)";
		$result = $this->db->select($query);
		return $result;
	}

	public function getNotifyPost($postId){
		$query = "SELECT * FROM posts WHERE id = '$postId'";
		$result= $this->db->select($query);
		return $result;
	}

	public function getUserImage($userId){
		$query = "SELECT postImage FROM posts WHERE user_id = '$userId'";
		$result= $this->db->select($query);
		return $result;
	}

	public function getUserSinglePost($userNameId){
		$query = "SELECT * FROM posts WHERE user_id = '$userNameId'";
		$result = $this->db->select($query);
		return $result;
	}

}

?>