<?php
require_once 'lib/database.php';
$db = new Database();
if (isset($_GET['userName'])) {
  $userName = $_GET['userName'];

  $query = "SELECT id FROM users WHERE username = '$userName'";
  $result = $db->select($query);
  if ($result) {
    foreach ($result as $userNameId){
      $userNameId = $userNameId['id'];
    }
  }
}
?>
<?php 

require_once 'lib/session.php';
Session::checkSession();
Session::init();
$followerId = Session::get("userid");
$username = Session::get("fullname");

 ?>

 <?php 
require_once 'classes/Information.php';
$info = new Information();

  ?>
<!DOCTYPE html>
<html lang="en">
  
<!-- Mirrored from demos.bootdey.com/dayday/profile3.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 08 May 2017 15:35:16 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <link rel="icon" href="img/favicon.png">
    <title>NSTUSocial | A Social Communication Site for NSTU</title>
    <!-- Bootstrap core CSS -->
    <link href="bootstrap.3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome.4.6.1/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/animate.min.css" rel="stylesheet">
    <link href="assets/css/timeline.css" rel="stylesheet">
    <link href="assets/css/forms.css" rel="stylesheet">
    <link href="assets/css/buttons.css" rel="stylesheet">
    <link href="assets/css/profile3.css" rel="stylesheet">
    <script src="assets/js/jquery.1.11.1.min.js"></script>
    <script src="bootstrap.3.3.6/js/bootstrap.min.js"></script>
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

  <?php if ($userId==$followerId) { 
      header("Location:error404.php");
    ?>
  <?php }else{ ?>
<!-- Begin page content -->
    <div class="container page-content">
      <div class="row">
      <div class="col-md-10 col-md-offset-1">
      <div class="user-profile">
          <?php 
            $query = "SELECT * FROM users WHERE id = '$userNameId'";
            $result = $db->select($query);
            if ($result) {
              foreach ($result as  $value) {
                
             ?>
        <div class="profile-header-background">
          <?php 
          if ($value['cover']) { ?>
            <img width="945px" height="310px" src="<?php echo $value['cover']; ?>" alt="Profile Header Background">
        <?php  }else{ ?>
          <img width="945px" height="310px" src="img/blank.jpg" alt="Profile Header Background">
          <?php } ?>


        </div>
        <?php }} ?>
        <div class="row">


          <div class="col-md-4">
            <div class="profile-info-left">
            <?php 
            $query = "SELECT * FROM users WHERE id = '$userNameId'";
            $result = $db->select($query);
            if ($result) {
              foreach ($result as  $value) {
                
             ?>
              <div class="text-center">
                  <?php 
                    if ($value['avatar']) { ?>
                      <img width="114px" height="114px" src="<?php echo $value['avatar']; ?>" alt="Avatar" class="avatar img-circle">
                <?php    }else{ ?>
                  <img width="114px" height="114px" src="img/nophoto.jpg" alt="Avatar" class="avatar img-circle">
                <?php }   ?>


                  <h2><?php echo $value['fullName']; ?></h2>
              </div>
             <?php }} ?> 
              <div class="action-buttons">
                <div class="row">
                  <div class="col-xs-6">
                  <?php  
                  $isFollowing = False;
                  $select_query = "SELECT * FROM followers WHERE user_id='$userNameId' AND follower_id = '$followerId'";
                    $result= $db->select($select_query);
                  if (isset($_POST['follow'])) {
                    if ($userNameId!=$followerId) {
                      if ($result==false) {
                      $query = "INSERT INTO followers (user_id,follower_id,username) VALUES ('$userNameId','$followerId','$userName')";
                      $insert_result= $db->insert($query);
                    }
                    $isFollowing = True;
                    }
                  }

                  if (isset($_POST['unfollow'])) {

                    if ($userNameId!=$followerId) {
                      if ($result==true) {
                      $query = "DELETE FROM followers WHERE user_id = '$userNameId' AND follower_id = '$followerId' AND username = '$userName'";
                      $delete_result= $db->delete($query);
                    }
                    $isFollowing = False;
                    }
                  }

                  if ($result==true) {
                       
                      //echo 'Already following!';
                      $isFollowing = True;
                    }
                    




                  ?>
                      <form action="" method="POST">
                      <?php
                      if ($isFollowing==True) {
                        echo'<button type="submit" class="btn btn-danger btn-block" name="unfollow"><i class="fa fa-minus-circle"></i> Unfollow</button>';
                      }else{
                        echo'<button type="submit" class="btn btn-azure btn-block" name="follow"><i class="fa fa-user-plus"></i> Follow</button>';
                      }

                      ?>
                      </form>
                  </div>
                  <div class="col-xs-6">
                      <a href="#" class="btn btn-azure btn-block"><i class="fa fa-envelope"></i> Message</a>
                  </div>
                </div>
              </div>


              <div class="section">
                  <h3>About Me</h3>
            <?php 

            $getAbout = $info->getUserAbout($userNameId);
            if ($getAbout) {
              foreach ($getAbout as $value) {
                $about = $value['about']; 

             ?>
                  <p><?php echo $about; ?></p>
            <?php }} ?>
              </div>
              <?php 
              if ($isFollowing==True) { ?>
              <div class="section">
                <h3>Statistics</h3>
                <p><span class="badge">Email</span> Following</p>
                <p><span class="badge">124</span> Followers</p>
                <p><span class="badge">620</span> Likes</p>
              </div>

              <div class="section">
                <h3>Social</h3>
                <ul class="list-unstyled list-social">
                  <li><a href="#"><i class="fa fa-twitter"></i> @jhongrwo</a></li>
                  <li><a href="#"><i class="fa fa-facebook"></i> John grow</a></li>
                  <li><a href="#"><i class="fa fa-dribbble"></i> johninizzie</a></li>
                  <li><a href="#"><i class="fa fa-linkedin"></i> John grow</a></li>
                </ul>
              </div>
             <?php }else{ ?>
                      <div class="section">
                  <h3 style="color: #2dc3e8;">To see user profile, first become friend.</h3>
              </div>
            <?php   }  ?>

            


            </div>
          </div>


          <div class="col-md-8">
              <div class="profile-info-right">
                  <ul class="nav nav-pills nav-pills-custom-minimal custom-minimal-bottom">
                      <li class="active"><a href="#timeline" data-toggle="tab">Timeline</a></li>
                      <li><a href="#followers" data-toggle="tab">Followers</a></li>
                      <li><a href="#following" data-toggle="tab">Following</a></li>
                  </ul>
                  <div class="tab-content">
                      <!-- activities -->
                      <div class="tab-pane fade in active" id="timeline">
                          <div class="media activity-item">
                              <a href="#" class="pull-left">
                                  <img src="img/Friends/guy-1.jpg" alt="Avatar" class="media-object avatar">
                              </a>
                              <div class="media-body">
                                  <p class="activity-title"><a href="#">Antonius</a> started following <a href="#">Jack Bay</a> <small class="text-muted">- 2m ago</small></p>
                                  <small class="text-muted">Today 08:30 am - 02.05.2014</small>
                              </div>
                              <div class="btn-group pull-right activity-actions">
                                  <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown">
                                      <i class="fa fa-th"></i>
                                      <span class="sr-only">Toggle Dropdown</span>
                                  </button>
                                  <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                      <li><a href="#">I don't want to see this</a></li>
                                      <li><a href="#">Unfollow Antonius</a></li>
                                      <li class="divider"></li>
                                      <li><a href="#">Get Notification</a></li>
                                  </ul>
                              </div>
                          </div>
                          <div class="media activity-item">
                              <a href="#" class="pull-left">
                                  <img src="img/Friends/guy-2.jpg" alt="Avatar" class="media-object avatar">
                              </a>
                              <div class="media-body">
                                  <p class="activity-title"><a href="#">Jane Doe</a> likes <a href="#">Jack Bay</a> <small class="text-muted">- 36m ago</small></p>
                                  <small class="text-muted">Today 07:23 am - 02.05.2014</small>
                              </div>
                              <div class="btn-group pull-right activity-actions">
                                  <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown">
                                      <i class="fa fa-th"></i>
                                      <span class="sr-only">Toggle Dropdown</span>
                                  </button>
                                  <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                      <li><a href="#">I don't want to see this</a></li>
                                      <li><a href="#">Unfollow Jane Doe</a></li>
                                      <li class="divider"></li>
                                      <li><a href="#">Get Notification</a></li>
                                  </ul>
                              </div>
                          </div>
                          <div class="media activity-item">
                              <a href="#" class="pull-left">
                                  <img src="img/Friends/guy-3.jpg" alt="Avatar" class="media-object avatar">
                              </a>
                              <div class="media-body">
                                  <p class="activity-title"><a href="#">Michael</a> posted something for <a href="#">Jack Bay</a> <small class="text-muted">- 1h ago</small></p>
                                  <small class="text-muted">Today 07:23 am - 02.05.2014</small>
                                  <div class="activity-attachment">
                                      <div class="well well-sm">
                                          Professionally evolve corporate services without ethical leadership. Proactively re-engineer client-focused infrastructures before alternative potentialities. Competently predominate just in time e-tailers for leveraged solutions. Intrinsicly initiate end-to-end collaboration and idea-sharing after 24/365 ROI. Rapidiously.
                                      </div>
                                  </div>
                              </div>
                              <div class="btn-group pull-right activity-actions">
                                  <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown">
                                      <i class="fa fa-th"></i>
                                      <span class="sr-only">Toggle Dropdown</span>
                                  </button>
                                  <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                      <li><a href="#">I don't want to see this</a></li>
                                      <li><a href="#">Unfollow Michael</a></li>
                                      <li class="divider"></li>
                                      <li><a href="#">Get Notification</a></li>
                                  </ul>
                              </div>
                          </div>
                          <div class="media activity-item">
                              <a href="#" class="pull-left">
                                  <img src="img/Friends/guy-5.jpg" alt="Avatar" class="media-object avatar">
                              </a>
                              <div class="media-body">
                                  <p class="activity-title"><a href="#">Jack Bay</a> has uploaded two photos <small class="text-muted">- Yesterday</small></p>
                                  <small class="text-muted">Yesterday 06:42 pm - 01.05.2014</small>
                                  <div class="activity-attachment">
                                      <div class="row">
                                          <div class="col-md-6">
                                              <a href="#" class="thumbnail">
                                                  <img src="img/Friends/guy-1.jpg" alt="Uploaded photo">
                                              </a>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="btn-group pull-right activity-actions">
                                  <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown">
                                      <i class="fa fa-th"></i>
                                      <span class="sr-only">Toggle Dropdown</span>
                                  </button>
                                  <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                      <li><a href="#">I don't want to see this</a></li>
                                      <li><a href="#">Unfollow Jack Bay</a></li>
                                      <li class="divider"></li>
                                      <li><a href="#">Get Notification</a></li>
                                  </ul>
                              </div>
                          </div>
                          <div class="media activity-item">
                              <a href="#" class="pull-left">
                                  <img src="img/Friends/guy-6.jpg" alt="Avatar" class="media-object avatar">
                              </a>
                              <div class="media-body">
                                  <p class="activity-title"><a href="#">Jack Bay</a> has changed his profile picture <small class="text-muted">- 2 days ago</small></p>
                                  <small class="text-muted">2 days ago 05:42 pm - 30.04.2014</small>
                                  <div class="activity-attachment">
                                      <a href="#" class="thumbnail">
                                          <img src="img/Friends/guy-1.jpg" alt="Uploaded photo">
                                      </a>
                                  </div>
                              </div>
                              <div class="btn-group pull-right activity-actions">
                                  <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown">
                                      <i class="fa fa-th"></i>
                                      <span class="sr-only">Toggle Dropdown</span>
                                  </button>
                                  <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                      <li><a href="#">I don't want to see this</a></li>
                                      <li><a href="#">Unfollow Jack Bay</a></li>
                                      <li class="divider"></li>
                                      <li><a href="#">Get Notification</a></li>
                                  </ul>
                              </div>
                          </div>
                          <button type="button" class="btn btn-default center-block"><i class="fa fa-refresh"></i> Load more activities</button>
                      </div>
                      <!-- end activities -->
                      <!-- followers -->
                      <div class="tab-pane fade" id="followers">
                          <div class="media user-follower">
                              <img src="img/Friends/guy-1.jpg" alt="User Avatar" class="media-object pull-left">
                              <div class="media-body">
                                  <a href="#">Antonius<br><span class="text-muted username">@mrantonius</span></a>
                                  <button type="button" class="btn btn-sm btn-toggle-following pull-right">
                                  <i class="fa fa-checkmark-round"></i> <span>Following</span></button>
                              </div>
                          </div>
                          <div class="media user-follower">
                              <img src="img/Friends/guy-2.jpg" alt="User Avatar" class="media-object pull-left">
                              <div class="media-body">
                                  <a href="#">Michael<br><span class="text-muted username">@iamichael</span></a>
                                  <button type="button" class="btn btn-sm btn-default pull-right">
                                  <i class="fa fa-plus"></i> Follow</button>
                              </div>
                          </div>
                          <div class="media user-follower">
                              <img src="img/Friends/woman-3.jpg" alt="User Avatar" class="media-object pull-left">
                              <div class="media-body">
                                  <a href="#">Stella<br><span class="text-muted username">@stella</span></a>
                                  <button type="button" class="btn btn-sm btn-default pull-right">
                                  <i class="fa fa-plus"></i> Follow</button>
                              </div>
                          </div>
                          <div class="media user-follower">
                              <img src="img/Friends/woman-4.jpg" alt="User Avatar" class="media-object pull-left">
                              <div class="media-body">
                                  <a href="#">Jane Doe<br><span class="text-muted username">@janed</span></a>
                                  <button type="button" class="btn btn-sm btn-toggle-following pull-right">
                                  <i class="fa fa-checkmark-round"></i> <span>Following</span></button>
                              </div>
                          </div>
                          <div class="media user-follower">
                              <img src="img/Friends/guy-5.jpg" alt="User Avatar" class="media-object pull-left">
                              <div class="media-body">
                                  <a href="#">John Simmons<br><span class="text-muted username">@jsimm</span></a>
                                  <button type="button" class="btn btn-sm btn-default pull-right">
                                  <i class="fa fa-plus"></i> Follow</button>
                              </div>
                          </div>
                          <div class="media user-follower">
                              <img src="img/Friends/guy-6.jpg" alt="User Avatar" class="media-object pull-left">
                              <div class="media-body">
                                  <a href="#">Antonius<br><span class="text-muted username">@mrantonius</span></a>
                                  <button type="button" class="btn btn-sm btn-toggle-following pull-right">
                                  <i class="fa fa-checkmark-round"></i> <span>Following</span></button>
                              </div>
                          </div>
                          <div class="media user-follower">
                              <img src="img/Friends/guy-6.jpg" alt="User Avatar" class="media-object pull-left">
                              <div class="media-body">
                                  <a href="#">Michael<br><span class="text-muted username">@iamichael</span></a>
                                  <button type="button" class="btn btn-sm btn-default pull-right">
                                  <i class="fa fa-plus"></i> Follow</button>
                              </div>
                          </div>
                          <div class="media user-follower">
                              <img src="img/Friends/woman-7.jpg" alt="User Avatar" class="media-object pull-left">
                              <div class="media-body">
                                  <a href="#">Stella<br><span class="text-muted username">@stella</span></a>
                                  <button type="button" class="btn btn-sm btn-default pull-right">
                                  <i class="fa fa-plus"></i> Follow</button>
                              </div>
                          </div>
                          <div class="media user-follower">
                              <img src="img/Friends/woman-1.jpg" alt="User Avatar" class="media-object pull-left">
                              <div class="media-body">
                                  <a href="#">Jane Doe<br><span class="text-muted username">@janed</span></a>
                                  <button type="button" class="btn btn-sm btn-toggle-following pull-right">
                                  <i class="fa fa-checkmark-round"></i> <span>Following</span></button>
                              </div>
                          </div>
                          <div class="media user-follower">
                              <img src="img/Friends/guy-2.jpg" alt="User Avatar" class="media-object pull-left">
                              <div class="media-body">
                                  <a href="#">John Simmons<br><span class="text-muted username">@jsimm</span></a>
                                  <button type="button" class="btn btn-sm btn-default pull-right">
                                  <i class="fa fa-plus"></i> Follow</button>
                              </div>
                          </div>
                      </div>
                      <!-- end followers -->
                      <!-- following -->
                      <div class="tab-pane fade" id="following">
                          <div class="media user-following">
                              <img src="img/Friends/woman-1.jpg" alt="User Avatar" class="media-object pull-left">
                              <div class="media-body">
                                  <a href="#">Stella<br><span class="text-muted username">@stella</span></a>
                                  <button type="button" class="btn btn-sm btn-danger pull-right">
                                  <i class="fa fa-close-round"></i> Unfollow</button>
                              </div>
                          </div>
                          <div class="media user-following">
                              <img src="img/Friends/woman-2.jpg" alt="User Avatar" class="media-object pull-left">
                              <div class="media-body">
                                  <a href="#">Jane Doe<br><span class="text-muted username">@janed</span></a>
                                  <button type="button" class="btn btn-sm btn-danger pull-right">
                                  <i class="fa fa-close-round"></i> Unfollow</button>
                              </div>
                          </div>
                          <div class="media user-following">
                              <img src="img/Friends/guy-3.jpg" alt="User Avatar" class="media-object pull-left">
                              <div class="media-body">
                                  <a href="#">John Simmons<br><span class="text-muted username">@jsimm</span></a>
                                  <button type="button" class="btn btn-sm btn-danger pull-right">
                                  <i class="fa fa-close-round"></i> Unfollow</button>
                              </div>
                          </div>
                          <div class="media user-following">
                              <img src="img/Friends/guy-4.jpg" alt="User Avatar" class="media-object pull-left">
                              <div class="media-body">
                                  <a href="#">Antonius<br><span class="text-muted username">@mrantonius</span></a>
                                  <button type="button" class="btn btn-sm btn-danger pull-right">
                                  <i class="fa fa-close-round"></i> Unfollow</button>
                              </div>
                          </div>
                          <div class="media user-following">
                              <img src="img/Friends/guy-5.jpg" alt="User Avatar" class="media-object pull-left">
                              <div class="media-body">
                                  <a href="#">Michael<br><span class="text-muted username">@iamichael</span></a>
                                  <button type="button" class="btn btn-sm btn-danger pull-right">
                                  <i class="fa fa-close-round"></i> Unfollow</button>
                              </div>
                          </div>
                          <div class="media user-following">
                              <img src="img/Friends/woman-6.jpg" alt="User Avatar" class="media-object pull-left">
                              <div class="media-body">
                                  <a href="#">Stella<br><span class="text-muted username">@stella</span></a>
                                  <button type="button" class="btn btn-sm btn-danger pull-right">
                                  <i class="fa fa-close-round"></i> Unfollow</button>
                              </div>
                          </div>
                      </div>
                      <!-- end following -->
                  </div>
              </div>
          </div>
        </div>
      </div>
      </div>
      </div>
    </div>



  <?php } ?>  
    

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

<!-- Mirrored from demos.bootdey.com/dayday/profile3.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 08 May 2017 15:35:19 GMT -->
</html>
