<div class="ap-blocks-list">
	<table class="table table-hover table-striped">
		<thead>
			<th>№</th>
			<th>Роль</th>
			<th>E-mail</th>
			<th></th>
		</thead>
		<tbody>
			<?php foreach ($users as $user) : ?>
				<?php 
					$role = $user->getRole();
					$label = 'success';
					if ($role === Users::ROLE_ADMIN) {
						$label = 'danger';
					}
				?>
				<tr class="active" data-id="<?=$user->id?>" data-user-role="<?=$role?>">
					<td width="30"><b><?=$user->id?></b></td>
					<td width="120"><span class="label label-<?=$label?>"><?=Users::getRoleDesc($role)?></span></td>
					<td class="email"><b><?=$user->email?></b></td>
					<td class="edit-block">
						<a href="#" class="del"><i class="fa fa-trash-o fa-lg"></i></a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>