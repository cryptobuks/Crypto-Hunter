<?php echo $__env->make('header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="main-panel">
	<div class="content">
		<div class="page-inner">
			<div class="mt-2 mb-4">
				<h1 class="title1">View agent (<?php echo e($agent->name); ?>) clients</h1>
			</div>
			<?php if(Session::has('message')): ?>
			<div class="row">
				<div class="col-lg-12">
					<div class="alert alert-info alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<i class="fa fa-info-circle"></i> <?php echo e(Session::get('message')); ?>

					</div>
				</div>
			</div>
			<?php endif; ?>

			<?php if(count($errors) > 0): ?>
			<div class="row">
				<div class="col-lg-12">
					<div class="alert alert-danger alert-dismissable" role="alert" >
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<i class="fa fa-warning"></i> <?php echo e($error); ?>

						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
				</div>
			</div>
			<?php endif; ?>
			<div class="row mb-5">
				<div class="col card p-4">
					<div class="table-responsive" data-example-id="hoverable-table"> 
						<table class="table table-hover"> 
							<thead> 
								<tr> 
									<th>Client name</th>
									<th>Client Inv. plan</th>
									<th>Client status</th>
									<th>Earnings</th>
								</tr> 
							</thead> 
							<tbody> 
								<?php $__currentLoopData = $ag_r; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr> 
									 <td><?php echo e($client->name); ?></td> 
									 <?php if(isset($client->dplan->name)): ?> 
									 <td><?php echo e($client->dplan->name); ?></td>
									 <?php else: ?>
									 <td>NULL</td>
									 <?php endif; ?> 
									 <td><?php echo e($client->status); ?></td> 
									 <td><?php echo e($client->account_bal); ?></td>
								</tr> 
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</tbody> 
						</table>
					</div>
				</div>
			</div>
            
	</div>
<?php echo $__env->make('modals', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>