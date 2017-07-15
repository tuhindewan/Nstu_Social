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

  if (isset($_POST['send'])) {
    if (!isset($_POST['nocsrf'])) {
                die("INVALID TOKEN");
        }
        if ($_POST['nocsrf'] != $_SESSION['token']) {
                die("INVALID TOKEN");
        }
    $body = $_POST['body'];
    $receiver = htmlspecialchars($_GET['receiver']);
    $query = "SELECT id FROM users WHERE id = '$receiver'";
    $result = $db->select($query);
    if ($result) {
      $query = "INSERT INTO messages (body,sender,receiver,seen,time) VALUES ('$body','$userId','$receiver','0',NOW())";
      $resut = $db->insert($query);
      if ($resut) {
        echo "message sent";
    }
    }else{
      die("Invalid ID");
    }
    
  }

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
      


      <?php 
        if (isset($_GET['msgId'])) { ?>


          <div class="ms-body">
          <div class="action-header clearfix">
              <div class="visible-xs" id="ms-menu-trigger">
                  <i class="fa fa-bars"></i>
              </div>
              
              <div class="pull-left hidden-xs">
                  <img src="img/Friends/guy-2.jpg" alt="" class="img-avatar m-r-10">
                  <div class="lv-avatar pull-left">
                      
                  </div>
                  <span>David Parbell</span>
              </div>
               
              <ul class="ah-actions actions">
                  <li>
                      <a href="#">
                          <i class="fa fa-trash"></i>
                      </a>
                  </li>
                  <li>
                      <a href="#">
                          <i class="fa fa-check"></i>
                      </a>
                  </li>
                  <li>
                      <a href="#">
                          <i class="fa fa-clock-o"></i>
                      </a>
                  </li>
                  <li class="dropdown">
                      <a href="#" data-toggle="dropdown" aria-expanded="true">
                          <i class="fa fa-sort"></i>
                      </a>
          
                      <ul class="dropdown-menu dropdown-menu-right">
                          <li>
                              <a href="#">Latest</a>
                          </li>
                          <li>
                              <a href="#">Oldest</a>
                          </li>
                      </ul>
                  </li>                             
                  <li class="dropdown">
                      <a href="#" data-toggle="dropdown" aria-expanded="true">
                          <i class="fa fa-bars"></i>
                      </a>
          
                      <ul class="dropdown-menu dropdown-menu-right">
                          <li>
                              <a href="#">Refresh</a>
                          </li>
                          <li>
                              <a href="#">Message Settings</a>
                          </li>
                      </ul>
                  </li>
              </ul>
          </div>
        
      

          <?php 


          $msgId = $_GET['msgId'];            
          $query = "SELECT * FROM messages WHERE id = '$msgId' AND (receiver = '$userId' OR sender = '$userId')";
          $messages = $db->select($query);
          if ($messages) {
            foreach ($messages as $message) {
              $sender = $message['sender'];
              $query = "SELECT * FROM users WHERE id = '$sender' ";
              $result = $db->select($query);
              if ($result) {
                foreach ($result as $sender ) {
         ?>

          <div class="message-feed media">
          <?php 
          if ($sender['avatar']) { ?>
            <div class="pull-left">
                  <img src="<?php echo $sender['avatar']; ?>" alt="" class="img-avatar">
              </div>
        <?php  }else{ ?>

        <div class="pull-left">
                  <img src="img/nophoto.jpg" alt="" class="img-avatar">
              </div>
        <?php }   ?>
              
              <div class="media-body">
                  <div class="mf-content">
                      <?php echo htmlspecialchars($message['body']); ?>
                  </div>
     
                  <small class="mf-date"><i class="fa fa-clock-o"></i> <?php echo  date("M j, Y h:ia",strtotime($message['time'])) ; ?></small>
              </div>
          </div>
          <?php }} ?>
        <?php }} ?>
          
          <?php 

        if ($message['sender'] == $userId) {
                $id = $message['receiver'];
        } else {
                $id = $message['sender'];
        }

        $query = "UPDATE messages SET seen = '1' WHERE id = '$msgId'";
        $update = $db->update($query);

           ?>

          <form action="messages.php?receiver=<?php echo $id;?>" method="POST" >
            
              <div class="msb-reply">
                  <textarea name="body" placeholder="Type Message Here..."></textarea>
                  <input type="hidden" name="nocsrf" value="<?php echo $_SESSION['token']; ?>">
                  <button type="submit" name="send"><i class="fa fa-paper-plane-o"></i></button>
              </div>

          </form>
      </div>
              
           <?php }else{ ?>
            <div class="ms-menu">
          <div class="ms-user clearfix">
          <?php 
            if ($avatar) { ?>
              <img src="<?php echo $avatar; ?>" alt="" class="img-avatar pull-left">
           <?php }else{ ?>
           <img src="img/nophoto.jpg" alt="" class="img-avatar pull-left">
       <?php  }   ?>
              
              <div>Signed in as <br> <?php echo $username ?> <br>

                  Username: <small><?php echo $userName; ?></small>
              </div>
          </div>
          
          <div class="p-15">
              <div class="dropdown">
                <a class="btn btn-azure btn-block" href="#" data-toggle="dropdown">Messages</a>
              </div>
          </div>
          
          <div class="list-group lg-alt">
              <?php 

                $query = "SELECT * FROM messages WHERE sender = '$userId' OR receiver = '$userId' ";
                $messages = $db->select($query);
                if ($messages) {
                  foreach ($messages as $message) {
                    if (strlen($message['body']) > 10) {
                            $m = substr($message['body'], 0, 10)." ....";
                    } else {
                            $m = $message['body'];
                    }
                    $sender = $message['sender'];
                    $query = "SELECT * FROM users WHERE id = '$sender' ";
                    $result = $db->select($query);
                    if ($result) {
                      foreach ($result as $sender ) {
               ?>
              <a class="list-group-item media" href="messages.php?msgId=<?php echo $message['id']; ?>">
                  <div class="pull-left">
                      <?php 
                        if ($avatar) { ?>
                          <img src="<?php echo $avatar; ?>" alt="" class="img-avatar ">
                       <?php }else{ ?>
                       <img src="img/nophoto.jpg" alt="" class="img-avatar ">
                   <?php  }   ?>
                  </div>
                  <div class="media-body">
                      <?php 
                      if ($message['seen']==0) { ?>
                        <strong><small class="list-group-item-text c-gray"><?php echo $m; ?></small>
                      <h5>FROM</h5>
                      <small class="list-group-item-heading"><?php echo $sender['fullName']; ?></small><br>
                      <small>Unseen</small></strong>
                     <?php }else{ ?>
                        <small class="list-group-item-text c-gray"><?php echo $m; ?></small>
                      <h5>sent by</h5>
                      <small class="list-group-item-heading"><?php echo $sender['fullName']; ?></small><br>
                      <small>Seen</small>
                    <?php }  ?>
                      
                  </div>
              </a> 
              <?php }} ?>
              <?php }} ?>
          </div>        
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
