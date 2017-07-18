<?php 
require_once 'lib/session.php';

Session::checkSession();
Session::init();
$username = Session::get("fullname");
$userName = Session::get("userName");
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
<?php 

require_once 'classes/Information.php';
$info = new Information();
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['updateinfo'])) {
  $updateinfo = $info->updateInformation($_POST,$userId);
}
 ?>
 <?php 
 require_once 'lib/database.php';
 $db = new Database();

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
<style>
  
</style>

  <body>

    <!-- Fixed navbar -->
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

    <div class="container page-content edit-profile">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
        <?php 
          if (isset($changePass)) {
            echo $changePass;
          }
        ?>
        <?php 
        if (isset($saveinfo)) {
           echo $saveinfo;
         } ?>
         <?php 
          if (isset($updateinfo)) {
            echo $updateinfo;
          }
          ?>

            <!-- NAV TABS -->
          <ul class="nav nav-tabs nav-tabs-custom-colored tabs-iconized">
            <li class="active"><a href="#profile-tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-user"></i> Profile</a></li>
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
                    </div>
                  </div>
                </div>
                <div class="col-md-9">

                <form  action="" method="POST">
                      <div class="user-info-right">
                        <div class="basic-info">
                          <h3><i class="fa fa-square"></i> Basic Information</h3>
                            <div class="form-group">
                              <label>Date Of Birth</label>
                              <input type="date" class="form-control" name="dob" placeholder="Date of Birth">
                            </div>
                            <div class="form-group">
                              <div class="form-group">
                                <label for="exampleInputEmail1">Gender</label>
                                  <select class="form-control" name="gender" >
                                    <option  value="Male">Male</option>
                                    <option  value="Female">Female</option>
                                  </select>
                                </div>
                            </div>
                            <div class="form-group">
                              <label>Department</label>
                                  <select class="form-control" name="department">
                                    <option value="Computer Science and Telecommunication Engineering">Computer Science and Telecommunication Engineering</option>
                                    <option value="Applied Chemistry and Chemical Engineering">Applied Chemistry and Chemical Engineering</option>
                                    <option value="Information and Communication Engineering">Information and Communication Engineering</option>
                                  </select>
                            </div>
                            <div class="form-group">
                              <label>Session</label>
                                  <select class="form-control" name="session">
                                    <option value="2011-12">2011-12</option>
                                    <option value="2012-13">2012-13</option>
                                    <option value="2013-14">2013-14</option>
                                  </select>
                            </div>
                           <div class="form-group">
                              <label>Status</label>
                                  <select class="form-control" name="status">
                                    <option value="Sudent" >Sudent</option>
                                    <option value="Alumni">Alumni</option>
                                    <option value="Lecturer">Lecturer</option>
                                    <option value="Assistent Professor">Assistent Professor</option>
                                  </select>
                            </div>
                        </div>
                        <div class="contact_info">
                          <h3><i class="fa fa-square"></i> Contact Information</h3>
                            <div class="form-group">
                              <label>Email</label>
                              <input type="email" class="form-control" name="email" placeholder="Ex- example@gmail.com">
                            </div>
                            <div class="form-group">
                              <label>Phone</label>
                              <input type="text" class="form-control" name="phone" placeholder="">
                            </div>
                            <div class="form-group">
                              <label>Website</label>
                              <input type="text" class="form-control" name="website" placeholder="Ex- example.com">
                            </div>
                            <div class="form-group">
                              <label>Lives in:</label>
                              <input type="text" class="form-control" name="live" placeholder="Ex- Sonapur,Noakhali">
                            </div>
                        </div>
                        <div class="about">
                          <h3><i class="fa fa-square"></i> About Me</h3>
                            <div class="form-group">
                              <textarea class="form-control" name="about" id="" cols="100" rows="10"></textarea>
                            </div>
                        </div>
                      </div>
                      <div class="text-center">
                        <input type="submit" class="btn btn-success btn-lg" value="Update Info" name="updateinfo">
                      </div>
                  </form>
                  


                </div>
              </div>
            </div>
            <!-- END PROFILE TAB CONTENT -->
        
        
            <!-- SETTINGS TAB CONTENT -->
            <div class="tab-pane settings" id="settings-tab">
              <form class="form-horizontal" role="form" action="" method="POST">
                <fieldset>
                  <h3><i class="fa fa-square"></i> Change Password</h3>
                  <div class="form-group">
                    <label for="old-password" class="col-sm-3 control-label">Old Password</label>
                    <div class="col-sm-4">
                      <input type="password" id="old_password" name="oldPassword" class="form-control">
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
                  <p class="text-center"><button type="submit" id="submitform" name="saveChanges" class=" btn btn-custom-primary"><i class="fa fa-floppy-o"></i> Save Changes</button></p>
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
