<?php $__env->startSection('content'); ?>
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
              <li><a href="/"><span class="fa fa-home"></span> Home</a></li>
              <li class="active"><a href="/tinychat"><span class="fa fa-video-camera"></span> TinyChat</a></li>
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
            <div class="panel-heading">Tinychat :</div>
            <div class="panel-body" style="position: relative;">
				<script type="text/javascript">var tinychat = { room: "friendzonefm", join: "auto"};</script><script src="http://tinychat.com/js/embed.js"></script><div id="client"></div>
            </div>
          </div>
          <div class="panel">
            <div class="panel-heading">ANNOUNCEMENTS :</div>
            <div class="panel-body cbox" style="position: relative;">
              <?php echo $__env->make('layouts.chatbox', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
          </div>
        </div>
	  </div>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>