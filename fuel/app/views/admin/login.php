<?php echo Form::open(array('class'=>'form-horizontal')); ?>

	<?php if (isset($_GET['destination'])): ?>
		<?php echo Form::hidden('destination',$_GET['destination']); ?>
	<?php endif; ?>

<fieldset>
	<?php if (isset($login_error)): ?>
		<div class="error"><?php echo $login_error; ?></div>
	<?php endif; ?>

	<div class="control-group<?php if ($val->error('email')) echo ' error'; ?>">
		<label class="control-label" for="email">Email or Username:</label>
		<div class="controls">
		    <?php echo Form::input('email', Input::post('email')); ?>

		    <?php if ($val->error('email')): ?>
			    <span class="help-inline"><?php echo $val->error('email')->get_message('You must provide a username or email'); ?></span>
		    <?php endif; ?>
		</div>
	</div>
		
	<div class="control-group<?php if ($val->error('password')) echo ' error'; ?>">
		<label class="control-label" for="password">Password:</label>
		<div class="controls">
		    <?php echo Form::password('password', Input::post('password')); ?>

		    <?php if ($val->error('password')): ?>
			    <span class="help-inline"><?php echo $val->error('password')->get_message(':label cannot be blank'); ?></span>
		    <?php endif; ?>
		</div>
	</div>

	<div class="form-actions">
		<?php echo Form::button('Submit',null,array('class' => 'btn btn-primary','type'=>'submit')); ?>
	</div>
</fieldset>
<?php echo Form::close(); ?>