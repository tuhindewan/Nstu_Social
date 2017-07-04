<?php 
require_once 'lib/session.php';
Session::checkSession();
Session::init();
require_once 'lib/database.php';
$db = new Database();
$userId = Session::get("userid");
$username = Session::get("fullname");
?>
<?php
require_once 'classes/Post.php';
$post = new Post();
?>
<?php
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['post'])) {
  $getData = $post->UserSinglePost($_POST,$userId);
}

?>
<?php 

if (isset($_GET['postId'])) {
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
<!DOCTYPE html>
<html lang="en">
  
<!-- Mirrored from demos.bootdey.com/dayday/home.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 08 May 2017 15:35:14 GMT -->
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
          <a class="navbar-brand" href="index-2.html"><b>DayDay</b></a>
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
                <li><a href="profile2.html">Profile 2</a></li>
                <li><a href="profile3.html">Profile 3</a></li>
                <li><a href="profile4.html">Profile 4</a></li>
                <li><a href="sidebar_profile.html">Sidebar profile</a></li>
                <li><a href="user_detail.html">User detail</a></li>
                <li><a href="edit_profile.html">Edit profile</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="friends.html">Friends</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Begin page content -->
    <div class="container page-content ">
      <div class="row">
        <!-- left links -->
        <div class="col-md-3">
          <div class="profile-nav">
            <div class="widget">
              <div class="widget-body">
                <div class="user-heading round">
                  <a href="#">
                      <img src="img/Friends/guy-3.jpg" alt="">
                  </a>
                  <h1>John Breakgrow</h1>
                  <p>@username</p>
                </div>

                <ul class="nav nav-pills nav-stacked">
                  <li class="active"><a href="#"> <i class="fa fa-user"></i> News feed</a></li>
                  <li>
                    <a href="#"> 
                      <i class="fa fa-envelope"></i> Messages 
                      <span class="label label-info pull-right r-activity">9</span>
                    </a>
                  </li>
                  <li><a href="#"> <i class="fa fa-calendar"></i> Events</a></li>
                  <li><a href="#"> <i class="fa fa-image"></i> Photos</a></li>
                  <li><a href="#"> <i class="fa fa-share"></i> Browse</a></li>
                  <li><a href="#"> <i class="fa fa-floppy-o"></i> Saved</a></li>
                </ul>
              </div>
            </div>

            <div class="widget">
              <div class="widget-body">
                <ul class="nav nav-pills nav-stacked">
                  <li><a href="#"> <i class="fa fa-globe"></i> Pages</a></li>
                  <li><a href="#"> <i class="fa fa-gamepad"></i> Games</a></li>
                  <li><a href="#"> <i class="fa fa-puzzle-piece"></i> Ads</a></li>
                  <li><a href="#"> <i class="fa fa-home"></i> Markerplace</a></li>
                  <li><a href="#"> <i class="fa fa-users"></i> Groups</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div><!-- end left links -->


        <!-- center posts -->
        <div class="col-md-6">
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
                    <form action="" method="POST">
                        <textarea class="form-control input-lg p-text-area" rows="2" placeholder="Whats in your mind today?" name="body"></textarea>
                        <div class="box-footer box-form">
                        <button type="submit" class="btn btn-azure pull-right" name="post">Post</button>
                        <ul class="nav nav-pills">
                            <li><a href="#"><i class="fa fa-map-marker"></i></a></li>
                            <li><a href="#"><i class="fa fa-camera"></i></a></li>
                            <li><a href="#"><i class=" fa fa-film"></i></a></li>
                            <li><a href="#"><i class="fa fa-microphone"></i></a></li>
                        </ul>
                    </div>
                    </form>
                  </div><!-- end post state form -->
                  <!-- end post state form -->

                  <!--  posts -->
                  <?php 

                  $getVal = $post->getFollowingData($userId);
                  if ($getVal) {
                    while ($value=$getVal->fetch_assoc()) {
                     $postId = $value["id"];

                      $query = "SELECT post_id FROM post_likes WHERE user_id = '$userId' AND post_id = '$postId'";
                      $like_result = $db->select($query);
                      if ($like_result==false) { ?>
                        <div class="box box-widget">
                    <div class="box-header with-border">
                      <div class="user-block">
                        <img class="img-circle" src="img/Friends/guy-3.jpg" alt="User Image">
                        <span class="username"><a href="#">John Breakgrow jr.</a></span>
                        <span class="description">Shared publicly - <?php echo  date("M j, Y h:ia",strtotime($value['posted_at'])) ; ?></span>
                      </div>
                    </div>

                    <div class="box-body" style="display: block;">
                      <p>
                        <?php echo $value["body"]; ?>
                      </p>
                      <button type="button" class="btn btn-default btn-xs"><i class="fa fa-share"></i> Share</button>
                      <form action="newsFeed.php?postId=<?php echo $value["id"]; ?>" method="POST">
                        <button type="submit" class="btn btn-default btn-xs" name="like"><i class="fa fa-thumbs-o-up"></i> Like</button>
                      </form>
                      <span class="pull-right text-muted"><?php echo $value["likes"]; ?> likes - 3 comments</span>
                    </div>
                    <div class="box-footer box-comments" style="display: block;">
                      <div class="box-comment">
                        <img class="img-circle img-sm" src="img/Friends/guy-2.jpg" alt="User Image">
                        <div class="comment-text">
                          <span class="username">
                          Maria Gonzales
                          <span class="text-muted pull-right">8:03 PM Today</span>
                          </span>
                          It is a long established fact that a reader will be distracted
                          by the readable content of a page when looking at its layout.
                        </div>
                      </div>

                      <div class="box-comment">
                        <img class="img-circle img-sm" src="img/Friends/guy-3.jpg" alt="User Image">
                        <div class="comment-text">
                          <span class="username">
                          Luna Stark
                          <span class="text-muted pull-right">8:03 PM Today</span>
                          </span>
                          It is a long established fact that a reader will be distracted
                          by the readable content of a page when looking at its layout.
                        </div>
                      </div>
                    </div>
                    <div class="box-footer" style="display: block;">
                      <form action="#" method="post">
                        <img class="img-responsive img-circle img-sm" src="img/Friends/guy-3.jpg" alt="Alt Text">
                        <div class="img-push">
                          <input type="text" class="form-control input-sm" placeholder="Press enter to post comment">
                        </div>
                      </form>
                    </div>
                  </div>
                   <?php   }else{ ?>
                      <div class="box box-widget">
                    <div class="box-header with-border">
                      <div class="user-block">
                        <img class="img-circle" src="img/Friends/guy-3.jpg" alt="User Image">
                        <span class="username"><a href="#">John Breakgrow jr.</a></span>
                        <span class="description">Shared publicly - <?php echo  date("M j, Y h:ia",strtotime($value['posted_at'])) ; ?></span>
                      </div>
                    </div>

                    <div class="box-body" style="display: block;">
                      <p>
                        <?php echo $value["body"]; ?>
                      </p>
                      <button type="button" class="btn btn-default btn-xs"><i class="fa fa-share"></i> Share</button>
                      <form action="newsFeed.php?postId=<?php echo $value["id"]; ?>" method="POST">
                        <button type="submit" class="btn btn-default btn-xs" name="unlike"><i class="fa fa-thumbs-o-up"></i> unLike</button>
                      </form>
                      <span class="pull-right text-muted"><?php echo $value["likes"]; ?> likes - 3 comments</span>
                    </div>
                    <div class="box-footer box-comments" style="display: block;">
                      <div class="box-comment">
                        <img class="img-circle img-sm" src="img/Friends/guy-2.jpg" alt="User Image">
                        <div class="comment-text">
                          <span class="username">
                          Maria Gonzales
                          <span class="text-muted pull-right">8:03 PM Today</span>
                          </span>
                          It is a long established fact that a reader will be distracted
                          by the readable content of a page when looking at its layout.
                        </div>
                      </div>

                      <div class="box-comment">
                        <img class="img-circle img-sm" src="img/Friends/guy-3.jpg" alt="User Image">
                        <div class="comment-text">
                          <span class="username">
                          Luna Stark
                          <span class="text-muted pull-right">8:03 PM Today</span>
                          </span>
                          It is a long established fact that a reader will be distracted
                          by the readable content of a page when looking at its layout.
                        </div>
                      </div>
                    </div>
                    <div class="box-footer" style="display: block;">
                      <form action="#" method="post">
                        <img class="img-responsive img-circle img-sm" src="img/Friends/guy-3.jpg" alt="Alt Text">
                        <div class="img-push">
                          <input type="text" class="form-control input-sm" placeholder="Press enter to post comment">
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
        </div><!-- end  center posts -->




        <!-- right posts -->
        <div class="col-md-3">
          <!-- People You May Know -->
          <div class="widget">
            <div class="widget-header">
              <h3 class="widget-caption">People You May Know</h3>
            </div>
            <div class="widget-body bordered-top bordered-sky">
              <div class="card">
                  <div class="content">
                      <ul class="list-unstyled team-members">
                          <li>
                              <div class="row">
                                  <div class="col-xs-3">
                                      <div class="avatar">
                                          <img src="img/Friends/guy-2.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                      </div>
                                  </div>
                                  <div class="col-xs-6">
                                     Carlos marthur
                                  </div>
                      
                                  <div class="col-xs-3 text-right">
                                      <btn class="btn btn-sm btn-azure btn-icon"><i class="fa fa-user-plus"></i></btn>
                                  </div>
                              </div>
                          </li>
                          <li>
                              <div class="row">
                                  <div class="col-xs-3">
                                      <div class="avatar">
                                          <img src="img/Friends/woman-1.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                      </div>
                                  </div>
                                  <div class="col-xs-6">
                                      Maria gustami
                                  </div>
                      
                                  <div class="col-xs-3 text-right">
                                      <btn class="btn btn-sm btn-azure btn-icon"><i class="fa fa-user-plus"></i></btn>
                                  </div>
                              </div>
                          </li>
                          <li>
                              <div class="row">
                                  <div class="col-xs-3">
                                      <div class="avatar">
                                          <img src="img/Friends/woman-2.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                      </div>
                                  </div>
                                  <div class="col-xs-6">
                                      Angellina mcblown
                                  </div>
                      
                                  <div class="col-xs-3 text-right">
                                      <btn class="btn btn-sm btn-azure btn-icon"><i class="fa fa-user-plus"></i></btn>
                                  </div>
                              </div>
                          </li>
                      </ul>
                  </div>
              </div>
              <a href="usersList.php">View all&nbsp <i class="fa fa-share-square-o"></i></a>          
            </div>
          </div><!-- End people yout may know --> 

                    <!-- Friends activity -->
          <div class="widget">
            <div class="widget-header">
              <h3 class="widget-caption">Friends activity</h3>
            </div>
            <div class="widget-body bordered-top bordered-sky">
              <div class="card">
                <div class="content">
                   <ul class="list-unstyled team-members">
                    <li>
                      <div class="row">
                        <div class="col-xs-3">
                          <div class="avatar">
                              <img src="img/Friends/woman-2.jpg" alt="img" class="img-circle img-no-padding img-responsive">
                          </div>
                        </div>
                        <div class="col-xs-9">
                          <b><a href="#">Hillary Markston</a></b> shared a 
                          <b><a href="#">publication</a></b>. 
                          <span class="timeago" >5 min ago</span>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="row">
                        <div class="col-xs-3">
                          <div class="avatar">
                              <img src="img/Friends/woman-3.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                          </div>
                        </div>
                        <div class="col-xs-9">
                          <b><a href="#">Leidy marshel</a></b> shared a 
                          <b><a href="#">publication</a></b>. 
                          <span class="timeago" >5 min ago</span>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="row">
                        <div class="col-xs-3">
                          <div class="avatar">
                              <img src="img/Friends/woman-4.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                          </div>
                        </div>
                        <div class="col-xs-9">
                          <b><a href="#">Presilla bo</a></b> shared a 
                          <b><a href="#">publication</a></b>. 
                          <span class="timeago" >5 min ago</span>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="row">
                        <div class="col-xs-3">
                            <div class="avatar">
                                <img src="img/Friends/woman-4.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                            </div>
                        </div>
                        <div class="col-xs-9">
                          <b><a href="#">Martha markguy</a></b> shared a 
                          <b><a href="#">publication</a></b>. 
                          <span class="timeago" >5 min ago</span>
                        </div>
                      </div>
                    </li>
                  </ul>         
                </div>
              </div>
            </div>
          </div><!-- End Friends activity -->

        </div><!-- end right posts -->
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

<!-- Mirrored from demos.bootdey.com/dayday/home.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 08 May 2017 15:35:14 GMT -->
</html>
