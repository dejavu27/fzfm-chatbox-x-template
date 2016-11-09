<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name=description content="FriendZone FM, Your No. 1 Online Radio Tambayan. Listen to great songs and great DJs anywhere, everywhere." />
  	<meta name=author content="Roldhan Dasalla(iNew Works)" />
  	<meta property=og:url content=http://www.friendzonefm.com/ />
  	<meta property=og:type content=website />
  	<meta property=og:title content="FriendZone FM" />
  	<meta property=og:image content="http://www.friendzonefm.com/assetses/img/logo2.png" />
  	<meta property=og:description content="FriendZone FM, Your No. 1 Online Radio Tambayan. Listen to great songs and great DJs anywhere, everywhere." />
  	<meta property=profile:first_name content="Roldhan Dasalla(iNew Works)" />
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

<?php
	$biodb = DB::table('users_info')->where('social_id','=',Auth::user()->social_id);
	if($biodb->count() == 0){
?>
<!-- Modal -->
<div class="modal fade" id="introModal" tabindex="-1" role="dialog" aria-labelledby="introModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Hello <?php echo e(Auth::user()->name); ?></h4>
      </div>
      <div class="modal-body">
        Your Bio Description is not yet set. Would you like to update it ?.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
        <a class="btn btn-primary" href="/profile">YES</a>
      </div>
    </div>
  </div>
</div>
<?php
	}
?>
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
                  <p class="fb-margin">
                  <a href="http://tunein.com/radio/FriendZone-FM-s272708/" class="social-butts t" target="_blank">Subscibe Us on Tune In</a>
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
              <a style="cursor:pointer" data-toggle="modal" data-target="#embedModal">Embed FriendZonedFM Player</a>
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
    <?php
    	if($_SERVER['REQUEST_URI'] == "/" || $_SERVER['REQUEST_URI'] == "/profile" ){
    ?>
    <audio id="player" autoplay loop><source src="http://50.116.107.13:8050/stream" type='audio/mpeg'></audio>
	<!-- Embed Modal -->
	<div class="modal fade" id="embedModal" tabindex="-1" role="dialog" aria-labelledby="embedModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="embedModalLabel">Embed Our Shoutcast</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<h2>Embed Shoutcast Player</h2>
							<pre onclick="inew.SelectText('embedshoutcast')" id="embedshoutcast" data-toggle="tooltip" data-placement="bottom" title="CTRL + C to copy the code">&lt;iframe src="http://development.friendzonefm.com/player/?host=50.116.107.13&port=8050" frameboder=0 width="155px" height="35px" scrolling="no"&gt;&lt;/iframe&gt;</pre>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
    <?php
    	}
    ?>
    <!-- JavaScripts -->
  <script src="<?php echo e(URL::to('assetses/js/jquery-2.2.3.min.js')); ?>" type="text/javascript"></script>
  <script src="<?php echo e(URL::to('assetses/js/bootstrap.min.js')); ?>" type="text/javascript"></script>
  <script type="text/javascript" src="<?php echo e(URL::to('/assetses/js/inew.compiled.js')); ?>"></script>
  <script type="text/javascript" src="<?php echo e(URL::to('/assetses/js/underscore-min.js')); ?>"></script>
  <script language="javascript" type="text/javascript" src="http://usa3.fastcast4u.com:2199/system/streaminfo.js"></script>
</body>
</html>
