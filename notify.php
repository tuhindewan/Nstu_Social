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

  <body>

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
            <li><a href="notifications.html"><i class="fa fa-globe"></i></a></li>
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
      <div class="col-md-10 no-paddin-xs">
        <div class="col-md-5 no-paddin-xs">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Notifications</h3>
          </div>
          <div class="panel-body">
            <?php
             $getProImage = $edt->getProfileImage($userId);
             if ($getProImage) {
               while ($proImage = $getProImage->fetch_assoc()) {

             ?>
             <?php 
             if ($proImage['avatar']) { ?>
               <img height="90px" width="90px"  src="<?php echo $proImage['avatar']; ?>" class="home-avatar img-thumbnail" alt="user profile image">
            <?php }else{?>
                  <img height="90px" width="90px"  src="img/nophoto.jpg" class="home-avatar img-thumbnail" alt="user profile image">
             <?php } ?>
            
          <?php }} ?>
            <a href="profile.php"><?php echo $username; ?></a>
          </div>
        </div>

        <!-- friends -->
        <div class="panel panel-default panel-friends">
          <div class="panel-heading">
            <a href="#" class="pull-right">View all&nbsp;<i class="fa fa-share-square-o"></i></a>
            <h3 class="panel-title">Friends</h3>
          </div>
          <div class="panel-body text-center">
            <ul class="friends">
              <li>
                  <a href="#">
                      <img src="img/Friends/woman-4.jpg" title="Jhoanath matew" class="img-responsive tip">
                  </a>
              </li>
              <li>
                  <a href="#">
                      <img src="img/Friends/woman-3.jpg" title="Martha creawn" class="img-responsive tip">
                  </a>
              </li>
              <li>
                  <a href="#">
                      <img src="img/Friends/guy-2.jpg" title="Jeferh smith" class="img-responsive tip">
                  </a>
              </li>
              <li>
                  <a href="#">
                      <img src="img/Friends/woman-9.jpg" title="Linda palma" class="img-responsive tip">
                  </a>
              </li>
              <li>
                  <a href="#">
                      <img src="img/Friends/guy-9.jpg" title="Lindo polmo" class="img-responsive tip">
                  </a>
              </li>
              <li>
                  <a href="#">
                      <img src="img/Friends/guy-5.jpg" title="andrew cartson" class="img-responsive tip">
                  </a>
              </li>
            </ul>
          </div>
        </div><!-- end friends -->
        <!-- People You May Know -->
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">People You May Know</h3>
          </div>
          <div class="panel-body">
            <div class="notification-row">
              <div class="notification-padding">
                <div class="sidebar-fa-image img-may-know">
                  <img class="notifications" src="img/Friends/guy-2.jpg">
                </div>
                <div class="sidebar-fa-text">
                  <b><a href="#">Carlos marthur</a></b><br>
                  <a class="btn btn-info" href="#"><i class="fa fa-user-plus">Add Friend</i></a>
                </div>
              </div>
            </div>

            <div class="notification-row">
              <div class="notification-padding">
                <div class="sidebar-fa-image img-may-know">
                  <img class="notifications" src="img/Friends/woman-1.jpg">
                </div>
                <div class="sidebar-fa-text">
                  <b><a href="#">Maria gustami</a></b><br>
                  <a class="btn btn-info" href="#"><i class="fa fa-user-plus">Add Friend</i></a>
                </div>
              </div>
            </div>

            <div class="notification-row">
              <div class="notification-padding">
                <div class="sidebar-fa-image img-may-know">
                  <img class="notifications" src="img/Friends/woman-2.jpg">
                </div>
                <div class="sidebar-fa-text">
                  <b><a href="#">Angellina mcblown</a></b><br>
                  <a class="btn btn-info" href="#"><i class="fa fa-user-plus">Add Friend</i></a>
                </div>
              </div>
            </div>            
          </div>
        </div><!-- End People You May Know -->
      </div><!-- end left content -->

      <!-- notification list-->
        <?php 


        $query = "SELECT * FROM notifications WHERE receiver = '$userId'";
        $result = $db->select($query);
        if ($result) {
          $query = "SELECT * FROM notifications WHERE receiver = '$userId' ORDER BY id DESC";
          $result = $db->select($query);
          if ($result) {
             foreach ($result as $value) {
               
             $type = $value['type'];
             $senderId = $value['sender'];
             $time = $value['datetime'];
             $postId = $value['post_id'];

         ?>
         <?php if ($type==1) { ?>

         <?php 

         $query = "SELECT * FROM users WHERE id = '$senderId'";
         $result = $db->select($query);
         if ($result) {
            while ($value = $result->fetch_assoc()) {

          ?>
            <div class="col-md-7 no-paddin-xs">
              <div class="panel panel-white post panel-shadow">
                <div class="post-heading">
                <?php if ($value['avatar']) { ?>
                  <div class="pull-left image">
                        <img src="<?php echo $value['avatar']; ?>" class="avatar" alt="user profile image">
                    </div>
              <?php   }else{ ?>
                    <div class="pull-left image">
                        <img src="img/nophoto.jpg" class="avatar" alt="user profile image">
                    </div>
                    <?php } ?>
                    <div class="pull-left meta">
                        <div class="title h5">
                            <a href="usersProfile.php?userName=<?php echo $value['username']; ?>" class="post-user-name"><?php echo $value['fullName']; ?></a>
                            mentioned you in a <a href="singlePost.php?postId=<?php echo $postId ?>">Post</a>
                        </div>
                        <h6 class="text-muted time"><?php echo  date("M j, Y h:ia",strtotime($time)) ; ?></h6>
                    </div>
                </div>
              </div>
            </div>

            <?php }} ?>
       <?php  } ?>
       <?php if ($type==2) { ?>

         <?php 

         $query = "SELECT * FROM users WHERE id = '$senderId'";
         $result = $db->select($query);
         if ($result) {
            while ($value = $result->fetch_assoc()) {

          ?>
            <div class="col-md-7 no-paddin-xs">
              <div class="panel panel-white post panel-shadow">
                <div class="post-heading">
                <?php if ($value['avatar']) { ?>
                  <div class="pull-left image">
                        <img src="<?php echo $value['avatar']; ?>" class="avatar" alt="user profile image">
                    </div>
              <?php   }else{ ?>
                    <div class="pull-left image">
                        <img src="img/nophoto.jpg" class="avatar" alt="user profile image">
                    </div>
                    <?php } ?>
                    <div class="pull-left meta">
                        <div class="title h5">
                            <a href="usersProfile.php?userName=<?php echo $value['username']; ?>" class="post-user-name"><?php echo $value['fullName']; ?></a>
                           is like your <a href="singlePost.php?postId=<?php echo $postId ?>">Post</a>
                        </div>
                        <h6 class="text-muted time"><?php echo  date("M j, Y h:ia",strtotime($time)) ; ?></h6>
                    </div>
                </div>
              </div>
            </div>

            <?php }} ?>
       <?php  } ?>

       <?php if ($type==3) { ?>

         <?php 

         $query = "SELECT * FROM users WHERE id = '$senderId'";
         $result = $db->select($query);
         if ($result) {
            while ($value = $result->fetch_assoc()) {

          ?>
            <div class="col-md-7 no-paddin-xs">
              <div class="panel panel-white post panel-shadow">
                <div class="post-heading">
                <?php if ($value['avatar']) { ?>
                  <div class="pull-left image">
                        <img src="<?php echo $value['avatar']; ?>" class="avatar" alt="user profile image">
                    </div>
              <?php   }else{ ?>
                    <div class="pull-left image">
                        <img src="img/nophoto.jpg" class="avatar" alt="user profile image">
                    </div>
                    <?php } ?>
                    <div class="pull-left meta">
                        <div class="title h5">
                            <a href="usersProfile.php?userName=<?php echo $value['username']; ?>" class="post-user-name"><?php echo $value['fullName']; ?></a>
                            commented on your <a href="singlePost.php?postId=<?php echo $postId ?>">Post</a>
                        </div>
                        <h6 class="text-muted time"><?php echo  date("M j, Y h:ia",strtotime($time)) ; ?></h6>
                    </div>
                </div>
              </div>
            </div>

            <?php }} ?>
       <?php  } ?>
       <?php }}} ?>
      
    </div>
   </div> 

    <!-- Online users sidebar content-->
    <div class="chat-sidebar focus">
      <div class="list-group text-left">
        <p class="text-center visible-xs"><a href="#" class="hide-chat btn btn-success btn-sm">Hide</a></p> 
        <p class="text-center chat-title">Online users</p>  
        <a href="messages.html" class="list-group-item">
          <i class="fa fa-check-circle connected-status"></i>
          <img src="img/Friends/guy-2.jpg" class="img-chat img-thumbnail">
          <span class="chat-user-name">Jeferh Smith</span>
        </a>
        <a href="messages.html" class="list-group-item">
          <i class="fa fa-times-circle absent-status"></i>
          <img src="img/Friends/woman-1.jpg" class="img-chat img-thumbnail">
          <span class="chat-user-name">Dapibus acatar</span>
        </a>
        <a href="messages.html" class="list-group-item">
          <i class="fa fa-check-circle connected-status"></i>
          <img src="img/Friends/guy-3.jpg" class="img-chat img-thumbnail">
          <span class="chat-user-name">Antony andrew lobghi</span>
        </a>
        <a href="messages.html" class="list-group-item">
          <i class="fa fa-check-circle connected-status"></i>
          <img src="img/Friends/woman-2.jpg" class="img-chat img-thumbnail">
          <span class="chat-user-name">Maria fernanda coronel</span>
        </a>
        <a href="messages.html" class="list-group-item">
          <i class="fa fa-check-circle connected-status"></i>
          <img src="img/Friends/guy-4.jpg" class="img-chat img-thumbnail">
          <span class="chat-user-name">Markton contz</span>
        </a>
        <a href="messages.html" class="list-group-item">
          <i class="fa fa-times-circle absent-status"></i>
          <img src="img/Friends/woman-3.jpg" class="img-chat img-thumbnail">
          <span class="chat-user-name">Martha creaw</span>
        </a>
        <a href="messages.html" class="list-group-item">
          <i class="fa fa-times-circle absent-status"></i>
          <img src="img/Friends/woman-8.jpg" class="img-chat img-thumbnail">
          <span class="chat-user-name">Yira Cartmen</span>
        </a>
        <a href="messages.html" class="list-group-item">
          <i class="fa fa-check-circle connected-status"></i>
          <img src="img/Friends/woman-4.jpg" class="img-chat img-thumbnail">
          <span class="chat-user-name">Jhoanath matew</span>
        </a>
        <a href="messages.html" class="list-group-item">
          <i class="fa fa-check-circle connected-status"></i>
          <img src="img/Friends/woman-5.jpg" class="img-chat img-thumbnail">
          <span class="chat-user-name">Ryanah Haywofd</span>
        </a>
        <a href="messages.html" class="list-group-item">
          <i class="fa fa-check-circle connected-status"></i>
          <img src="img/Friends/woman-9.jpg" class="img-chat img-thumbnail">
          <span class="chat-user-name">Linda palma</span>
        </a>
        <a href="messages.html" class="list-group-item">
          <i class="fa fa-check-circle connected-status"></i>
          <img src="img/Friends/woman-10.jpg" class="img-chat img-thumbnail">
          <span class="chat-user-name">Andrea ramos</span>
        </a>
        <a href="messages.html" class="list-group-item">
          <i class="fa fa-check-circle connected-status"></i>
          <img src="img/Friends/child-1.jpg" class="img-chat img-thumbnail">
          <span class="chat-user-name">Dora ty bluekl</span>
        </a>        
      </div>
    </div><!-- Online users sidebar content-->


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
