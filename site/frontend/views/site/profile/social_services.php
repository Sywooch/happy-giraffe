<h1>Ваши ID в социальных сетях</h1>
<? if ($services): ?>
	<table>
		<tr>
			<td>
				Сеть
			</td>
			<td>
				ID
			</td>
			<td>
				Действие
			</td>
		</tr>
	<? foreach ($services as $service): ?>
		<tr>
			<td>
				<?=$service->service?>
			</td>

			<td>
				<?=$service->service_id?>
			</td>
			<td>
				<a href="">Отвязать</a>
			</td>
		</tr>
	<? endforeach; ?>
	</table>
<? endif; ?>

<?php Yii::app()->eauth->renderWidget(array('action' => 'site/profile')); ?>