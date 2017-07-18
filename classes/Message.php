<?php 
require_once 'lib/session.php';
Session::init();
require_once 'lib/database.php';
require_once 'helpers/format.php';
?>

<?php 

class Message
{

	private $db;
	private $fm;
	function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}

  public function getFriendList($userId){
    $query = "SELECT * FROM followers WHERE follower_id = '$userId'";
    $result = $this->db->select($query);
    if ($result) {
      foreach ($result as $value) {
        $friendId = $value['user_id'];

        $sel_query = "SELECT * FROM users WHERE id = '$friendId'";
        $res = $this->db->select($sel_query);
        return $res;
      }
  }

}

      public function userMessageData($data,$userId,$friendId){
        $message = $_POST['message'];

        $query = "INSERT INTO messages (body,sender,receiver,seen,time) VALUES ('$message','$userId','$friendId',0,NOW())";
        $result = $this->db->insert($query);
      }

      public function getSendMessage($userId){
        $query = "SELECT * FROM messages WHERE sender = '$userId' OR receiver = '$userId'";
        $result = $this->db->select($query);
        return $result;
      }


        public function getReceiveMessage($friendId){
        $query = "SELECT * FROM messages WHERE receiver = '$friendId'";
        $result = $this->db->select($query);
        return $result;
      }

}

?>