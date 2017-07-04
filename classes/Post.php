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

	public function UserSinglePost($data,$id){
		$body = $_POST['body'];
		if (empty($body)) {
				$msg = "<div class='alert alert-danger' role='alert'>All fields are required.</div>";
				return $msg;
			}

		$query = "INSERT INTO posts (body,posted_at,user_id,likes) VALUES ('$body',NOW(),'$id',0)";
		$result = $this->db->insert($query);
	}

	public function getSinglePost($userId){
		$query = "SELECT * FROM posts WHERE user_id = '$userId' ORDER BY id DESC";
		$result= $this->db->select($query);
		return $result;
	}

	public function getAllPost(){
		$query = "SELECT * FROM posts ORDER BY id DESC";
		$result= $this->db->select($query);
		return $result;
	}

}

?>