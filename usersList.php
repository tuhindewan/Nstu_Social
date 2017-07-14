<?php 

require_once 'lib/session.php';
Session::checkSession();
Session::init();
$userId = Session::get("userid");
$username = Session::get("fullname");
$userName = Session::get('userName');
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
    <style>
      input[type=text] {
      width: 130px;
      box-sizing: border-box;
      border: 2px solid #ccc;
      border-radius: 4px;
      font-size: 16px;
      background-color: white;
      background-position: 10px 10px; 
      background-repeat: no-repeat;
      padding: 12px 20px 12px 40px;
      -webkit-transition: width 0.4s ease-in-out;
      transition: width 0.4s ease-in-out;
        }

        input[type=text]:focus {
            width: 100%;
        }
        * {
          box-sizing: border-box;
      }

      #myUL {
          list-style-type: none;
          padding: 0;
          margin: 0;
        }

        #myUL li a {
          border: 1px solid #ddd;
          margin-top: -1px; /* Prevent double borders */
          background-color: #f6f6f6;
          padding: 12px;
          text-decoration: none;
          font-size: 18px;
          color: black;
          display: block
        }

        #myUL li a.header {
          background-color: #e2e2e2;
          cursor: default;
        }

        #myUL li a:hover:not(.header) {
          background-color: #eee;
        }

    </style>
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
          <a class="navbar-brand" href="index-2.html"><b>NSTUSocial</b></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="actives"><a href="profile.php">Profile</a></li>
            <li><a href="newsFeed.php">Home</a></li>
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

      <div class="row">
        <h4 style="margin-left: 18px;">Find Your Friends by Their Name...</h4>
        <div class="col-md-8 col-md-offset2">
          <input type="text" id="myInput" onkeyup="myFunction()" name="search" placeholder="Find...">
        </div>
      </div>
      

      <ul id="myUL">
          <div class="row friends" style="margin-top: 20px;">

          <?php 

          $query = "SELECT * FROM users WHERE id != '$userId' AND username != '$userName'";
          $result = $db->select($query);
          if ($result) {
            while ($value = $result->fetch_assoc()) {
              
          ?>

          <div class="col-md-8">
            <li>
              <div class="panel panel-default">
                <div class="panel-heading">
                  <div class="media">
                  <?php 
                  if ($value['avatar']) { ?>
                    <div class="pull-left">
                      <img src="<?php echo $value['avatar']; ?>" alt="people" class="media-object img-circle">
                    </div>
                <?php  }else{ ?>

                <div class="pull-left">
                      <img src="img/nophoto.jpg" alt="people" class="media-object img-circle">
                    </div>
                 <?php }  ?>
                    

                    <div class="media-body">
                      <h4 class="media-heading margin-v-5"><a href="usersProfile.php?userId=<?php echo $value['id']; ?>&&userName=<?php echo $value['username'] ?>"><?php echo $value['fullName']; ?></a></h4>
                    </div>
                  </div>
                </div>
              </div>
            </li>
          </div>
<?php }} ?>

      </div>
      </ul>



        
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

          function myFunction() {
          var input, filter, ul, li, a, i;
          input = document.getElementById("myInput");
          filter = input.value.toUpperCase();
          ul = document.getElementById("myUL");
          li = ul.getElementsByTagName("li");
          for (i = 0; i < li.length; i++) {
              a = li[i].getElementsByTagName("a")[0];
              if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
                  li[i].style.display = "";
              } else {
                  li[i].style.display = "none";

              }
          }
      }
      </script>
  </body>

<!-- Mirrored from demos.bootdey.com/dayday/friends2.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 08 May 2017 15:35:46 GMT -->
</html>
