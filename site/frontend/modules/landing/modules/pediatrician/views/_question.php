<?php
/**
 * @var \site\frontend\modules\som\modules\qa\models\QaQuestion $data
 */
?>

 <li class="questions_item clearfix">
  	<div class="questions-modification__box box-wrapper">
        <div class="box-wrapper__user">
        	<span class="box-wrapper__link"><?=$data->user->getFullName()?></span>
    		<span class="box-wrapper__date"><?= HHtml::timeTag($data, array('class' => 'tx-date')); ?></span>
    	</div>
        <div class="box-wrapper__header box-header">
        	<a href="<?=$data->formatedUrl(NULL, $data->categoryId)?>" class="box-header__link"><?=CHtml::encode($data->title)?></a>
          	<p class="box-header__text"><?=strip_tags($data->text)?></p>
        </div>
        <div class="box-wrapper__footer box-footer">
          	<?php if ($data->categoryId !== null): ?>
                  	<a href="<?=$this->createUrl('/som/qa/default/index/', ['categoryId' => $data->category->id])?>" class="box-footer__cat"><?=$data->category->title?></a>
      		<?php endif; ?>
      		<?php if (!is_null($data->tag)): ?>
      			<a href="<?=$this->createUrl('/som/qa/default/index/', ['categoryId' => $data->category->id, 'tagId' => $data->tag->id])?>" class="box-footer__cat"><?=$data->tag->name?></a>
      		<?php endif; ?>
          	<span class="box-footer__review"><?=Yii::app()->getModule('analytics')->visitsManager->getVisits($data->url)?></span>
          	<a class="box-footer__answer box-footer__answer_blue" href="<?=$data->url?>">
          		<span class="box-footer__num"><?=$data->answersCount?></span>
          		<span class="box-footer__descr">ответов</span>
      		</a>
      </div>
  	</div>
  	<div class="box-wrapper__answer answer-wrapper">
      	<?php if ($data->answersCount == 0): ?>
    		<?php if (Yii::app()->user->isGuest || Yii::app()->user->checkAccess('createQaAnswer', array('question' => $data))): ?>
    			<a href="<?=$data->url?>" class="answer-wrapper__box answer-wrapper__box_green">
    				<span class="answer-wrapper__num"><?=$data->answersCount?></span>
                	<span class="answer-wrapper__descr">ответить</span>
            	</a>
    		<?php endif; ?>
		<?php else: ?>
			<?php if ($data->isFromConsultation()): ?>
				<?php /**
				<a href="<?=$data->url?>" class="answer-wrapper__box answer-wrapper__box_blue">
					<span class="answer-wrapper__num"><?=$data->answersCount?></span>
                	<span class="answer-wrapper__descr">ответ</span>
    				<span href="<?=$data->user->profileUrl?>" class="awatar-wrapper__link">
            			<?php if ($data->lastAnswer->user->avatarUrl): ?>
            				<img src="<?=$data->lastAnswer->user->avatarUrl?>" class="awatar-wrapper__img">
            			<?php endif; ?>
            		</span>
        		</a>
        		**/?>
			<?php else: ?>
            	<a href="<?=$data->url?>" class="answer-wrapper__box answer-wrapper__box_blue">
                	<span class="answer-wrapper__num"><?=$data->answersCount?></span>
                	<span class="answer-wrapper__descr">ответа</span>
            	</a>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</li>