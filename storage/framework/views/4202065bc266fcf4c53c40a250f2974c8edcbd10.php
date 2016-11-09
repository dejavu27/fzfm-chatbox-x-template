

<?php $__env->startSection('content'); ?>

<div class="container-fluid db-main">

    <section id="home">
      <div class="row no-gutters">
        <div class="col-md-8">
          <div class="panel" id="db-panel">
            <div class="panel-heading">Chatbox</div>
            <div class="panel-body cbox">
              <?php echo $__env->make('layouts.chatbox', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="panel" id="db-panel">
            <div class="panel-body">
              <p class="title">Total chat counts <span class="badge"><?php echo e(DB::table('chatbox')->count()); ?></span></p>
              <p class="title">Total users <span class="badge"><?php echo e(DB::table('users')->count()); ?></span></p>
              <p class="title">Total Banned users <span class="badge"><?php echo e(DB::table('banned')->count()); ?></span></p>
              <p class="title">Staff's <span class="badge"><?php echo e(DB::table('users')->where("acctype",">",0)->count()); ?></span></p>
              <p class="title">Dashboard access <span class="badge"><?php echo e(DB::table('users')->where("isAdmin",">",0)->count()); ?></span></p>
            </div>
          </div>
          <div class="panel" id="db-panel">
            <div class="panel-heading">Online Users</div>
            <div class="panel-body"></div>
          </div>
        </div>
      </div>
    </section>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>