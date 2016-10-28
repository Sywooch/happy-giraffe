<?php
/**
 * @var string $rootAnswerContent
 * @var string $childAnswerContent
 */
?>
<li class="questions_item clearfix">
	<?=$rootAnswerContent?>
	<?php if ($childAnswerContent):?>
	<div class="pediator-answer__right pediator-answer__right--theme-pediator">
		<?=$childAnswerContent?>
	</div>
	<?php endif;?>
</li>
