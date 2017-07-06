<?php 
require_once 'lib/session.php';
require_once 'lib/database.php';
require_once 'helpers/format.php';
?>

<?php 

class EditPost
{
	private $db;
	private $fm;
	function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}

	public function deleteSinglePost($postId,$userId){

		$query = "SELECT id FROM posts WHERE id = '$postId' AND user_id = '$userId'";
		$select_result = $this->db->select($query);
		if ($select_result) {
			$query = "DELETE FROM posts WHERE id = '$postId' AND user_id = '$userId'";
			$deleteresult= $this->db->delete($query);
			if ($deleteresult) {
				
			$query = "DELETE FROM post_likes WHERE post_id = '$postId'";
			$result = $this->db->delete($query);

			header("Location:profile.php");

			$msg = "<div class='alert alert-success' role='alert'>Post has been deleted successfully.</div>";
				return $msg;
			}else{
			$msg = "<div class='alert alert-danger' role='alert'>Something went wrong. Please try again later.</div>";
				return $msg;
			
		}
		}
	}

}

?>