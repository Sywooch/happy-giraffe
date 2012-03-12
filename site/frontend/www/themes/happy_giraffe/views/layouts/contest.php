<?php $this->beginContent('//layouts/main'); ?>

<div class="section-banner">
	<div class="section-nav" style="left:130px;top:30px;">
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
    <a href="" class="btn btn-red-transparent contest-takeapart"><span><span>Участвовать</span></span></a>
	<img src="/images/section_banner_02.jpg" />
</div>
<?php echo $content; ?>
<?php $this->endContent(); ?>