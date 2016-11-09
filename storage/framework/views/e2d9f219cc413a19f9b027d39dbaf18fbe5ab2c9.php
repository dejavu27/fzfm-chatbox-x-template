<?php $__env->startSection('content'); ?>
    <?php if(Auth::guest()): ?>
    <div class="container margin-top">
      <div class="panel login-panel">
        <div class="panel-title">
          <span class="fa fa-lock"></span> Please Login to continue.
        </div>
        <div class="panel-body login-panel-body">
          <ul class="login-butts">
            <li class="fbb">
              <a href="<?php echo e(URL::to('/auth/facebook')); ?>">
                <span class="fa fa-facebook-square"></span> Login with Facebook
              </a>
            </li>
            <div class="clearfix visible-sm visible-xs"></div>
            <div class="visible-sm visible-xs">
            <br>
            </div>
            <li class="twit">
              <a href="<?php echo e(URL::to('/auth/twitter')); ?>">
                <span class="fa fa-twitter-square"></span> Login with Twitter
              </a>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="likeshare">
          <center><iframe src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Ffriendzonefm&width=128&layout=button_count&action=like&show_faces=true&share=true&height=46&appId=1470601756566388" width="128" height="46" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe></center>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="footer login-footer">
      <div class="container">
        <div class="footer-bg">
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
              Powered by <a href="#">Roldhan Dasalla</a>
            </span>
          </center>
          </div>
        </div>
      </div>
    </div>
    <?php else: ?>
    <div class="container">
      <!-- Nav -->
      <nav class="navbar navbar-default navbar-fz">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
              <li class="active"><a href="/"><span class="fa fa-home"></span> Home</a></li>
              <li><a href="/tinychat"><span class="fa fa-video-camera"></span> TinyChat</a></li>
              <li><a href="#"><span class="fa fa-info-circle"></span> About</a></li>
              <?php if(Auth::user()->isAdmin > 0): ?>
              <li><a href="/admin"><span class="fa fa-navicon"></span> DashBoard</a></li>
              <?php endif; ?>
              <li><a href="/profile"><span class="fa fa-user"></span> My Profile</a></li>
            </ul>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>
      <!-- End of Nav -->
      <div class="row no-gutters">
        <div class="col-md-4 col-sm-4">
          <div class="panel panel-body player">
            <div class="album">
              <img src="http://static.gigwise.com/gallery/5209864_8262181_JasonDeruloTatGall.jpg" class="track-img" />
              <div class="title">
                <small>
                  <span class="fa fa-play playbutton"></span>  Now Playing
                </small>
                <p class="song"><span id="cc_strinfo_song_lars0x3a" class="cc_streaminfo">Loading ...</span></p>
                <p class="listeners"><span id="cc_strinfo_listeners_lars0x3a" class="cc_streaminfo">0</span> Listeners</p>
              </div>
            </div>
          </div>
          <div class="panel panel-body onboard">
            <img src="<?php echo e(URL::to('assetses/img/logo.png')); ?>" class="ob-bg" alt="">
            <div class="media ob">
              <div class="media-left">
                <img class="media-object ob-img" src="" alt="...">
              </div>
              <div class="media-body">
                <p class="media-heading ob-name">...</p>
                <span class="fa fa-headphones"></span> <span class="ob-status">On Board</span>
              </div>
            </div>
          </div>
          <!-- Visible only when logged in -->
          <div class="panel panel-body profile">
            <div class="media">
              <div class="media-left">
                <img class="media-object user-img" src="<?php echo e(Auth::user()->avatar); ?>" alt="...">
              </div>
              <div class="media-body">
                <p class="media-heading user-name" onclick="location.href='/profile'"><?php echo e(Auth::user()->name); ?></p>
                <p class="user-rank"><i style="color:#999;">User</i></p>
                <a href="/profile" class="user-butts">
                  <span class="fa fa-user"></span>
                </a>
                <a href="#" class="user-butts">
                  <span class="fa fa-cog"></span>
                </a>
                <a href="/logout" onclick="return confirm('Are you sure you want to leave?')" class="user-butts logout">
                  <span class="fa fa-power-off"></span>
                </a>
              </div>
            </div>
          </div>
          <div class="panel">
            <div class="panel-heading">ONLINE USERS</div>
            <div class="panel-body olbody" style="overflow:auto;overflow-x:hidden;max-height:350px">

            </div>
          </div>
          <div class="panel" style="display:none">
            <div class="panel-heading">TOP USERS</div>
            <div class="panel-body">Not Available</div>
          </div>
          <div class="panel">
            <div class="panel-heading">FANSIGNS</div>
            <div class="panel-body" style="padding:0px">
		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
		  <!-- Wrapper for slides -->
		  <div class="carousel-inner" role="listbox">
		  	<!-- Slides -->
		    <div class="item active">
		      <img src="/fansigns/fan1.jpg" style="height:320px;width:100%">
		    </div>
		  	<!-- Slides -->
		    <div class="item">
		      <img src="/fansigns/fan2.jpg" style="height:320px;width:100%">
		    </div>
		    
		  </div>
		  <!-- Wrapper for slides -->
		</div>
            </div>
          </div>
        </div>
        <div class="col-md-8 col-sm-8">
          <div class="panel panel-body banner">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">

              <!-- Wrapper for slides -->
              <div class="carousel-inner" role="listbox">
                <div class="item active">
                  <img src="<?php echo e(URL::to('assetses/img/03-dj.jpg')); ?>" alt="...">
                  <div class="carousel-caption">
                  </div>
                </div>
                <div class="item">
                  <img src="<?php echo e(URL::to('assetses/img/image_0.jpg')); ?>?template=generic" alt="...">
                  <div class="carousel-caption">

                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="panel">
            <div class="panel-heading">ANNOUNCEMENTS :</div>
            <div class="panel-body cbox" style="position: relative;">
              <?php echo $__env->make('layouts.chatbox', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
          </div>
          <div class="row no-gutters">
            <div class="col-md-6 col-sm-6">
              <div class="panel">
                <div class="panel-heading">WALL OF FAME</div>
                <div class="panel-body">Not Available</div>
              </div>
            </div>
            <div class="col-md-6 col-sm-6">
              <div class="panel">
                <div class="panel-heading">ADVERTISEMENTS</div>
                <div class="panel-body">Not Available</div>
              </div>
            </div>
          </div>
        </div>
      </div> <!-- row no-gutters -->
    </div> <!-- Container -->
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>