<div class="navigation">
	<a href="#" rel="<?=$monthDiff - 1?>"><i class="fa fa-arrow-left fa-lg"></i></a>
	<h3><?=DateHelper::monthName($month)?>, <?=$year?></h3>
	<a href="#" rel="<?=$monthDiff + 1?>"><i class="fa fa-arrow-right fa-lg"></i></a>
</div>
<div class="weak-header">
	<span class="label label-default">Пн</span>
	<span class="label label-default">Вт</span>
	<span class="label label-default">Ср</span>
	<span class="label label-default">Чт</span>
	<span class="label label-default">Пт</span>
	<span class="label label-primary">Сб</span>
	<span class="label label-primary">Вс</span>
</div>
<div class="days-block">
	<?php $isPast = $monthDiff <= 0; ?>
	<?php foreach ($days as $weak => $weakDays) : ?>
		<?php foreach ($weakDays as $i => $day) : ?>
			<?php 
				$date = !empty($day) ? $year."-".$month."-".(10 > $day['num'] ? '0'.$day['num'] : $day['num']) : '';
				$class = 'day'.(5 <= $i ? ' holiday' : '');
				if (!empty($day)) {
					$class .= ' exist';
				}
				if (!empty($day) && $year."-".$month."-".($day['num'] < 10 ? '0'.$day['num'] : $day['num']) === $today) {
					$class .= ' today';
					$isPast = false;
				}
				if (!empty($day) && 0 != $day['counters']['tours']) {
					$class .= ' active'.(0 != $day['counters']['notPlaced'] ? ' alerted' : '');
				}
				$class .= $isPast ? ' past' : '';
			?>
			<div class="<?=$class?>" rel="<?=$date?>">
				<?=!empty($day) ? '<h3>'.$day['num'].'</h3>' : ''?>
				<?php if (!empty($day) && 0 != $day['counters']['tours']) : ?>
					<div class="indicators">
						<span class="indicator"><i class="fa fa-flag fa-lg"></i> <h4><?=$day['counters']['tours']?></h4></span>
						<span class="indicator"><i class="fa fa-users fa-lg"></i> <h4><?=$day['counters']['placed']?></h4></span>
						<span class="indicator"><i class="fa fa-exclamation fa-lg"></i> <h4><?=$day['counters']['notPlaced']?></h4></span>
					</div>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	<?php endforeach; ?>
</div>