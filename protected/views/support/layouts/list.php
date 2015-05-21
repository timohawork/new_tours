<div class="ap-blocks-list">
	<table class="table table-hover">
		<thead>
			<th class="edit-block"></th>
			<th class="date">Дата</th>
			<th>Логин</th>
			<th>Сообщение</th>
			<th class="edit-block"></th>
		</thead>
		<tbody>
			<?php foreach ($messages as $message) : ?>
				<tr class="<?=!$message->isSeen ? 'warning' : ''?>" data-id="<?=$message->id?>">
					<td class="edit-block">
						<?php if (!$message->isSeen) : ?>
							<a href="#" class="activation"><i class="fa fa-check fa-lg"></i></a>
						<?php endif; ?>
					</td>
					<td class="date">
						<?=DateHelper::getDate($message->created)?><br />
						<b><?=DateHelper::getTime($message->created)?></b>
					</td>
					<td><b><?=$message->user->email?></b></td>
					<td><?=$message->message?></td>
					<td class="edit-block">
						<a href="#" class="del"><i class="fa fa-trash-o fa-lg"></i></a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>