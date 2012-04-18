<?php $this->beginContent('//layouts/main'); ?>

<div class="section-banner section-banner-pattern">
    <div class="section-nav" style="left:25px;top:30px;">
		<?php
			$this->widget('zii.widgets.CMenu', array(
				'encodeLabel' => false,
				'items' => array(
					array(
						'label' => 'О конкурсе',
						'url' => array('/contest', 'id' => $this->contest->contest_id),
						'active' => $this->action->id == 'view',
					),
					array(
						'label' => 'Правила',
						'url' => array('/contest/rules', 'id' => $this->contest->contest_id),
						'active' => $this->action->id == 'rules',
					),
					array(
						'label' => 'Участники',
						'url' => array('/contest/list', 'id' => $this->contest->contest_id),
						'active' => $this->action->id == 'list',
					),
				),
			));
		?>
	</div>
    <?php if(!ContestWork::model()->findByAttributes(array('user_id' => Yii::app()->user->id, 'contest_id' => $this->contest->primaryKey))): ?>
        <?php echo CHtml::link('Участвовать', (Yii::app()->user->isGuest) ? '#login' : array('/contest/statement', 'id' => $this->contest->primaryKey), array('class' => (Yii::app()->user->isGuest) ? 'contest-takeapart fancy' : 'contest-takeapart')); ?>
    <?php endif; ?>
    <img src="/images/contest_banner_01.png" />
</div>
<div id="contest">
    <?php echo $content; ?>
</div>
<?php $this->endContent(); ?>