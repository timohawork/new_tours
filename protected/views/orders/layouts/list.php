<?php foreach ($tours as $tour) : ?>
	<?php $notPlaced = Orders::passSummCount($tour->orders); ?>
	<?php foreach ($tour->toursOrders as $order) : ?>
		<a class="order-tour-block" href="#" data-id="<?=$order->id?>">
			<?php if (!empty($tour->rout->images)) : ?>
				<img class="img-rounded" src="<?=$tour->rout->images[0]->getUrl('small')?>">
			<?php else : ?>
				<span class="fa-stack fa-lg image">
					<i class="fa fa-camera fa-stack-1x"></i>
					<i class="fa fa-ban fa-stack-2x text-danger"></i>
				</span>
			<?php endif; ?>
			<h3 class="title"><?=$tour->title?></h3>
			<div class="order-indicators">
				<div class="placed-pass"><i class="fa fa-users fa-lg"></i> <?=Orders::passSummCount($order->orders)?></div>
				<div class="not-placed-pass<?=$notPlaced > 0 ? ' active' : ''?>"><i class="fa fa-exclamation fa-lg"></i> <?=$notPlaced?></div>
				<div class="car-pass"><i class="fa fa-truck fa-lg"></i> <?=$order->car->passCount?></div>
			</div>
		</a>
	<?php endforeach; ?>
<?php endforeach; ?>