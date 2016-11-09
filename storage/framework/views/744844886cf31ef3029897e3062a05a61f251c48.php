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
    <title>FriendZone FM Dashboard - <?php echo e($title); ?></title>

    <link rel="shortcut icon" href="<?php echo e(URL::to('/favicon.ico')); ?>" type="image/x-icon">
    <link rel="icon" href="<?php echo e(URL::to('/favicon.ico')); ?>" type="image/x-icon">

    <link rel="stylesheet" href="<?php echo e(URL::to('assetses/css/jquery.dataTables.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(URL::to('assetses/css/bootstrap.min.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(URL::to('assetses/css/dashboardmain.min.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(URL::to('assetses/css/font-awesome.min.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(URL::to('assetses/css/customcolorpicker.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(URL::to('assetses/css/ranking.css')); ?>"/>
	<link rel="stylesheet" href="<?php echo e(URL::to('assetses/css/cbox.min.css')); ?>"/>
	<link rel="stylesheet" href="<?php echo e(URL::to('assetses/css/fileinput.min.css')); ?>"/>
    <script type="text/javascript" src="<?php echo e(URL::to('/assetses/js/customColorPicker.js')); ?>"></script>
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
</head>
<body id="dashboard">
    <?php if(!Auth::guest()): ?>

    <div class="db-page-header">
      <h4>FriendZone FM | Dashboard</h4>
    </div>

    <div class="navbar navbar-inverse navbar-fixed-left">
      <div id="leftnav">
        <ul class="nav navbar-nav">
         <li <?php if(isset($me) && $me=="home"): ?> class="active" <?php endif; ?>>
           <a href="/admin">
             <p class="icon">
               <span class="fa fa-home"></span>
             </p>
             <p class="text">Home</p>
           </a>
          </li>
         <li <?php if(isset($me) && $me=="djs"): ?> class="active" <?php endif; ?>>
           <a href="/admin/dj">
             <p class="icon">
               <span class="fa fa-headphones"></span>
             </p>
             <p class="text">Jocks</p>
           </a>
         </li>
         <li <?php if(isset($me) && $me=="users"): ?> class="active" <?php endif; ?>>
           <a href="/admin/users">
             <p class="icon">
               <span class="fa fa-users"></span>
             </p>
             <p class="text">Users</p>
           </a>
         </li>
         <li <?php if(isset($me) && $me=="accounts"): ?> class="active" <?php endif; ?> style="display:none">
           <a href="#">
             <p class="icon">
               <span class="fa fa-pinterest-p"></span>
             </p>
             <p class="text">V.I.P</p>
           </a>
         </li>
         <li <?php if(isset($me) && $me=="banned"): ?> class="active" <?php endif; ?> style="display:none">
           <a href="/admin/banned">
             <p class="icon">
               <span class="fa fa-ban"></span>
             </p>
             <p class="text">Banned</p>
           </a>
         </li>
         <li <?php if(isset($me) && $me=="settings"): ?> class="active" <?php endif; ?>>
           <a href="/admin/banners">
             <p class="icon">
               <span class="fa fa-picture-o"></span>
             </p>
             <p class="text">Banners</p>
           </a>
         </li>
         <li>
           <a href="/">
             <p class="icon">
               <span class="fa fa-power-off"></span>
             </p>
             <p class="text">BACK TO SITE</p>
           </a>
         </li>
        </ul>
      </div>
    </div>
    <?php endif; ?>
    <?php if(Session::has('error')): ?>
        <div class="alert <?php echo e(Session::get('alert-class')); ?>"><?php echo e(Session::get('error')); ?></div>
    <?php endif; ?>
    <?php echo $__env->yieldContent('content'); ?>
    <!-- JavaScripts -->
  <script src="<?php echo e(URL::to('assetses/js/jquery-2.2.3.min.js')); ?>" type="text/javascript"></script>
  <script src="<?php echo e(URL::to('assetses/js/bootstrap.min.js')); ?>" type="text/javascript"></script>
  <script type="text/javascript" src="<?php echo e(URL::to('/assetses/js/inew.compiled.js')); ?>"></script>
  <script type="text/javascript" src="<?php echo e(URL::to('/assetses/js/jquery.dataTables.js')); ?>"></script>
</body>
</html>
