<div class="ap-blocks-list">
	<table class="table table-hover table-striped">
		<thead>
			<th>Логин</th>
			<th>Имя</th>
			<th>Телефон</th>
			<th>E-mail</th>
			<th>Дата регистрации</th>
			<th>Последний вход</th>
			<th></th>
		</thead>
		<tbody>
			<?php foreach ($clients as $client) : ?>
				<tr class="<?=$client->active ? 'success' : ''?>" data-id="<?=$client->id?>">
					<td><b><?=$client->login?></b></td>
					<td><b><?=$client->name?></b></td>
					<td><?=$client->phone?></td>
					<td><?=$client->email?></td>
					<td><?=$client->regDate?></td>
					<td><?=$client->lastVisit?></td>
					<td class="edit-block">
						<a href="/orders/index/client/<?=$client->id?>"><i class="fa fa-shopping-cart fa-lg"></i></a>
						<a href="#" class="activation"><i class="fa fa-check fa-lg"></i></a>
						<a href="#" class="edit"><i class="fa fa-pencil fa-lg"></i></a>
						<a href="#" class="del"><i class="fa fa-trash-o fa-lg"></i></a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>