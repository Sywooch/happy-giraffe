<?php $this->beginContent('//layouts/main'); ?>

<div class="section-banner section-banner-pattern">
    <div class="section-nav" style="left:25px;top:30px;">
		<?php
			$this->widget('zii.widgets.CMenu', array(
				'encodeLabel' => false,
				'items' => array(
					array(
						'label' => '<span><span>О конкурсе</span></span>',
						'url' => array('/contest/' . $this->contest->contest_id),
						'active' => $this->action->id == 'view',
						'linkOptions' => array(
							'class' => 'btn btn-blue-shadow',
						),
					),
					array(
						'label' => '<span><span>Правила</span></span>',
						'url' => array('/contest/rules/' . $this->contest->contest_id),
						'active' => $this->action->id == 'rules',
						'linkOptions' => array(
							'class' => 'btn btn-blue-shadow',
						),
					),
					array(
						'label' => '<span><span>Участники</span></span>',
						'url' => array('/contest/list/' . $this->contest->contest_id),
						'active' => $this->action->id == 'list',
						'linkOptions' => array(
							'class' => 'btn btn-blue-shadow',
						),
					),
				),
			));
		?>
	</div>
    <?php if($this->contest->isStatement): ?>
        <?php echo CHtml::link('Участвовать', array('/contest/statement', 'id' => $this->contest->primaryKey), array('class' => 'contest-takeapart')); ?>
    <?php endif; ?>
    <img src="/images/contest_banner_01.png" />
</div>
<?php echo $content; ?>
<?php $this->endContent(); ?>