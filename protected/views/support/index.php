<div class="panel panel-default">
	<div class="panel-heading">
		<h1>Сообщения</h1>
	</div>
	<div id="messages_list" class="panel-body table-listing">
		<?php $this->renderPartial('layouts/list', array(
			'messages' => $messages
		)); ?>
	</div>
</div>