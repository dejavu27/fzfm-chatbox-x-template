<?php $__env->startSection('content'); ?>

<div class="container-fluid db-main">

    <section id="djs">
      <div class="row no-gutters">
      	<div class="col-md-12">
	      <div class="panel" id="db-panel">
	      	<div class="panel-heading">
	      		Disc Jockey
	      	</div>
	      	<div class="panel-body">
      			<?php /* Add DJs */ ?>
	      		<div class="col-md-8">
	      			<form class="djsForm">
	      				<div class="form-group col-md-6">
	      					<label>DJ Name : </label>
	      					<input type="text" class="form-control" name="djName" id="djName" placeholder="Enter DJ Name" required autocomplete="off">
	      				</div>
	      				<div class="form-group col-md-6">
	      					<label>DJ Social ID : </label>
	      					<?php
	      						$getdj = DB::table('users')->get();
	      					?>
	      					<select class="form-control" name="djSocialID" required>
	      						<option value="">SELECT HERE</option>
	      						<?php foreach($getdj as $a): ?>
	      						<?php if($a->name == "FM BOT"): ?>

	      						<?php else: ?>
	      						<option value="<?php echo e($a->social_id); ?>"><?php echo e($a->name); ?></option>
	      						<?php endif; ?>
	      						<?php endforeach; ?>
	      					</select>
	      				</div>
	      				<div class="form-group col-md-6">
	      					<label>DJ Tagline : </label>
	      					<input type="text" class="form-control" name="djTag" id="djTag" placeholder="Enter DJ Tagline" required autocomplete="off">
	      				</div>
	      				<div class="form-group col-md-6">
	      					<label>To be added by : </label>
	      					<input type="text" class="form-control" name="added_by" id="added_by" readonly value="<?php echo e(Auth::user()->name); ?>(You)" required autocomplete="off">
	      				</div>
	      				<div class="form-group col-md-10">
	      					<button type="reset" class="btn btn-warning">CLEAR FORM</button>
	      					<button type="submit" class="btn btn-success">ADD DJ</button>
	      				</div>
	      			</form>
	      		</div>
	      		<?php /* DJ On Board */ ?>
	      		<div class="col-md-4" style="padding: 0px 5px 0px 5px;">
	      			<div style="padding: 0px 5px 0px 5px;border-left: 5px solid #eee;">
		      			<label>DJ On Board : <span class="djob_status" style="color:#1abc9c"></span></label>
		      			<form class="">
		      				<div class="form-group">
		      					<?php
		      						$getdjs = DB::table('dashboard_djs');
		      					?>
		      					<?php if($getdjs->count() > 0): ?>
		      					<select class="form-control" name="djSocialID" id="djob_social_id" required>
		      						<option value="">SELECT HERE</option>
		      						<option value="0">Auto Tune</option>
		      						<?php foreach($getdjs->get() as $c): ?>
		      						<option value="<?php echo e($c->dj_social_id); ?>"><?php echo e($c->dj_name); ?></option>
		      						<?php endforeach; ?>
		      					</select>
		      					<?php else: ?>
		      					<select class="form-control" name="djSocialID" disabled="">
		      						<option value="">NO DJ AVAILABLE</option>
		      					</select>
		      					<?php endif; ?>
		      				</div>
		      			</form>
	      			</div>
	      			<div style="padding: 0px 5px 0px 5px;border-left: 5px solid #eee;">
		      			<label>Current DJ On Board : </label><br>
		      			<?php
		      				$getdjob = DB::table('dashboard_onboard')->first();
		      			?>
		      			<?php if($getdjob->dj_status == 1): ?>
		      				<p style="color:#2ecc71" class="djob_name"><?php echo e($getdjob->dj_name); ?></p>
		      			<?php else: ?>
		      				<p style="color:#e74c3c" class="djob_name"><?php echo e($getdjob->dj_name); ?></p>
		      			<?php endif; ?>
	      			</div>
	      		</div>
	      	</div>
	      </div>
	      <?php /* DJ list */ ?>
	      <div class="panel" id="db-panel">
	      	<div class="panel-heading">
	      		DJ List
	      	</div>
	      	<div class="panel-body">
				<table id="djtable" class="display">
				    <thead>
				        <tr>
				            <th style="text-align:center">DJ NAME</th>
				            <th style="text-align:center">DJ TAGLINE</th>
				            <th style="text-align:center">ADDED BY</th>
				            <th style="text-align:center">DATE UPDATED</th>
				            <th style="text-align:center">ACTIONS</th>
				        </tr>
				    </thead>
				    <tbody>
				    	<?php
				    		$getinfo = DB::table('dashboard_djs');
				    	?>
				    	<?php if($getinfo->count() > 0): ?>
				    		<?php foreach($getinfo->get() as $b): ?>
				    		<?php
				    			$djname = DB::table('users')->where('social_id','=',$b->added_by)->first();
				    			$odjname = DB::table('users')->where('social_id','=',$b->dj_social_id)->first();
				    		?>
					        <tr id="<?php echo e($b->id); ?>">
					            <td class="djname"><?php echo e($b->dj_name); ?>(<?php echo e($odjname->name); ?>)</td>
					            <td class="djtag"><?php echo e($b->dj_tagline); ?></td>
					            <td><?php echo e($djname->name); ?></td>
					            <td class="djtime"><?php echo e(date('M d, Y h:i a',$b->time)); ?></td>
					            <td>
					            	<center>
					            		<a class="btn btn-xs btn-primary" id="<?php echo e($b->id); ?>" onclick="inew.editDj(this.id,'<?php echo e($b->dj_name); ?>','<?php echo e($b->dj_tagline); ?>','<?php echo e($b->dj_social_id); ?>','<?php echo e($odjname->name); ?>')">EDIT</a>
					            		<a class="btn btn-xs btn-danger" id="<?php echo e($b->id); ?>" onclick="inew.deleteDj(this.id,'<?php echo e($b->dj_social_id); ?>','<?php echo e($b->dj_name); ?>')">DELETE</a>
					            	</center>
					            </td>
					        </tr>
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