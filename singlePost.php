<?php 
require_once 'lib/session.php';
Session::checkSession();
Session::init();
$username = Session::get("fullname");
$userId = Session::get('userid');
require_once 'lib/database.php';
$db = new Database();
require_once 'classes/EditProfile.php';
$edt = new EditProfile();
?>
<?php 
if (isset($_GET['postId'])) {
  $postId = $_GET['postId'];
}
?>
<?php 

require_once 'classes/Post.php';
$post = new Post();
require_once 'classes/Comment.php';
$cmt = new Comment();

 ?>


<!DOCTYPE html>
<html lang="en">
  
<!-- Mirrored from demos.bootdey.com/dayday/edit_profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 08 May 2017 15:35:44 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <link rel="icon" href="img/nstu.png">
    <title>NSTUSocial | Account setting</title>
    <!-- Bootstrap core CSS -->
    <link href="bootstrap.3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome.4.6.1/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/animate.min.css" rel="stylesheet">
    <link href="assets/css/timeline.css" rel="stylesheet">
    <link href="assets/css/cover.css" rel="stylesheet">
    <link href="assets/css/forms.css" rel="stylesheet">
    <link href="assets/css/buttons.css" rel="stylesheet">
    <link href="assets/css/edit_profile.css" rel="stylesheet">
    <script src="assets/js/jquery.1.11.1.min.js"></script>
    <script src="bootstrap.3.3.6/js/bootstrap.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/timeline.css" rel="stylesheet">
    <script src="js/jquery.1.11.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

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
            <li class="actives"><a href="profile.php">Profile</a></li>
            <li><a href="newsFeed.php">Home</a></li>
            <li><a href="notify.php"><i class="fa fa-globe"></i></a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                Pages <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="editProfile.php">Account Settings</a></li>
                <li role="separator" class="divider"></li>
                <?php 
                    if (isset($_GET['action']) && $_GET['action']=='logout') {
                       session_destroy();
                    }
                 ?>
                <li><a href="?action=logout">Logout</a></li>
              </ul>
            </li>
            <li><a href="#" class="nav-controller"><i class="fa fa-user"></i></a></li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Begin page content -->

    <div class="container container-timeline" style="margin-top:100px;"> 
    <?php 
    $getPost = $post->getNotifyPost($postId);
    if ($getPost) {
      while ($value = $getPost->fetch_assoc()) {
        
     ?>
      <div class="box box-widget">
          <div class="box-header with-border">
            <div class="user-block">
              <img class="img-circle" src="img/Friends/guy-3.jpg" alt="User Image">
              <span class="username"><a href="profile.php"><?php echo $username; ?></a></span>
              <span class="description">Shared publicly - <?php echo  date("M j, Y h:ia",strtotime($value['posted_at'])) ; ?></span>
            </div>
          </div>

          <div class="box-body" style="display: block;">
            <p>
              <?php echo $value["body"]; ?>
            </p>
              <?php

              if ($value["postImage"]) { ?>
                <img class="img-responsive show-in-modal" src="<?php echo $value["postImage"]; ?>" alt="Photo">
           <?php   } ?>
            <button type="button" class="btn btn-default btn-xs"><i class="fa fa-share"></i> Share</button>
            <button type="button" class="btn btn-default btn-xs"><i class="fa fa-thumbs-o-up"></i> Like</button>
            <span class="pull-right text-muted">127 likes - 3 comments</span>
          </div>

          <?php 

          $getCommnt = $cmt->getNotifyComment($postId);
          if ($getCommnt) {
            while ($value = $getCommnt->fetch_assoc()) {

           ?>
      
          <div class="box-footer box-comments" style="display: block;">
            <div class="box-comment">
              <img class="img-circle img-sm" src="img/Friends/guy-2.jpg" alt="User Image">
              <div class="comment-text">
                <span class="username">
                <?php echo $value['fullName']; ?>
                <span class="text-muted pull-right"><?php echo  date("M j, Y h:ia",strtotime($value['posted_at'])) ; ?></span>
                </span>
                <?php echo $value['comment']; ?>
              </div>
            </div>
          </div>

<?php }} ?>
          <div class="box-footer" style="display: block;">
            <form action="#" method="post">
              <img class="img-responsive img-circle img-sm" src="img/Friends/guy-3.jpg" alt="Alt Text">
              <div class="img-push">
                <input type="text" class="form-control input-sm" placeholder="Press enter to post comment">
              </div>
            </form>
          </div>
        </div><!--  end posts-->
<?php }} ?>
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

<!-- Mirrored from demos.bootdey.com/dayday/edit_profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 08 May 2017 15:35:46 GMT -->
</html>
