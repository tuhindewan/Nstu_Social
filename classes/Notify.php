<?php 
require_once 'lib/session.php';
Session::init();
require_once 'lib/database.php';
require_once 'helpers/format.php';
?>

<?php 

class Notify
{

	private $db;
	private $fm;
	function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}

  public function likeNotify($postId){
  		$query = "SELECT posts.user_id AS receiver, post_likes.user_id AS sender FROM posts, post_likes WHERE posts.id = post_likes.post_id AND posts.id='$postId'";
  		$res = $this->db->select($query);
  		if ($res) {
  			while ($val = $res->fetch_assoc()) {
  				$r = $val['receiver'];
  				$s = $val['sender'];
  				$query = "INSERT INTO notifications (type,receiver,sender,datetime,post_id) VALUES ('2','$r','$s',NOW(),'$postId')";
  				$result = $this->db->insert($query);
  			}
  		}

  }

  public function commentNotify($postId2){
    $commemtorId = Session::get("userid");
    $query = "SELECT posts.user_id AS receiver FROM posts WHERE posts.id='$postId2'";
      $res = $this->db->select($query);
      if ($res) {
        while ($val = $res->fetch_assoc()) {
          $r = $val['receiver'];
          $query = "INSERT INTO notifications (type,receiver,sender,datetime,post_id) VALUES ('3','$r','$commemtorId',NOW(),'$postId2')";
          $result = $this->db->insert($query);
        }
      }
  }

}

?>