<div class="ap-blocks-list">
	<table class="table table-hover table-striped">
		<thead>
			<th></th>
			<th>Имя</th>
			<th>Тип</th>
			<th>Кол-во пассажиров</th>
			<th>Комфорт</th>
			<th>Телефон</th>
			<th>Рейтинг</th>
			<th></th>
		</thead>
		<tbody>
			<?php foreach ($cars as $car) : ?>
				<tr class="<?=$car->active ? 'success' : ''?>" data-id="<?=$car->id?>" data-regions="<?=$car->regionIds?>" data-base="<?=$car->baseRegion?>" data-type="<?=$car->type?>">
					<td class="edit-block"><a href="#" class="activation"><i class="fa fa-check fa-lg"></i></a></td>
					<td class="name"><b><?=$car->name?></b></td>
					<td><?=$car->getType()?></td>
					<td class="count"><?=$car->passCount?></td>
					<td class="comfort"><?=$car->comfort?></td>
					<td class="phone"><?=$car->phone?></td>
					<td class="rating"><?=$car->rating?></td>
					<td class="edit-block">
						<a href="#" class="del"><i class="fa fa-trash-o fa-lg"></i></a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>