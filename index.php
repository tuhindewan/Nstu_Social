<?php 
require_once 'classes/User.php';
$user = new User();
require_once 'classes/UserLogin.php';
$log = new UserLogin();
?>

<?php 
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['register'])) {
   $userReg = $user->userRegistration($_POST);
}
?>
<?php 
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['login'])) {
   $userLog = $log->userLogin($_POST);
}
?>


<!DOCTYPE html>
<html lang="en">
  
<!-- Mirrored from demos.bootdey.com/dayday/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 08 May 2017 15:33:20 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <link rel="icon" href="img/nstu.png">
    <title>NSTUSocial | A social communication site for NSTU</title>
    <!-- Bootstrap core CSS -->
    <link href="bootstrap.3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome.4.6.1/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/animate.min.css" rel="stylesheet">
    <link href="assets/css/timeline.css" rel="stylesheet">
    <link href="assets/css/login_register.css" rel="stylesheet">
    <link href="assets/css/forms.css" rel="stylesheet">
    <link href="assets/css/buttons.css" rel="stylesheet">
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
    <nav class="navbar navbar-fixed-top navbar-transparent" role="navigation">
        <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button id="menu-toggle" type="button" class="navbar-toggle">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar bar1"></span>
            <span class="icon-bar bar2"></span>
            <span class="icon-bar bar3"></span>
          </button>
          <a class="navbar-brand" href="index.php">NSTUSocial</a>
        </div>
      </div>
    </nav>
    <div class="wrapper">
      <div class="parallax filter-black">
          <div class="parallax-image"></div>             
          <div class="small-info">
            <div class="col-sm-10 col-sm-push-1 col-md-6 col-md-push-3 col-lg-6 col-lg-push-3">
              <div class="card-group animated flipInX">
                <div class="card">
                  <div class="card-block">
                    <div class="center">
                    <?php 
                      if (isset($userLog)) {
                        echo $userLog;
                      }
                    ?>
                      <h4 class="m-b-0"><span class="icon-text">Login</span></h4>
                      <p class="text-muted">Access your account</p>
                    </div>
                    <form action="" method="POST">
                      <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="Email Address">
                      </div>
                      <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        <a href="forgotPassword.php" class="pull-xs-right">
                          <small>Forgot?</small>
                        </a>
                        <div class="clearfix"></div>
                      </div>
                      <div class="center">
                        <button type="submit" name="login" class="btn btn-azure">Login</button>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="card">
                  <div class="card-block center">
                  <?php 
                      if (isset($userReg)) {
                        echo $userReg;
                      }
                  ?>
                    <h4 class="m-b-0">
                      <span class="icon-text">Sign Up</span>
                    </h4>
                    <p class="text-muted">Create a new account</p>
                    <form action="" method="POST">
                      <div class="form-group">
                        <input type="text" class="form-control" name="fullname" placeholder="Full Name">
                      </div>
                      <div class="form-group">
                        <input type="text" class="form-control" name="username" placeholder="Username">
                      </div>
                      <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="Email">
                      </div>
                      <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                      </div>
                      <div class="form-group">
                        <input type="password" class="form-control" name="confirmPassword" placeholder="Confirm Password">
                      </div>
                      <button type="submit" class="btn btn-azure" name="register">Register</button>
                    </form>
                  </div>
                </div>
              </div>
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
    </div>
  </body>

<!-- Mirrored from demos.bootdey.com/dayday/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 08 May 2017 15:33:34 GMT -->
</html>
