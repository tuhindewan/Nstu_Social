<?php 
require_once 'lib/session.php';
require_once 'lib/database.php';
require_once 'helpers/format.php';
?>

<?php 

class Comment
{
	private $db;
	private $fm;
	function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}

	public function createComment($data,$postId,$userId){
		$commentbody = $_POST['commentbody'];
		$postId	  = $_GET['postId2'];
		if (empty($commentbody)) {
			$msg = "<div class='alert alert-danger' role='alert'>Please Write something.</div>";
				return $msg;
		}
		$query = "SELECT id FROM posts WHERE id = '$postId'";
		$result = $this->db->select($query);
		if ($result==false) {
			$msg = "<div class='alert alert-danger' role='alert'>Invalid Post ID.</div>";
				return $msg;
		}else{
			$query = "INSERT INTO comments (comment,user_id,posted_at,post_id) VALUES ('$commentbody','$userId',NOW(),'$postId')";
			$insertRow = $this->db->insert($query);
			if ($insertRow) {
				$msg = "<div class='alert alert-success' role='alert'>Successfully Commented.</div>";
				return $msg;
			}else{
				$msg = "<div class='alert alert-danger' role='alert'>not Commented.</div>";
				return $msg;
			}

			
		}
	}

	public function displayComments($postId){

		$query = "SELECT comments.comment,comments.posted_at,comments.post_id, users.fullName FROM comments, users WHERE post_id = '$postId' AND comments.user_id = users.id";
		$result = $this->db->select($query);
		return $result;
	}

	public function createFeedComment($data,$postId,$userId){
		$commentbody = $_POST['commentbody'];
		$postId	  = $_GET['postId2'];
		if (empty($commentbody)) {
			$msg = "<div class='alert alert-danger' role='alert'>Please Write something.</div>";
				return $msg;
		}
		$query = "SELECT id FROM posts WHERE id = '$postId'";
		$result = $this->db->select($query);
		if ($result==false) {
			
			$msg = "<div class='alert alert-danger' role='alert'>Invalid Post ID.</div>";
				return $msg;
		}else{
			$query = "INSERT INTO comments (comment,user_id,posted_at,post_id) VALUES ('$commentbody','$userId',NOW(),'$postId')";
			$insertRow = $this->db->insert($query);
			if ($insertRow) {
				$msg = "<div class='alert alert-success' role='alert'>Successfully Commented.</div>";
				return $msg;
			}else{
				$msg = "<div class='alert alert-danger' role='alert'>not Commented.</div>";
				return $msg;
			}

			
		}
	}

	public function displayFeedComments($postId){

		$query = "SELECT comments.comment,comments.posted_at,comments.post_id, users.fullName FROM comments, users WHERE post_id = '$postId' AND comments.user_id = users.id";
		$result = $this->db->select($query);
		return $result;
	}

}

?>