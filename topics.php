<?php 

require_once 'lib/database.php';
$db = new Database();
require_once 'classes/Post.php';
$post = new Post();

?>

<?php  
if (isset($_GET['topic'])) {
	$topic = $_GET['topic'];
	$getTopics = $post->getPostTopics($topic);
	if ($getTopics) {
		$query = "SELECT * FROM posts WHERE FIND_IN_SET('$topic', topics)";
		$result = $db->select($query);
		if ($result) {
			foreach($result as $post) {
                        // echo "<pre>";
                        // print_r($post);
                        // echo "</pre>";
                        echo $post['body']."<br />";


                }
                 echo "<br />";
                echo "<br />";
                echo "<br />";
                echo "<a href='newsFeed.php'>Go To Homepage</a>";
		}
		}else{
			header("Location:error404.php");
	}
}


?>