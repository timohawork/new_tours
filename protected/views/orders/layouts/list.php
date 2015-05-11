<div class="ap-blocks-list">
	<table class="table table-hover table-striped">
		<thead>
			<th>Дата</th>
			<th>Клиент</th>
			<th>Экскурсия</th>
			<th>Оплата</th>
			<th></th>
		</thead>
		<tbody>
			<?php foreach ($orders as $order) : ?>
				<tr class="" data-id="<?=$order->id?>">
					<td><b><?=DateHelper::getDate($order->tour->startDate)?></b></td>
					<td><b><?=$order->client->name?></b></td>
					<td><?=$order->tour->title?></td>
					<td>
						<?php if ($order->isPaid) : ?>
							<?=$order->summ?> р., <?=$order->getPaymentType()?>
						<?php else : ?>
							&mdash;
						<?php endif; ?>
					</td>
					<td class="edit-block">
						<a href="#" class="edit"><i class="fa fa-pencil fa-lg"></i></a>
						<a href="#" class="del"><i class="fa fa-trash-o fa-lg"></i></a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>