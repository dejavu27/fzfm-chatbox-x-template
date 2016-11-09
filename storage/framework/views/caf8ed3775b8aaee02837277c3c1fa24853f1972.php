<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta property="og:type" content="website" />
    <meta name="description" content="FriendZone FM, Your No. 1 Online Radio Tambayan. Listen to great songs and great DJs anywhere, everywhere." />
    <meta name="author" content="Roldhan Dasalla" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Home | FriendZone FM" />
    <title>FriendZone FM</title>

    <link rel="shortcut icon" href="<?php echo e(URL::to('/favicon.ico')); ?>" type="image/x-icon">
    <link rel="icon" href="<?php echo e(URL::to('/favicon.ico')); ?>" type="image/x-icon">

    <link rel="stylesheet" href="<?php echo e(URL::to('assetses/css/bootstrap.min.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(URL::to('assetses/css/main.min.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(URL::to('assetses/css/cbox.min.css')); ?>"/>
	<link rel="stylesheet" href="<?php echo e(URL::to('assetses/css/ranking.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(URL::to('assetses/css/font-awesome.min.css')); ?>"/>
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
</head>
<body id="app-layout">
    <?php if(!Auth::guest()): ?>
    <?php endif; ?>
    <?php if(Session::has('error')): ?>
        <div class="alert <?php echo e(Session::get('alert-class')); ?>"><?php echo e(Session::get('error')); ?></div>
    <?php endif; ?>
    <header id="mainhead">
      <div class="container">
        <img src="<?php echo e(URL::to('assetses/img/logo.png')); ?>" class="img-responsive logo"/>
      </div>
    </header>
    <div class="clearfix"></div>
    <?php echo $__env->yieldContent('content'); ?>
    <?php if(!Auth::guest()): ?>
    <div class="clearfix"></div>
    <div class="footer">
      <div class="container">
        <div class="footer-bg">
          <div class="row">
            <div class="col-md-4 col-sm-4">
              <div class="panel footer-panel">
                <div class="panel-heading footer-panel-heading">Social</div>
                <div class="panel-body footer-panel-body">
                  <p class="fb-margin">
                  <a href="https://www.facebook.com/friendzonefm" class="social-butts fb" target="_blank"><span class="fa fa-facebook-square"></span>  Like us on Facebook</a>
                  </p>
                  <a href="https://twitter.com/friendzonefm" class="social-butts t" target="_blank"><span class="fa fa-twitter-square"></span>  Follow us on Twitter</a>
                </div>
              </div>
            </div>
            <div class="col-md-4 col-sm-4">
              <div class="panel footer-panel">
                <div class="panel-heading footer-panel-heading">Links</div>
                <div class="panel-body footer-panel-body">
                  <p id="links"><a href="/">Home</a></p>
                  <p id="links"><a href="#">TinyChat</a></p>
                  <p id="links"><a href="#">About</a></p>
                  <?php if(Auth::user()->isAdmin > 0): ?>
                  <p id="links"><a href="/admin">Dashboard</a></p>
                  <?php endif; ?>
                </div>
              </div>
            </div>
            <div class="col-md-4 col-sm-4">
              <div class="panel footer-panel">
                <div class="panel-heading footer-panel-heading">Facebook Feed</div>
                <div class="panel-body footer-panel-body"></div>
              </div>
            </div>
          </div><!-- Footer [row no-gutters] -->
          <div class="clearfix"></div>
          <div class="main-footer">
          <center>
            <span class="embed">
              <a href="#">Embed FriendZonedFM Player</a>
            </span>
            <div class="clearfix"></div>
            <br>
            <span class="footer-text">
              FriendZoneFM <span class="fa fa-copyright"></span> 2016
            </span>
            <div class="clearfix"></div>
            <span class="powered">
              Powered by <a href="https://www.facebook.com/roldhan27" target="_blank">Roldhan Dasalla</a>
            </span>
          </center>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>
    <audio id="player" loop><source src="http://usa3.fastcast4u.com:5260/stream" type='audio/mpeg'></audio>
    <!-- JavaScripts -->
  <script src="<?php echo e(URL::to('assetses/js/jquery-2.2.3.min.js')); ?>" type="text/javascript"></script>
  <script src="<?php echo e(URL::to('assetses/js/bootstrap.min.js')); ?>" type="text/javascript"></script>
  <script type="text/javascript" src="<?php echo e(URL::to('/assetses/js/inew.compiled.js')); ?>"></script>
  <script type="text/javascript" src="<?php echo e(URL::to('/assetses/js/underscore-min.js')); ?>"></script>
  <script language="javascript" type="text/javascript" src="http://usa3.fastcast4u.com:2199/system/streaminfo.js"></script>
</body>
</html>
