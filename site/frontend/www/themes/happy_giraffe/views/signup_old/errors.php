<div class="form-error-summary">
	<big>Вы допустили ошибки при заполении формы:</big>
	<ul>
		<? foreach ($errors as $e): ?>
			<li><?php echo $e; ?></li>
		<? endforeach; ?>
	</ul>
</div>