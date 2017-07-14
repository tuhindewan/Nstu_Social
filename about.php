
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
    <link href="assets/css/user_detail.css" rel="stylesheet">
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
                       session_destroy();
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
    <div class="row page-content">
      <div class="col-md-8 col-md-offset-2">
        <div class="row">
          <div class="col-md-12">
              <div class="cover profile">
              <?php
               $getCOImage = $edt->getCoverImage($userId);
               if ($getCOImage) {
                 while ($coImage = $getCOImage->fetch_assoc()) {

               ?>
               <?php 
               if ($coImage['cover']) { ?>
                 <div class="wrapper">
                  <img width="888px" height="250px" src="<?php echo $coImage['cover']; ?>" class="show-in-modal" alt="people">
                </div>
               <?php  } else{ ?>
                <div class="wrapper">
                  <img width="888px" height="250px" src="img/blank.jpg" class="show-in-modal" alt="people">
                </div>
                <?php }  ?>
              <?php }} ?>
              <div class="cover-info">
              <?php
               $getProImage = $edt->getProfileImage($userId);
               if ($getProImage) {
                 while ($proImage = $getProImage->fetch_assoc()) {

               ?>
               <?php 
               if ($proImage['avatar']) { ?>
                 <div class="avatar">
                  <img src="<?php echo $proImage['avatar']; ?>" width="114px" height="114px" alt="Upload An Image ">
                </div>
             <?php  } else{ ?>
                        <div class="avatar">
                        <img src="img/nophoto.jpg" width="114px" height="114px" alt="Upload An Image ">
                      </div>
              <?php }  ?>
                
                <?php }} ?>
                <div class="name"><a href="#"><?php echo $username ?></a></div>
                <ul class="cover-nav">
                  <li><a href="profile.php"><i class="fa fa-fw fa-bars"></i> Timeline</a></li>
                  <li class="active"><a href="about.php"><i class="fa fa-fw fa-user"></i> About</a></li>
                  <li><a href="friends.html"><i class="fa fa-fw fa-users"></i> Friends</a></li>
                  <li><a href="photos1.html"><i class="fa fa-fw fa-image"></i> Photos</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>

     <div class="col-md-8 col-md-offset-2">
        <div class="row">
          <div class="col-md-12">
            <div class="widget">
            <div class="widget-body">
            <?php 
            require_once 'classes/Information.php';
            $info = new Information();
            $getInfo = $info->getInformation($userId);
            if ($getInfo) {
              while ($value = $getInfo->fetch_assoc()) { ?>
                <div class="row">
              <div class="col-md-5 col-md-6 col-xs-12">
                <div class="row content-info">
                  <div class="col-xs-4">
                    Birthday:
                  </div>
                  <div class="col-xs-8">
                    <?php echo date("M j, Y",strtotime($value['birthDate']));  ?>
                  </div>
                  <div class="col-xs-4">
                    Gender:
                  </div>
                  <div class="col-xs-8">
                    <?php echo $value['gender'];  ?>
                  </div>
                  <div class="col-xs-4">
                    Deepartment:
                  </div>
                  <div class="col-xs-8">
                    <?php echo $value['department'];  ?>
                  </div>
                  <div class="col-xs-4">
                    Session:
                  </div>
                  <div class="col-xs-8">
                    <?php echo $value['session'];  ?>
                  </div>
                  <div class="col-xs-4">
                   Status:
                  </div>
                  <div class="col-xs-8">
                    <?php echo $value['status'];  ?>
                  </div>
                  <div class="col-xs-4">
                    Email:
                  </div>
                  <div class="col-xs-8">
                    <?php echo $value['email'];  ?>
                  </div>
                  <div class="col-xs-4">
                    Phone:
                  </div>
                  <div class="col-xs-8">
                    <?php echo $value['phone'];  ?>
                  </div>
                  <div class="col-xs-4">
                    Lives in:
                  </div>
                  <div class="col-xs-8">
                    <?php echo ucfirst($value['address']);  ?>
                  </div>
                  <div class="col-xs-4">
                    URL:
                  </div>
                  <div class="col-xs-8">
                   <a href="<?php echo $value['website'];  ?>"><?php echo $value['website'];  ?></a>
                  </div>
                </div>
              </div>
              <div class="col-lg-7 col-md-6 col-xs-12">
                <p class="contact-description"><?php echo $value['about']; ?></p>
              </div>
            </div>



            
          <?php }} else{?>
              <div class='alert alert-success' role='alert'>We have no any information about you.Please <a href="editProfile.php"><strong>Click Here</strong></a>.</div>
          <?php } ?>

          </div>
          </div>
          </div>
        </div>
        </div>
      </div>

    <footer class="footer">
      <div class="container">
        <p class="text-muted"> Copyright &copy; Company - All rights reserved </p>
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

<!-- Mirrored from demos.bootdey.com/dayday/about.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 08 May 2017 15:35:46 GMT -->
</html>
