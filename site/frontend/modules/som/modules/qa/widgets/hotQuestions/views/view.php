<?php
/**
 * @var \site\frontend\modules\posts\modules\forums\widgets\hotQuestions\HotQuestions $this
 * @var array $data
 */
?>

<div class="margin-t30">
    <div class="b-widget-wrapper b-widget-wrapper_theme b-widget-wrapper_border">
      <div class="b-widget-header">
      	<a class="b-widget-header__btn hidden" href="/questions/popular/">Все</a>
        <div class="div b-widget-header__title b-widget-header__title_hot">Горячие темы</div>
      </div>
      <div class="b-widget-content">
        <ul class="b-widget-content__list">
        	<?php foreach ($data as /* @var $row \site\frontend\modules\som\modules\qa\models\QaQuestion */$row) {?>
              <li class="b-widget-content__item">
              	<div class="b-widget-content__ava">
              		<a href="<?=$row->user->profileUrl?>" class="ava ava__small ava__<?= $row->user->gender == 0 ? 'female' : 'male'?>">
              			<img alt="" src="<?=$row->user->avatarUrl?>">
          			</a>
      			</div>
                <div class="b-widget-content__title"><a class="link" href="<?=$row->url?>"><?=$row->title?></a></div>
                <div class="b-widget-group-btn">
                	<span class="b-widget-group-btn__view"><?=Yii::app()->getModule('analytics')->visitsManager->getVisits($row->url)?></span>
                	<span class="b-widget-group-btn__users"><?=$row->answersUsersCount() ?></span>
                	<span class="b-widget-group-btn__comment"><?=$row->answersCount?></span>
            	</div>
              </li>
          <?php } ?>
        </ul>
      </div>
    </div>
</div>
