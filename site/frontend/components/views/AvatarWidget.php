<div class="ava<?php if ($user->gender !== null) echo ($user->gender) ? ' male' : ' female'; ?>">
	<?php if ($ava = $user->pic_small->getUrl('ava')) echo CHtml::image($ava); ?>
</div>
<?php if($this->withMail) echo $user->getDialogLink(); ?>