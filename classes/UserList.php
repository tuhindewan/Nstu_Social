<?php 
require_once 'lib/session.php';
Session::checkSession();
require_once 'lib/database.php';
require_once 'helpers/format.php';
?>

<?php 

class UserList
{
	private $db;
	private $fm;
	function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}

	public function findSingleUser($id){
		
	   	return $result;
	}

}

?>