
<?php 
require_once 'lib/session.php';
Session::checkSession();
Session::init();
require_once 'lib/database.php';
$db = new Database();
$userId = Session::get("userid");
$username = Session::get("fullname");
$userName = Session::get("userName");
$avatar = Session::get("avatar");

?>
<?php
require_once 'classes/Post.php';
$post = new Post();
require_once 'classes/EditProfile.php';
$edt = new EditProfile();
require_once 'classes/EditPost.php';
$ePost = new EditPost();
?>
<?php
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['post'])) {
  if ($_FILES['postImage']['size'] == 0) {
    $body =  $_POST['body'];
    if (count(notify($body)) != 0) {
      foreach (notify($body) as $key => $n) {
        $query = "SELECT id FROM posts ORDER BY id DESC LIMIT 1";
        $result = $db->select($query);
        if ($result) {
          while ($value = $result->fetch_assoc()) {
            $postId = $value['id'];
          }
        }
        $s = $userId;
        $query = "SELECT id FROM users WHERE username = '$key'";
        $res = $db->select($query);
        if ($res) {
          while ($val = $res->fetch_assoc()) {
            $r = $val['id'];
            if ($r != 0) {
          $query = "INSERT INTO notifications (type,receiver,sender,datetime,post_id) VALUES ('$n','$r','$s',NOW(),'$postId')";
          $result = $db->insert($query);
        }
          }
        }

        
      }
    }
    $topics = getTopics($body);
    $getData = $post->UserSinglePost($_POST,$userId,$topics);
  }else{
        $body =  $_POST['body'];
        if (count(notify($body)) != 0) {
      foreach (notify($body) as $key => $n) {
        $query = "SELECT id FROM posts ORDER BY id DESC LIMIT 1";
        $result = $db->select($query);
        if ($result) {
          while ($value = $result->fetch_assoc()) {
            $postId = $value['id'];
          }
        }
        $s = $userId;
        $query = "SELECT id FROM users WHERE username = '$key'";
        $res = $db->select($query);
        if ($res) {
          while ($val = $res->fetch_assoc()) {
            $r = $val['id'];
            if ($r != 0) {
          $query = "INSERT INTO notifications (type,receiver,sender,datetime,post_id) VALUES ('$n','$r','$s',NOW(),'$postId')";
          $result = $db->insert($query);
        }
          }
        }

        
      }
    }
        $topics = getTopics($body);
    $ImgPostId = $post->createImagePost($_POST,$userId,$topics);

    if ($ImgPostId) {
      while ($value = $ImgPostId->fetch_assoc()) {
        $postImgId = $value['id'];
      }
    }
    $upPostImg = $post->uploadPostImage($_FILES,$postImgId,$userId);
  }
  
}
?>
<?php 

if (isset($_GET['postId']) && !isset($_POST['deletePost'])) {
  $postId = $_GET['postId'];
  $query = "SELECT user_id FROM post_likes WHERE post_id='$postId' AND user_id = '$userId'";
  $result = $db->select($query);
  if ($result==false) {
    $query = "UPDATE posts SET likes=likes+1 WHERE id = '$postId'";
    $result = $db->update($query);
    $query = "INSERT INTO post_likes (post_id,user_id) VALUES ('$postId','$userId')";
    $result = $db->insert($query);
  }else{
    $query = "UPDATE posts SET likes=likes-1 WHERE id = '$postId'";
    $result = $db->update($query);
    $query = "DELETE FROM post_likes WHERE post_id = '$postId' AND user_id = '$userId'";
    $result = $db->delete($query);
  } 
}
?>
<?php 
require_once 'classes/Comment.php';
$cmnt = new Comment();
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['submit_comm']) ) {
  $getComment = $cmnt->createComment($_POST['commentbody'],$_GET['postId2'],$userId);
}
?>

<?php 
function link_add($text) {
$text = explode(" ", $text);
                $newstring = "";

                foreach ($text as $word) {
                        if (substr($word, 0, 1) == "@") {
                                $newstring .= "<a href='usersProfile.php?userName=".substr($word, 1)."'>".htmlspecialchars($word)."</a> ";
                        } else if (substr($word, 0, 1) == "#") {
                                $newstring .= "<a href='topics.php?topic=".substr($word, 1)."'>".htmlspecialchars($word)."</a> ";
                        } else {
                                $newstring .= htmlspecialchars($word)." ";
                        }
                }

                return $newstring;

}


 ?>
 <?php 
function getTopics($text) {
          $text = explode(" ", $text);
          $topics = "";
          foreach ($text as $word) {
                  if (substr($word, 0, 1) == "#") {
                          $topics .= substr($word, 1).",";
                  }
          }
          return $topics;
  }

 ?>

 <?php 
 function notify($text) {
        $text = explode(" ", $text);
        $notify = array();

        foreach ($text as $word) {
                if (substr($word, 0, 1) == "@") {
                        $notify[substr($word, 1)] = 1;
                }
        }

        return $notify;
}
?>
<?php 
require_once 'classes/Information.php';
$info = new Information();
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
                <li class="active"><a href="profile.php"><i class="fa fa-fw fa-bars"></i> Timeline</a></li>
                <li><a href="about.php"><i class="fa fa-fw fa-user"></i> About</a></li>
                <li><a href="friends.php"><i class="fa fa-fw fa-users"></i> Friends</a></li>
                <li><a href="photos.php"><i class="fa fa-fw fa-image"></i> Photos</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-5">
          <div class="widget">
            <div class="widget-header">
              <h3 class="widget-caption">About</h3>
            </div>
            
            <?php 


              $getInfo = $info->getInformation($userId);
              if ($getInfo) {
                while ($value = $getInfo->fetch_assoc()) {

             ?>

            <div class="widget-body bordered-top bordered-sky">
              <ul class="list-unstyled profile-about margin-none">
                <li class="padding-v-5">
                  <div class="row">
                    <div class="col-sm-4"><span class="text-muted">Date of Birth</span></div>
                    <div class="col-sm-8"><?php echo date("M j, Y",strtotime($value['birthDate']));  ?></div>
                  </div>
                </li>
                <li class="padding-v-5">
                  <div class="row">
                    <div class="col-sm-4"><span class="text-muted">Gender</span></div>
                    <div class="col-sm-8"><?php echo $value['gender'];  ?></div>
                  </div>
                </li>
                <li class="padding-v-5">
                  <div class="row">
                    <div class="col-sm-4"><span class="text-muted">Department</span></div>
                    <div class="col-sm-8"><?php echo $value['department'];  ?> </div>
                  </div>
                </li>
                <li class="padding-v-5">
                  <div class="row">
                    <div class="col-sm-4"><span class="text-muted">Status</span></div>
                    <div class="col-sm-8"><?php echo $value['status'];  ?> </div>
                  </div>
                </li>
                <li class="padding-v-5">
                  <div class="row">
                    <div class="col-sm-4"><span class="text-muted">Email</span></div>
                    <div class="col-sm-8"><?php echo $value['email'];  ?></div>
                  </div>
                </li>
                <li class="padding-v-5">
                  <div class="row">
                    <div class="col-sm-4"><span class="text-muted">Lives in</span></div>
                    <div class="col-sm-8"><?php echo ucfirst($value['address']);  ?></div>
                  </div>
                </li>
              </ul>
            </div>

            <?php }} ?>
          </div>

          <div class="widget widget-friends">
            <div class="widget-header">
              <h3 class="widget-caption">Friends</h3>
            </div>
            <div class="widget-body bordered-top  bordered-sky">
              <div class="row">
                <div class="col-md-12">
                  <ul class="img-grid" style="margin: 0 auto;">
                          <?php 

                          $query = "SELECT user_id FROM followers WHERE follower_id = '$userId'";
                          $result = $db->select($query);
                          if ($result) {
                            foreach ($result as $friend_id) {
                                $friend_id = $friend_id['user_id'];

                                $query = "SELECT * FROM users WHERE id = '$friend_id'";
                                $result = $db->select($query);
                                if ($result) {
                                  foreach ($result as $value) {
                         ?>
                    <li>
                    <?php 
                      if ($value['avatar']) { ?>
                        <a href="usersProfile.php?userId=<?php echo $value['id']; ?>&&userName=<?php echo $value['username'] ?>">
                        <img src="<?php echo $value['avatar']; ?>" alt="image">
                      </a>
                    <?php  }else{ ?>
                          <a href="usersProfile.php?userId=<?php echo $value['id']; ?>&&userName=<?php echo $value['username'] ?>">
                        <img src="img/nophoto.jpg" alt="image">
                      </a>
                   <?php }  ?>
                      
                    </li>
                    <?php }}}} ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>






        <!--============= timeline posts-->
        <div class="col-md-7">
          <div class="row">
            <!-- left posts-->
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-12">
                <!-- post state form -->
                <?php if (isset($getData)) {
                  echo $getData;
                } ?>

                  <div class="box profile-info n-border-top">
                  <?php if (isset($upPostImg)) {
                    echo $upPostImg;
                  } ?>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <textarea class="form-control input-lg p-text-area" rows="2" placeholder="Whats in your mind today?" name="body"></textarea>
                        <div class="box-footer box-form">
                        <ul class="nav nav-pills">
                          <li>
                          <span class="file-input btn btn-azure btn-file btn-sm"><i class="fa fa-camera"></i><input type="file" multiple="" name="postImage"></span>
                          </li>
                          <li class="pull-right"><button type="submit" class="btn btn-azure" name="post">Post</button></li>
                        </ul>
                    </div>
                    </form>
                  </div><!-- end post state form -->

                  <?php if (isset($dPost)) {
                    echo $dPost;
                  } ?>

                  <!--  posts -->
                  <?php
                  $getVal = $post->getSinglePost($userId);
                  if ($getVal) {
                    while ($value=$getVal->fetch_assoc()) {
                      $postId = $value["id"];

                      $query = "SELECT post_id FROM post_likes WHERE user_id = '$userId' AND post_id = '$postId'";
                      $like_result = $db->select($query);
                      if ($like_result==false) { ?>
                        <div class="box box-widget">
                    <div class="box-header with-border">
                      <div class="user-block">
                      <div class="btn-group pull-right activity-actions">
                          <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown">
                              <i class="fa fa-th"></i>
                              <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-right" role="menu">
                            <?php 

                              if (isset($_GET['delPost'])) {
                                 $postId =   $_GET['delPost'];
                                 $dPost = $ePost->deleteSinglePost($postId,$userId);
                              }

                             ?>
                              <li><a href="profile.php?delPost=<?php echo $value["id"];?>">  <i class="fa fa-trash" aria-hidden="true"></i> Delete This Post  </a></li>
                          </ul>
                      </div>
                      <?php
                       $getProImage = $edt->getProfileImage($userId);
                       if ($getProImage) {
                         while ($proImage = $getProImage->fetch_assoc()) {

                       ?>
                       <?php 
                        if ($proImage['avatar']) { ?>
                          <img class="img-circle" src="<?php echo $proImage['avatar']; ?>" alt="User Image">
                       <?php }else{?>
                        <img class="img-circle" src="img/nophoto.jpg" alt="User Image">
                     <?php }   ?>
                        
                          <?php }} ?>
                        <span class="username"><a href="#"><?php echo $username ?></a></span>
                        <span class="description">Shared publicly - <?php echo  date("M j, Y h:ia",strtotime($value['posted_at'])) ; ?></span>

                      </div>
                    </div>

                    <div class="box-body" style="display: block;">
                      <p>
                        <?php echo link_add($value["body"]); ?>
                      </p>
                      <?php

                      if ($value["postImage"]) { ?>
                        <img class="img-responsive show-in-modal" src="<?php echo $value["postImage"]; ?>" alt="Photo">
                   <?php   } ?>
                      
                      <form action="profile.php?postId=<?php echo $value["id"]; ?>" method="POST">
                        <button type="submit" class="btn btn-default btn-xs" name="like"><i class="fa fa-thumbs-o-up"></i> Like</button>
                      </form>
                      <span class="pull-right text-muted"><?php echo $value["likes"]; ?> likes - 3 comments</span>
                    </div>
                    <?php 

                    $getcmt = $cmnt->displayComments($postId);
                      if ($getcmt) {
                        while ($value=$getcmt->fetch_assoc()) {

                     ?>
                    <div class="box-footer box-comments" style="display: block;">
                      <div class="box-comment">
                      <?php 
                        if ($value['avatar']) { ?>
                          <img class="img-circle img-sm" src="<?php echo $value['avatar']; ?>" alt="User Image">
                      <?php  }else{?>
                        <img class="img-circle img-sm" src="img/nophoto.jpg" alt="User Image">
                   <?php  }   ?>

                        <div class="comment-text">
                          <span class="username">
                          <?php echo $value['fullName']; ?>
                          <span class="text-muted pull-right"><?php echo  date("M j, Y h:ia",strtotime($value['posted_at'])) ; ?></span>
                          </span>
                          <?php echo $value['comment']; ?>
                        </div>
                      </div>
                    </div>
                    <?php }} ?>
                      <?php if (isset($getComment)) {
                        echo $getComment;
                      } ?>
                    <div class="box-footer" style="display: block;">
                      <form action="profile.php?postId2=<?php echo $value['id']; ?>" method="POST" id="my_form">
                        <div class="img-push">
                          <input name="commentbody" id="comment" type="text" class="form-control input-sm" placeholder="Press enter to post comment">
                          <input type="submit" name="submit_comm" style="position: absolute; left: -9999px; width: 1px; height: 1px;"tabindex="-1" />
                        </div>
                      </form>
                    </div>
                  </div>
                   <?php   }else{ ?>
                      <div class="box box-widget">
                    <div class="box-header with-border">
                      <div class="user-block">
                      <div class="btn-group pull-right activity-actions">
                          <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown">
                              <i class="fa fa-th"></i>
                              <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-right" role="menu">
                          <?php 

                              if (isset($_GET['delPost'])) {
                                 $postId =   $_GET['delPost'];
                                 $dPost = $ePost->deleteSinglePost($postId,$userId);
                              }

                             ?>
                              <li><a href="profile.php?delPost=<?php echo $value["id"];?>">  <i class="fa fa-trash" aria-hidden="true"></i> Delete This Post  </a></li>
                          </ul>
                      </div>
                        <?php
                       $getProImage = $edt->getProfileImage($userId);
                       if ($getProImage) {
                         while ($proImage = $getProImage->fetch_assoc()) {

                       ?>
                       <?php 
                        if ($proImage['avatar']) { ?>
                          <img class="img-circle" src="<?php echo $proImage['avatar']; ?>" alt="User Image">
                       <?php }else{?>
                        <img class="img-circle" src="img/nophoto.jpg" alt="User Image">
                     <?php }   ?>
                        
                          <?php }} ?>
                        <span class="username"><a href="#"><?php echo $username ?></a></span>
                        <span class="description">Shared publicly - <?php echo  date("M j, Y h:ia",strtotime($value['posted_at'])) ; ?></span>
                      </div>
                    </div>

                    <div class="box-body" style="display: block;">
                      <p>
                        <?php echo link_add($value["body"]); ?>
                      </p>
                      <?php

                      if ($value["postImage"]) { ?>
                        <img class="img-responsive show-in-modal" src="<?php echo $value["postImage"]; ?>" alt="Photo">
                   <?php  } ?>
                      <form action="profile.php?postId=<?php echo $value["id"]; ?>" method="POST">
                        <button type="submit" class="btn btn-default btn-xs" name="unlike"><i class="fa fa-thumbs-o-up"></i> Unlike</button>
                      </form>
                      <span class="pull-right text-muted"><?php echo $value["likes"]; ?> likes - 3 comments</span>
                    </div>
                    <?php 

                    $getcmt = $cmnt->displayComments($postId);
                      if ($getcmt) {
                        while ($value=$getcmt->fetch_assoc()) {
                      

                     ?>
                    <div class="box-footer box-comments" style="display: block;">

                      <div class="box-comment">
                        <?php 
                        if ($value['avatar']) { ?>
                          <img class="img-circle img-sm" src="<?php echo $value['avatar']; ?>" alt="User Image">
                      <?php  }else{?>
                        <img class="img-circle img-sm" src="img/nophoto.jpg" alt="User Image">
                   <?php  }   ?>
                        <div class="comment-text">
                          <span class="username">
                          <?php echo $value['fullName']; ?>
                          <span class="text-muted pull-right"><?php echo  date("M j, Y h:ia",strtotime($value['posted_at'])) ; ?></span>
                          </span>
                          <?php echo $value['comment']; ?>
                        </div>
                      </div>

                        
                    </div>
                    <?php }} ?>
                      <?php if (isset($getComment)) {
                        echo $getComment;
                      } ?>
                    <div class="box-footer" style="display: block;">
                      <form action="profile.php?postId2=<?php echo $value['id']; ?>" method="POST" id="my_form">
                        <div class="img-push">
                          <input name="commentbody" id="comment" type="text" class="form-control input-sm" placeholder="Press enter to post comment">
                          <input type="submit" name="submit_comm" style="position: absolute; left: -9999px; width: 1px; height: 1px;"tabindex="-1" />
                        </div>
                      </form>
                    </div>
                  </div>
                 <?php } ?>
                  <!--  end posts -->
                   <?php }} ?>
                </div>
              </div>
            </div><!-- end left posts-->
          </div>
        </div><!-- end timeline posts-->
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

<!-- Mirrored from demos.bootdey.com/dayday/profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 08 May 2017 15:35:14 GMT -->
</html>
