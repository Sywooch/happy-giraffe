<div class="ava<?php if ($user->gender !== null) echo ($user->gender) ? ' male' : ' female'; ?>">
	<?php if ($ava = str_replace('club', 'shop', $user->pic_small->getUrl('ava'))) echo CHtml::image($ava); ?>
</div>