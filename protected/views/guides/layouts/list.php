<div class="ap-blocks-list">
	<table class="table table-hover table-striped">
		<thead>
			<th></th>
			<th>Имя</th>
			<th>Специализация</th>
			<th>Телефон</th>
			<th>Рейтинг</th>
			<th></th>
		</thead>
		<tbody>
			<?php foreach ($guides as $guide) : ?>
				<tr class="<?=$guide->active ? 'success' : ''?>" data-id="<?=$guide->id?>" data-spec="<?=$guide->spec?>" data-regions="<?=$guide->regionIds?>" data-base="<?=$guide->baseRegion?>">
					<td class="edit-block"><a href="#" class="activation"><i class="fa fa-check fa-lg"></i></a></td>
					<td class="name"><b><?=$guide->name?></b></td>
					<td><?=$guide->getSpec()?></td>
					<td class="phone"><?=$guide->phone?></td>
					<td class="rating"><?=$guide->rating?></td>
					<td class="edit-block">
						<a href="#" class="del"><i class="fa fa-trash-o fa-lg"></i></a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>