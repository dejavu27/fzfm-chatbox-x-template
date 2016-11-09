<?php $__env->startSection('content'); ?>
    <?php if(isset($exist) && isset($userid)): ?>
      <?php echo $__env->make('userprofile', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php elseif(isset($dontexist)): ?>
    <div class="container p-main">
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
            <ul class="nav navbar-nav navbar-left">
              <ol class="breadcrumb p-loc">
                <li><a href="#">Home</a></li>
                <li>Profile</li>
                <li class="active">Doesn`t Exist</li>
              </ol>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="/"><span class="fa fa-home"></span> Home</a></li>
              <li><a href="#"><span class="fa fa-video-camera"></span> TinyChat</a></li>
              <li><a href="#"><span class="fa fa-info-circle"></span> About</a></li>
              <?php if(Auth::user()->isAdmin > 0): ?>
              <li><a href="/admin"><span class="fa fa-navicon"></span> DashBoard</a></li>
              <?php endif; ?>
            </ul>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>
      <!-- End of Nav -->
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div class="alert alert-danger">
              USER NOT FOUND
          </div>
        </div>
      </div>
    </div>
    <?php else: ?>
      <?php echo $__env->make('myprofile', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>