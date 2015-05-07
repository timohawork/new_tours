<div id="login-block">
	<?php $form = $this->beginWidget('CActiveForm', array(
		'action' => '/index/login',
		'focus' => array($model, 'email'),
		'htmlOptions' => array('class' => 'form-horizontal')
	)); ?>
		<div class="form-group">
			<label for="email" class="col-sm-3 control-label">Email</label>
			<div class="col-sm-9">
				<?=$form->textField($model, 'email', array(
					'class' => 'form-control',
					'id' => 'email',
					'placeholder' => 'Email'
				)); ?>
				<?php if ($model->hasErrors('email')) : ?>
					<p class="text-danger"><?=$model->getError('email')?></p>
				<?php endif; ?>
			</div>
		</div>
		<div class="form-group">
			<label for="password" class="col-sm-3 control-label">Пароль</label>
			<div class="col-sm-9">
				<?=$form->passwordField($model, 'password', array(
					'class' => 'form-control',
					'id' => 'password',
					'placeholder' => 'Пароль'
				)); ?>
				<?php if ($model->hasErrors('password')) : ?>
					<p class="text-danger"><?=$model->getError('password')?></p>
				<?php endif; ?>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-4 col-sm-4">
				<button type="submit" class="btn btn-default">Войти</button>
			</div>
		</div>
	<?php $this->endWidget(); ?>
</div>