<?php 
require_once 'lib/session.php';

Session::checkSession();
Session::init();
$username = Session::get("fullname");
?>
<?php 
require_once 'classes/EditProfile.php';
$edt = new EditProfile();
?>

<?php
$userId = Session::get('userid');
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['saveChanges'])) {
  $changePass = $edt->updatePassword($POST,$userId);
}

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
    <script src="assets/js/custom.js"></script>
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
            <li><a href="home.html">Home</a></li>
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

    <div class="container page-content edit-profile">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
        <?php 
          if (isset($changePass)) {
            echo $changePass;
          }
        ?>

            <!-- NAV TABS -->
          <ul class="nav nav-tabs nav-tabs-custom-colored tabs-iconized">
            <li class="active"><a href="#profile-tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-user"></i> Profile</a></li>
            <li class=""><a href="#activity-tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-rss"></i> Recent Activity</a></li>
            <li class=""><a href="#settings-tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> Settings</a></li>
          </ul>
          <!-- END NAV TABS -->
          <div class="tab-content profile-page">
            <!-- PROFILE TAB CONTENT -->
            <?php
              if (isset($_POST['uploadAvatar'])) {
                     $changeAvatar =  $edt->changeAvatar($_FILES,$userId);
              }
              ?>

              <?php 

          if (isset($changeAvatar)) {
            echo $changeAvatar;
          }
         ?>

         <?php
              if (isset($_POST['uploadCover'])) {
                     $changeCover =  $edt->changeCover($_FILES,$userId);
              }
              ?>

               <?php 

          if (isset($changeCover)) {
            echo $changeCover;
          }
         ?>

         
            <div class="tab-pane profile active" id="profile-tab">
              <div class="row">
                <div class="col-md-3">
                  <div class="user-info-left">
                  <?php
                   $getProImage = $edt->getProfileImage($userId);
                   if ($getProImage) {
                     while ($proImage = $getProImage->fetch_assoc()) {

                   ?>
                   <?php 

                    if ($proImage['avatar']) { ?>
                      <img src="<?php echo $proImage['avatar']; ?>" width="114px" height="114px" alt="Profile Picture">
                   <?php }else{ ?>
                          <img src="img/nophoto.jpg" width="114px" height="114px" alt="Profile Picture">
                <?php }  ?>
                    
                    <?php }} ?>
                    <h2><?php echo $username; ?></h2>
                    <div class="contact">
                      <p>
                        <form action="editProfile.php" method="POST" enctype="multipart/form-data">
                          <span class="file-input btn btn-azure btn-file">
                          Choose Avatar <input type="file" multiple="" name="avatar">
                        </span>
                        <input type="submit" class="btn btn-success" value="Upload" name="uploadAvatar" >
                        </form>
                      </p>
                      <p>
                        <form action="editProfile.php" method="POST" enctype="multipart/form-data">
                          <span class="file-input btn btn-azure btn-file">
                          Choose Cover <input type="file" multiple="" name="cover">
                        </span>
                        <input type="submit" class="btn btn-success" value="Upload" name="uploadCover" >
                        </form>
                      </p>
                      <ul class="list-inline social">
                        <li><a href="#" title="Facebook"><i class="fa fa-facebook-square"></i></a></li>
                        <li><a href="#" title="Twitter"><i class="fa fa-twitter-square"></i></a></li>
                        <li><a href="#" title="Google Plus"><i class="fa fa-google-plus-square"></i></a></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="user-info-right">
                    <div class="basic-info">
                      <h3><i class="fa fa-square"></i> Basic Information</h3>
                      <p class="data-row">
                        <span class="data-name">Username</span>
                        <span class="data-value">jonasmith</span>
                      </p>
                      <p class="data-row">
                        <span class="data-name">Birth Date</span>
                        <span class="data-value">Nov 20, 1988</span>
                      </p>
                      <p class="data-row">
                        <span class="data-name">Gender</span>
                        <span class="data-value">Male</span>
                      </p>
                      <p class="data-row">
                        <span class="data-name">Website</span>
                        <span class="data-value"><a href="#">www.jonasmith.com</a></span>
                      </p>
                      <p class="data-row">
                        <span class="data-name">Last Login</span>
                        <span class="data-value">2 hours ago</span>
                      </p>
                      <p class="data-row">
                        <span class="data-name">Date Joined</span>
                        <span class="data-value">Feb 22, 2012</span>
                      </p>
                    </div>
                    <div class="contact_info">
                      <h3><i class="fa fa-square"></i> Contact Information</h3>
                      <p class="data-row">
                        <span class="data-name">Email</span>
                        <span class="data-value">me@jonasmith.com</span>
                      </p>
                      <p class="data-row">
                        <span class="data-name">Phone</span>
                        <span class="data-value">(1800) 221 - 876543</span>
                      </p>
                      <p class="data-row">
                        <span class="data-name">Address</span>
                        <span class="data-value">Riverside City 66, 80123 Denver<br>Colorado</span>
                      </p>
                    </div>
                    <div class="about">
                      <h3><i class="fa fa-square"></i> About Me</h3>
                      <p>Dramatically facilitate proactive solutions whereas professional intellectual capital. Holisticly utilize competitive e-markets through intermandated meta-services. Objectively.</p>
                      <p>Monotonectally foster future-proof infomediaries before principle-centered interfaces. Assertively recaptiualize cutting-edge web services rather than emerging "outside the box" thinking. Phosfluorescently cultivate resource maximizing technologies and user-centric convergence. Completely underwhelm cross functional innovation vis-a-vis.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- END PROFILE TAB CONTENT -->
        
            <!-- ACTIVITY TAB CONTENT -->
            <div class="tab-pane activity" id="activity-tab">
              <ul class="list-unstyled activity-list">
                <li>
                  <i class="fa fa-times activity-icon pull-left"></i>
                  <p>
                    <a href="#">Jonathan</a> commented on <a href="#">Special Deal 2013</a> <span class="timestamp">12 minutes ago</span>
                  </p>
                </li>
                <li>
                  <i class="fa fa-times activity-icon pull-left"></i>
                  <p>
                    <a href="#">Jonathan</a> posted <a href="#">a new blog post</a> <span class="timestamp">4 hours ago</span>
                  </p>
                </li>
                <li>
                  <i class="fa fa-times activity-icon pull-left"></i>
                  <p>
                    <a href="#">Jonathan</a> edited his profile <span class="timestamp">11 hours ago</span>
                  </p>
                </li>
                <li>
                  <i class="fa fa-times activity-icon pull-left"></i>
                  <p>
                    <a href="#">Jonathan</a> has added review on <a href="#">jQuery Complete Guide</a> book <span class="timestamp">Yesterday</span>
                  </p>
                </li>
                <li>
                  <i class="fa fa-times activity-icon pull-left"></i>
                  <p>
                    <a href="#">Jonathan</a> liked <a href="#">a post</a> <span class="timestamp">December 12</span>
                  </p>
                </li>
                <li>
                  <i class="fa fa-times activity-icon pull-left"></i>
                  <p>
                    <a href="#">Jonathan</a> has completed one task <span class="timestamp">December 11</span>
                  </p>
                </li>
                <li>
                  <i class="fa fa-times activity-icon pull-left"></i>
                  <p>
                    <a href="#">Jonathan</a> uploaded <a href="#">new photos</a> <span class="timestamp">December 5</span>
                  </p>
                </li>
                <li>
                  <i class="fa fa-times activity-icon pull-left"></i>
                  <p>
                    <a href="#">Jonathan</a> has updated his credit card info <span class="timestamp">September 28</span>
                  </p>
                </li>
              </ul>
              <p class="text-center more"><a href="#" class="btn btn-custom-primary">View more <i class="fa fa-long-arrow-right"></i></a></p>
            </div>
            <!-- END ACTIVITY TAB CONTENT -->
        
            <!-- SETTINGS TAB CONTENT -->
            <div class="tab-pane settings" id="settings-tab">
              <form class="form-horizontal" role="form" action="" method="POST">
                <fieldset>
                  <h3><i class="fa fa-square"></i> Change Password</h3>
                  <div class="form-group">
                    <label for="old-password" class="col-sm-3 control-label">Old Password</label>
                    <div class="col-sm-4">
                      <input type="password" id="old-password" name="oldPassword" class="form-control">
                    </div>
                  </div>
                  <hr>
                  <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">New Password</label>
                    <div class="col-sm-4">
                      <input type="password" id="password" name="newPassword" class="form-control">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="password2" class="col-sm-3 control-label">Repeat Password</label>
                    <div class="col-sm-4">
                      <input type="password" id="password2" name="passwordRepeat" class="form-control">
                    </div>
                  </div>
                </fieldset>
                <fieldset>
                  <h3><i class="fa fa-square"></i> Privacy</h3>
                  <div class="checkbox">
                    <label>
                        <input type="checkbox" class="colored-blue" checked="checked">
                        <span class="text">Show my display name</span>
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                        <input type="checkbox" class="colored-blue" checked="checked">
                        <span class="text">Show my birth date</span>
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                        <input type="checkbox" class="colored-blue" checked="checked">
                        <span class="text">Show my email</span>
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                        <input type="checkbox" class="colored-blue" checked="checked">
                        <span class="text">Show my online status on chat</span>
                    </label>
                  </div>
                </fieldset>
                <h3><i class="fa fa-square"> </i>Notifications</h3>
                <fieldset>
                  <div class="checkbox">
                    <label>
                        <input type="checkbox" class="colored-blue" checked="checked">
                        <span class="text">Receive message from administrator</span>
                    </label>
                  </div>

                  <div class="checkbox">
                    <label>
                        <input type="checkbox" class="colored-blue" checked="checked">
                        <span class="text">New product has been added</span>
                    </label>
                  </div>

                  <div class="checkbox">
                    <label>
                        <input type="checkbox" class="colored-blue" checked="checked">
                        <span class="text">Product review has been approved</span>
                    </label>
                  </div>

                  <div class="checkbox">
                    <label>
                        <input type="checkbox" class="colored-blue" checked="checked">
                        <span class="text">Others liked your post</span>
                    </label>
                  </div>
                  <p class="text-center"><button type="submit" name="saveChanges" class=" btn btn-custom-primary"><i class="fa fa-floppy-o"></i> Save Changes</button></p>
                </fieldset>
              </form>
            </div>
            <!-- END SETTINGS TAB CONTENT -->
          </div>
        </div>    
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

<!-- Mirrored from demos.bootdey.com/dayday/edit_profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 08 May 2017 15:35:46 GMT -->
</html>
