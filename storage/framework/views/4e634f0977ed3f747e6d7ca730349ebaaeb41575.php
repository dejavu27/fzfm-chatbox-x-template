

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
	<div class="col-md-3" style="padding-left:0px">
		<div class="panel panel-default">
			<div class="panel-heading">
				Messages
			</div>
			<div class="panel-body" style="padding: 3px">
				<?php
					$pm = DB::table('pm_conversation')->where('social_from','=',Auth::user()->social_id)->get();
				?>
				<?php if($pm): ?>
					<?php foreach($pm as $k): ?>
					<?php
						$x = DB::table('users')->where('social_id','=',$k->social_to)->first();
					?>
					<div class="media" style="border: 1px solid #eee;cursor: pointer;">
					  <div class="pull-left">
					    <a>
					      <img class="media-object" src="<?php echo e($x->avatar); ?>" alt="..." width="60px">
					    </a>
					  </div>
					  <div class="media-body">
					    <h4 class="media-heading"><?php echo e($x->name); ?></h4>
					  </div>
					</div>
					<?php endforeach; ?>
				<?php else: ?>
					<center>No Message yet.</center>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="col-md-9" style="padding:0px">
		<div class="panel panel-default">
			<div class="panel-heading">
				Messages Body
			</div>
			<div class="panel-body">
				<?php echo e($this); ?>

			</div>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>