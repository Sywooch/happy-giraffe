<?php $this->beginContent('//layouts/main'); ?>

<div class="section-banner section-banner-pattern">
    <div class="section-nav" style="left:25px;top:30px;">
		<?php
			$this->widget('zii.widgets.CMenu', array(
				'encodeLabel' => false,
				'items' => array(
                    array(
                        'label' => 'О конкурсе',
                        'url' => array('/contest/default/view', 'id' => $this->contest->id),
                        'active' => $this->action->id == 'view',
                    ),
                    array(
                        'label' => 'Правила',
                        'url' => array('/contest/default/rules', 'id' => $this->contest->id),
                        'active' => $this->action->id == 'rules',
                    ),
                    array(
                        'label' => 'Участники',
                        'url' => array('/contest/default/list', 'id' => $this->contest->id),
                        'active' => $this->action->id == 'list',
                    ),
                    array(
                        'label' => 'Победители',
                        'url' => array('/contest/default/results', 'id' => $this->contest->id),
                        'active' => $this->action->id == 'results',
                    ),
				),
			));
		?>
	</div>
    <?php if($this->contest->isStatement): ?>
        <?php echo CHtml::link('Участвовать', (Yii::app()->user->isGuest) ? '#register' : array('/contest/default/statement', 'id' => $this->contest->primaryKey), array('class' => (Yii::app()->user->isGuest) ? 'contest-takeapart fancy' : 'contest-takeapart', 'data-theme'=>"white-square")); ?>
    <?php endif; ?>
    <img src="/images/contest_banner_01.png" />
</div>
<div id="contest">
    <?php echo $content; ?>
</div>
<?php $this->endContent(); ?>