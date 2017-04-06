<?php
/**
 * @var site\frontend\modules\som\modules\qa\widgets\answers\AnswersWidget $this
 * @var array   $rating
 * @var integer $flowerCount
 *
 */
?>

 <div class="b-answer-header__box b-answer-header-box">
    <div class="b-answer-header-box__item">
    	<span class="b-text-color--grey b-text--size-12">Ответы <?=$rating['answers_count']?></span>
    </div>
    <?php if ($flowerCount > 0): ?>
    <div class="b-answer-header-box__item">
    	<?php if($rating['votes_count'] > 10):?>
        <span class="b-answer-header-box__roze">
            <?php for($i=0; $i < $flowerCount; $i++){?>
            <span class="b-answer-header-box__ico"></span>
            <?php } ?>
        </span>
        <?php else:?>
        <span class="b-text-color--grey b-text--size-12">Спасибо</span>
        <?php endif;?>
        <span class="b-text-color--grey b-text--size-12"><?=$rating['votes_count']?></span>
    </div>
    <?php endif; ?>
</div>
