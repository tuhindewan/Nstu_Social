<?php 

require_once 'lib/session.php';
Session::checkSession();
Session::init();
$userId = Session::get("userid");
$username = Session::get("fullname");
require_once 'lib/database.php';
$db = new Database();

?>
<!DOCTYPE html>
<html lang="en"> 
<!-- Mirrored from demos.bootdey.com/dayday/friends2.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 08 May 2017 15:35:46 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <link rel="icon" href="img/favicon.png">
    <title>Day-Day</title>
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
          <a class="navbar-brand" href="index-2.html"><b>DayDay</b></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="actives"><a href="profile.html">Profile</a></li>
            <li><a href="home.html">Home</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                Pages <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li><a href="profile2.html">Profile 2</a></li>
                <li><a href="profile3.html">Profile 3</a></li>
                <li><a href="profile4.html">Profile 4</a></li>
                <li><a href="sidebar_profile.html">Sidebar profile</a></li>
                <li><a href="user_detail.html">User detail</a></li>
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

$query = "SELECT * FROM users WHERE id != '$userId'";
$result = $db->select($query);
if ($result) {
  while ($value = $result->fetch_assoc()) {
    
?>

          <div class="col-md-4">
            <div class="panel panel-default">
              <div class="panel-heading">
                <div class="media">
                  <div class="pull-left">
                    <img src="img/Friends/guy-1.jpg" alt="people" class="media-object img-circle">
                  </div>
                  <div class="media-body">
                    <h4 class="media-heading margin-v-5"><a href="usersProfile.php?userId=<?php echo $value['id']; ?>"><?php echo $value['fullName']; ?></a></h4>
                    <div class="profile-icons">
                      <span><i class="fa fa-users"></i> 372</span>
                      <span><i class="fa fa-photo"></i> 43</span>
                      <span><i class="fa fa-video-camera"></i> 3</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="panel-body">
                <p class="common-friends">Common Friends</p>
                <div class="user-friend-list">
                  <a href="#">
                    <img src="img/Friends/guy-5.jpg" alt="people" class="img-circle">
                  </a>
                  <a href="#">
                    <img src="img/Friends/guy-6.jpg" alt="people" class="img-circle">
                  </a>
                  <a href="#">
                    <img src="img/Friends/woman-6.jpg" alt="people" class="img-circle">
                  </a>
                  <a href="#">
                    <img src="img/Friends/woman-4.jpg" alt="people" class="img-circle">
                  </a>
                </div>
              </div>
              <div class="panel-footer">
                <a href="#" class="btn btn-azure btn-sm">Follow <i class="fa fa-share"></i></a>
              </div>
            </div>
          </div>
<?php }} ?>

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

<!-- Mirrored from demos.bootdey.com/dayday/friends2.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 08 May 2017 15:35:46 GMT -->
</html>