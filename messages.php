<?php 
require_once 'lib/session.php';
Session::checkSession();
Session::init();
$cstrong = True;
$token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
if (!isset($_SESSION['token'])) {
        $_SESSION['token'] = $token;
}
require_once 'lib/database.php';
$db = new Database();
$userId = Session::get("userid");
$username = Session::get("fullname");
$userName = Session::get("userName");
?>
<?php  

$query = "SELECT avatar FROM users WHERE id = '$userId'";
$result = $db->select($query);
if ($result) {
  while ($value = $result->fetch_assoc()) {
    $avatar = $value['avatar'];
  }
}

?>
<?php 
require_once 'classes/Message.php';
$msg = new Message();

 ?>

<!DOCTYPE html>
<html lang="en">
  
<!-- Mirrored from demos.bootdey.com/dayday/messages2.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 08 May 2017 15:36:05 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <link rel="icon" href="img/nstu.png">
    <title>NSTUSocial | A Social Communication Site For NSTU</title>
    <!-- Bootstrap core CSS -->
    <link href="bootstrap.3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome.4.6.1/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/animate.min.css" rel="stylesheet">
    <link href="assets/css/timeline.css" rel="stylesheet">
    <link href="assets/css/cover.css" rel="stylesheet">
    <link href="assets/css/forms.css" rel="stylesheet">
    <link href="assets/css/buttons.css" rel="stylesheet">
    <link href="assets/css/messages2.css" rel="stylesheet">
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

    <!-- Begin page content -->
    <div class="container page-content">
    <div class="row">
      <div class="tile tile-alt" id="messages-main">
      <div class="ms-menu">
          <div class="ms-user clearfix">
              <img src="<?php echo $avatar; ?>" alt="" class="img-avatar pull-left">
              <div>Signed in as <br> <?php echo $userName; ?></div>
          </div>
          
          <div class="p-15">
              <div class="dropdown">
                  <a class="btn btn-azure btn-block" href="#" data-toggle="dropdown">Contacts</a>
              </div>
          </div>
          
          <div class="list-group lg-alt">
            <?php 
               $query = "SELECT * FROM followers WHERE follower_id = '$userId'";
                $result = $db->select($query);
              if ($result) {
              foreach ($result as $value) {
                $friendId = $value['user_id'];

              $sel_query = "SELECT * FROM users WHERE id = '$friendId'";
              $res = $db->select($sel_query);
              if ($res) {
              foreach ($res as  $value) {


             ?>

              <a class="list-group-item media" href="messages.php?friendId=<?php echo $friendId; ?>">
                    <?php 
                    if ($value['avatar']) { ?>
                      <div class="pull-left">
                      <img src="<?php echo $value['avatar']; ?>" alt="" class="img-avatar">
                      </div>
                   <?php }else{ ?>
                  <div class="pull-left">
                      <img src="img/nophoto.jpg" alt="" class="img-avatar">
                  </div>
                 <?php  }    ?>


                  <div class="media-body">
                      <small class="list-group-item-heading"><?php echo $value['fullName']; ?></small><br>
                      <small class="list-group-item-text c-gray"><?php echo $value['username']; ?> </small>
                  </div>
              </a>

            <?php }}}} ?>
          </div>
      </div>

<?php 

if (isset($_GET['friendId'])) { ?>
        

        <div class="ms-body">
          <div class="action-header clearfix">
              <div class="visible-xs" id="ms-menu-trigger">
                  <i class="fa fa-bars"></i>
              </div>

              <?php 
              $friendId = $_GET['friendId'];
              $query = "SELECT * FROM users WHERE id = '$friendId'";
              $result = $db->select($query);
              if ($result) {
                foreach ($result as  $value) {

               ?>
              <div class="pull-left hidden-xs">
                  <?php 
                  if ($value['avatar']) { ?>
                    <img src="<?php echo $value['avatar']; ?>" alt="" class="img-avatar m-r-10">
                 <?php }else{?>
                  <img src="img/nophoto.jpg" alt="" class="img-avatar m-r-10">
                 <?php } ?>


                  <div class="lv-avatar pull-left">
                      
                  </div>
                  <span><?php echo $value['fullName']; ?></span>
              </div>

               <?php }} ?> 
          </div>

                <?php 
                $sendMsg = $msg->getSendMessage($userId);
                if ($sendMsg) {
                  foreach ($sendMsg as  $value) {
                    $sender = $value['sender'];

                 ?>
          <div class="message-feed media">
          <?php 
          $query = "SELECT avatar FROM users WHERE id = '$sender'";
          $res = $db->select($query);
          if ($res) {
           foreach ($res as $result) {

           ?>
              <div class="pull-left">
                  <img src="<?php echo $result['avatar']; ?>" alt="" class="img-avatar">
              </div>
          <?php }} ?>
              <div class="media-body">
                  <div class="mf-content">
                      <?php echo $value['body']; ?>
                  </div>
                  <small class="mf-date"><i class="fa fa-clock-o"></i> <?php echo  date("M j, Y h:ia",strtotime($value['time'])) ; ?></small>
              </div>

          </div>
               <?php }} ?>  
               
          
          <div class="msb-reply">
          <?php 
          if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['send'])) {
            $friendId = $_GET['friendId'];
            $userMsg = $msg->userMessageData($_POST,$userId,$friendId);
          }

           ?>
            <form action="" method="POST">
              <textarea name="message" placeholder="Type messages..."></textarea>
              <button type="submit" name="send"><i class="fa fa-paper-plane-o"></i></button>
            </form>
          </div>
      </div>
<?php }else{?>

      <div class="ms-body">
          <h3 style="color: #2dc3e8;">First choose your friend for beginning the conversetion.</h3>
      </div>

<?php } ?>





      </div>
    </div>
    </div>

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

<!-- Mirrored from demos.bootdey.com/dayday/messages2.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 08 May 2017 15:36:06 GMT -->
</html>
