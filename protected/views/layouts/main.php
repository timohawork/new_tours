<?php 
	$isAdmin = Yii::app()->user->checkAccess(Users::ROLE_ADMIN);
	$isSupport = !Yii::app()->user->isGuest && isset(Yii::app()->user->email) && Yii::app()->user->email === 'support.tours@serduk.com';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="language" content="ru" />
		<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="/css/main.css" />
		<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />
		<link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css" />
		<script type="text/javascript" src="/js/jquery.js"></script>
		<script type="text/javascript" src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
		<script type="text/javascript" src="/js/bootstrap-datepicker.ru.js"></script>
		<script type="text/javascript" src="/js/functions.js"></script>
		<?php if (!Yii::app()->user->isGuest) : ?>
			<script src="http://api-maps.yandex.ru/1.1/index.xml" type="text/javascript"></script>
			<script type="text/javascript" src="/js/jquery.form.js"></script>
			<script type="text/javascript" src="/js/bootstrap.min.js"></script>
		<?php endif; ?>
		<title>Экскурсии</title>
	</head>
	<body>
		<?php if (!Yii::app()->user->isGuest) : ?>
			<ul id="main-menu" class="list-group">
				<li class="list-group-item active">
					<h3><a href="/">Экскурсии</a></h3>
				</li>
				<?php if ($isSupport) : ?>
					<li class="list-group-item">
						<a href="/support"><i class="fa fa-comment-o fa-lg"></i><h4>Сообщения</h4></a>
					</li>
				<?php endif; ?>
				<li class="list-group-item">
					<a href="/"><i class="fa fa-search fa-lg"></i><h4>Регионы</h4></a>
				</li>
				<li class="list-group-item">
					<a href="/orders"><i class="fa fa-calendar fa-lg"></i><h4>Расписание</h4></a>
				</li>
				<?php if ($isAdmin) : ?>
					<li class="list-group-item">
						<a href="/points"><i class="fa fa-map-marker fa-lg"></i><h4>Объекты</h4></a>
					</li>
				<?php endif; ?>
				<?php /*<li class="list-group-item">
					<a href="/routs"><i class="fa fa-flag fa-lg"></i><h4>Маршруты</h4></a>
				</li>
				<?php if ($isAdmin) : ?>
					<li class="list-group-item">
						<a href="/tours"><i class="fa fa-bullhorn fa-lg"></i><h4>Экскурсии</h4></a>
					</li>
				<?php endif;*/ ?>
				<li class="list-group-item">
					<a id="" href="/guides"><i class="fa fa-bullhorn fa-lg"></i><h4>Гиды</h4></a>
				</li>
				<li class="list-group-item">
					<a id="" href="/cars"><i class="fa fa-truck fa-lg"></i><h4>Транспорт</h4></a>
				</li>
				<?php if ($isAdmin) : ?>
					<li class="list-group-item">
						<a href="/users"><i class="fa fa-users fa-lg"></i><h4>Пользователи</h4></a>
					</li>
					<li class="list-group-item">
						<a href="/clients"><i class="fa fa-user-plus fa-lg"></i><h4>Клиенты</h4></a>
					</li>
				<?php endif; ?>
				<li class="list-group-item">
					<a href="/index/logout"><i class="fa fa-power-off fa-lg"></i><h4>Выход</h4></a>
				</li>
			</ul>
			<div class="container">
				<?=$content?>
			</div>
		<?php else : ?>
			<?=$content?>
		<?php endif; ?>
		
		<?php if (!$isSupport && Yii::app()->controller->id !== 'api') : ?>
			<div id="support" class="panel panel-info">
				<a href="#" class="form-toggle"><i class="fa fa-comment fa-flip-horizontal fa-2x"></i></a>
				<div class="panel-heading">
					<h3 class="panel-title">Вопрос тех.поддержке</h3>
				</div>
				<div class="panel-body">
					<textarea name="text" class="form-control"></textarea>
					<a href="#" class="btn btn-info">Отправить</a>
				</div>
			</div>
		<?php endif; ?>
		
		<div id="image-editor" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title"></h4>
					</div>
					<div class="modal-body">
						<div class="image-frame">
							<img class="img-rounded" src="" alt="">
							<div class="frame-block">
								<div class="frame ui-widget-content"></div>
							</div>
						</div>
						<div class="buttons">
							<i class="fa fa-check fa-2x"></i>
							<i class="fa fa-refresh fa-2x"></i>
							<i class="fa fa-trash-o fa-2x"></i>
							<div class="photo-load"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
