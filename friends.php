
<?php 
require_once 'lib/session.php';
Session::checkSession();
Session::init();
require_once 'lib/database.php';
$db = new Database();
$userId = Session::get("userid");
$username = Session::get("fullname");
$userName = Session::get("userName");
?>
<?php
require_once 'classes/Post.php';
$post = new Post();
require_once 'classes/EditProfile.php';
$edt = new EditProfile();
require_once 'classes/EditPost.php';
$ePost = new EditPost();
?>
<?php
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['post'])) {
  if ($_FILES['postImage']['size'] == 0) {
    $body =  $_POST['body'];
    if (count(notify($body)) != 0) {
      foreach (notify($body) as $key => $n) {
        $query = "SELECT id FROM posts ORDER BY id DESC LIMIT 1";
        $result = $db->select($query);
        if ($result) {
          while ($value = $result->fetch_assoc()) {
            $postId = $value['id'];
          }
        }
        $s = $userId;
        $query = "SELECT id FROM users WHERE username = '$key'";
        $res = $db->select($query);
        if ($res) {
          while ($val = $res->fetch_assoc()) {
            $r = $val['id'];
            if ($r != 0) {
          $query = "INSERT INTO notifications (type,receiver,sender,datetime,post_id) VALUES ('$n','$r','$s',NOW(),'$postId')";
          $result = $db->insert($query);
        }
          }
        }

        
      }
    }
    $topics = getTopics($body);
    $getData = $post->UserSinglePost($_POST,$userId,$topics);
  }else{
        $body =  $_POST['body'];
        if (count(notify($body)) != 0) {
      foreach (notify($body) as $key => $n) {
        $query = "SELECT id FROM posts ORDER BY id DESC LIMIT 1";
        $result = $db->select($query);
        if ($result) {
          while ($value = $result->fetch_assoc()) {
            $postId = $value['id'];
          }
        }
        $s = $userId;
        $query = "SELECT id FROM users WHERE username = '$key'";
        $res = $db->select($query);
        if ($res) {
          while ($val = $res->fetch_assoc()) {
            $r = $val['id'];
            if ($r != 0) {
          $query = "INSERT INTO notifications (type,receiver,sender,datetime,post_id) VALUES ('$n','$r','$s',NOW(),'$postId')";
          $result = $db->insert($query);
        }
          }
        }

        
      }
    }
        $topics = getTopics($body);
    $ImgPostId = $post->createImagePost($_POST,$userId,$topics);

    if ($ImgPostId) {
      while ($value = $ImgPostId->fetch_assoc()) {
        $postImgId = $value['id'];
      }
    }
    $upPostImg = $post->uploadPostImage($_FILES,$postImgId,$userId);
  }
  
}
?>
<?php 

if (isset($_GET['postId']) && !isset($_POST['deletePost'])) {
  $postId = $_GET['postId'];
  $query = "SELECT user_id FROM post_likes WHERE post_id='$postId' AND user_id = '$userId'";
  $result = $db->select($query);
  if ($result==false) {
    $query = "UPDATE posts SET likes=likes+1 WHERE id = '$postId'";
    $result = $db->update($query);
    $query = "INSERT INTO post_likes (post_id,user_id) VALUES ('$postId','$userId')";
    $result = $db->insert($query);
  }else{
    $query = "UPDATE posts SET likes=likes-1 WHERE id = '$postId'";
    $result = $db->update($query);
    $query = "DELETE FROM post_likes WHERE post_id = '$postId' AND user_id = '$userId'";
    $result = $db->delete($query);
  } 
}
?>
<?php 
require_once 'classes/Comment.php';
$cmnt = new Comment();
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['submit_comm']) ) {
  $getComment = $cmnt->createComment($_POST['commentbody'],$_GET['postId2'],$userId);
}
?>

<?php 
function link_add($text) {
$text = explode(" ", $text);
                $newstring = "";

                foreach ($text as $word) {
                        if (substr($word, 0, 1) == "@") {
                                $newstring .= "<a href='usersProfile.php?userName=".substr($word, 1)."'>".htmlspecialchars($word)."</a> ";
                        } else if (substr($word, 0, 1) == "#") {
                                $newstring .= "<a href='topics.php?topic=".substr($word, 1)."'>".htmlspecialchars($word)."</a> ";
                        } else {
                                $newstring .= htmlspecialchars($word)." ";
                        }
                }

                return $newstring;

}


 ?>
 <?php 
function getTopics($text) {
          $text = explode(" ", $text);
          $topics = "";
          foreach ($text as $word) {
                  if (substr($word, 0, 1) == "#") {
                          $topics .= substr($word, 1).",";
                  }
          }
          return $topics;
  }

 ?>

 <?php 
 function notify($text) {
        $text = explode(" ", $text);
        $notify = array();

        foreach ($text as $word) {
                if (substr($word, 0, 1) == "@") {
                        $notify[substr($word, 1)] = 1;
                }
        }

        return $notify;
}
?>
<?php 
require_once 'classes/Information.php';
$info = new Information();
 ?>

<!DOCTYPE html>
<html lang="en">
  
<!-- Mirrored from demos.bootdey.com/dayday/profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 08 May 2017 15:34:06 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <link rel="icon" href="img/nstu.png">
    <title>NSTUSocial | <?php echo $username; ?></title>
    <!-- Bootstrap core CSS -->
    <link href="bootstrap.3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome.4.6.1/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/animate.min.css" rel="stylesheet">
    <link href="assets/css/timeline.css" rel="stylesheet">
    <link href="assets/css/cover.css" rel="stylesheet">
    <link href="assets/css/forms.css" rel="stylesheet">
    <link href="assets/css/buttons.css" rel="stylesheet">
    <link href="assets/css/friends2.css" rel="stylesheet">
    <script src="assets/js/jquery.1.11.1.min.js"></script>
    <script src="bootstrap.3.3.6/js/bootstrap.min.js"></script>
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body class="animated fadeIn">

    <!-- Fixed navbar -->
    <nav class="navbar navbar-white navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="home.php"><b>NSTUSocial</b></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="actives"><a href="profile.php"><strong><?php echo $username; ?></strong></a></li>
            <li><a href="newsFeed.php">Home</a></li>
            <li><a href="messages.php"><i class="fa fa-comments"></i></a></li>
            <li><a href="notify.php"><i class="fa fa-globe"></i></a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <?php echo $userName; ?> <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li><a href="editProfile.php">Account Settings</a></li>
                <li role="separator" class="divider"></li>
                <?php 
                    if (isset($_GET['action']) && $_GET['action']=='logout') {
                       Session::destroy();
                    }
                 ?>
                <li><a href="?action=logout">Logout</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>

       <!-- Begin page content -->
    <div class="container page-content page-friends">
        <div class="row friends">

              <?php 

            $query = "SELECT user_id FROM followers WHERE follower_id = '$userId'";
            $result = $db->select($query);
            if ($result) {
              foreach ($result as $friend_id) {
                  $friend_id = $friend_id['user_id'];

                  $query = "SELECT * FROM users WHERE id = '$friend_id'";
                  $result = $db->select($query);
                  if ($result) {
                    foreach ($result as $value) {

 
           ?>
          <div class="col-md-4">
            <div class="panel panel-default">
              <div class="panel-heading">
                <div class="media">
                <?php 
                if ($value['avatar']) { ?>
                  <div class="pull-left">
                    <img src="<?php echo $value['avatar']; ?>" alt="people" class="media-object img-circle">
                  </div>
                <?php }else{ ?>
                     <div class="pull-left">
                    <img src="img/nophoto.jpg" alt="people" class="media-object img-circle">
                  </div>
                <?php   }   ?>

                  <div class="media-body">
                    <h4 class="media-heading margin-v-5"><a href="usersProfile.php?userId=<?php echo $value['id']; ?>&&userName=<?php echo $value['username'] ?>"><?php echo $value['fullName']; ?></a></h4>
                    <div class="profile-icons">
                      <span>Username: <strong><?php echo $value['username']; ?></strong></span>
                    </div>
                  </div>
                </div>
              </div>
            <?php 

              $query = "SELECT * FROM user_information WHERE userId = '$friend_id'";
              $result = $db->select($query);
              if ($result) {
                foreach ($result as $value)  {
             ?>
            
              <div class="panel-body">
                <div class="user-friend-list">
                <span><strong>Email: </strong> <?php echo $value['email']; ?></span><br>
                <span><strong>Department: </strong><?php echo $value['department']; ?></span><br>
                <span><strong>Status: </strong><?php echo $value['status']; ?></span><br>
                <span><strong>Website: </strong><a href="<?php echo $value['website']; ?>"><?php echo $value['website']; ?></a></span><br>
                </div>
              </div>

      <?php }} ?>
            </div>
          </div>
       <?php }}}} ?>
 
      </div>
    </div>

    

    <footer class="footer">
        <div class="container">
          <p class="text-muted"> Copyright &copy; Dept. of CSTE,NSTU - All rights reserved </p>
        </div>
    </footer>
      <script type="text/javascript">
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','../../www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-49755460-1', 'auto', {'allowLinker': true});
          ga('require', 'linker');
          ga('linker:autoLink', ['bootdey.com','www.bootdey.com','demos.bootdey.com'] );
          ga('send', 'pageview');
      </script>
  </body>

<!-- Mirrored from demos.bootdey.com/dayday/profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 08 May 2017 15:35:14 GMT -->
</html>
