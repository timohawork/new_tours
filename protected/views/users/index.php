<div class="panel panel-default">
	<div class="panel-heading">
		<h1>Пользователи</h1>
		<i id="add-new" class="fa fa-plus fa-2x"></i>
	</div>
	<div id="users_list" class="panel-body table-listing">
		<?php $this->renderPartial('layouts/list', array(
			'users' => $users
		)); ?>
	</div>
</div>

<div id="user-edit" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form" action="" method="POST">
					<div class="form-group">
						<label for="email-input" class="col-sm-3 control-label">E-mail</label>
						<div class="col-sm-8">
							<input id="email-input" type="text" name="email" class="form-control" data-validate="required:1;email:1;minLength:6">
						</div>
					</div>
					<div class="form-group">
						<label for="password-input" class="col-sm-3 control-label">Пароль</label>
						<div class="col-sm-8">
							<input id="password-input" type="password" name="password" class="form-control" data-validate="required:0">
						</div>
					</div>
					<div class="form-group">
						<label for="password-repeat-input" class="col-sm-3 control-label">Пароль ещё раз</label>
						<div class="col-sm-8">
							<input id="password-repeat-input" type="password" name="passwordRepeat" class="form-control" data-validate="compare:password-input">
						</div>
					</div>
					<div class="form-group">
						<label for="role-select" class="col-sm-3 control-label">Роль</label>
						<div class="col-sm-8">
							<select id="role-select" name="role" class="form-control">
								<?php foreach (Users::getRoles() as $role => $title) : ?>
									<option value="<?=$role?>"><?=$title?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<input id="user-id" type="hidden" name="id" value="">
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
				<button type="button" class="btn btn-primary">Сохранить</button>
			</div>
		</div>
	</div>
</div>