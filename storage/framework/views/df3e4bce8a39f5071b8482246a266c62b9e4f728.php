<?php $__env->startSection('content'); ?>

<div class="container-fluid db-main">

    <section id="djs">
      <div class="row no-gutters">
      	<div class="col-md-12">
      		<div class="panel" id="db-panel">
      			<div class="panel-heading">
      				User List
      			</div>
      			<div class="panel-body">
					<table id="djtable" class="display">
					    <thead>
					        <tr>
					        	<th style="display:none">&nbsp;</th>
					        	<th>&nbsp;</th>
					            <th style="text-align:center">NAME</th>
					            <th style="text-align:center">ACCOUNT TYPE</th>
					            <th style="text-align:center">POINTS</th>
					            <th style="text-align:center">SIGN TIME</th>
					            <th style="text-align:center">LAST ACTIVITY</th>
					            <th style="text-align:center">IP ADDRESS</th>
					            <th style="text-align:center">ACTIONS</th>
					        </tr>
					    </thead>
					    <tbody>
					    	<?php
					    		$getinfo = DB::table('users')->orderBy('id','ASC');
					    	?>
					    	<?php if($getinfo->count() > 0): ?>
					    		<?php foreach($getinfo->get() as $b): ?>
					    		<?php if($b->name == "FM BOT"): ?>

					    		<?php else: ?>
						        <tr id="user-<?php echo e($b->id); ?>">
						        	<td style="display:none"><?php echo e($b->id); ?></td>
						        	<td><img src="<?php echo e($b->avatar); ?>" width="30px"></td>
						            <td style="font-weight:bolder" id="user-name"><?php echo e($b->name); ?></td>
						            <td class="users_ranks" id="<?php echo e($b->acctype); ?>"></td>
						            <td id="user-points"><?php echo e($b->points); ?></td>
						            <td><?php echo e(date('M d, Y h:i:s a',strToTime($b->sign_time))); ?></td>
						            <td><?php echo e(date('M d, Y h:i:s a',$b->last_request_time)); ?></td>
						            <td><?php echo e($b->ip_address); ?></td>
						            <td>
						            	<center>
						            		<a class="btn btn-xs btn-primary" id="<?php echo e($b->id); ?>" onclick="inew.editUser(this.id,'<?php echo e($b->name); ?>','<?php echo e($b->acctype); ?>','<?php echo e($b->points); ?>','<?php echo e($b->color); ?>','<?php echo e($b->neon); ?>','<?php echo e($b->avatar); ?>','<?php echo e($b->social_id); ?>')">EDIT</a>
						            	</center>
						            </td>
						        </tr>
						        <?php endif; ?>
						        <?php endforeach; ?>
					    	<?php endif; ?>
					    </tbody>
					</table>
      			</div>
      		</div>
      	</div>
      </div>
    </section>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>