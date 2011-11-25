<?php
$model = $element->getParent()->getModel();
$attribute = $element->name;
?>
<div class="filter-box">
	<big class="box-title" onclick="toggleFilterBox(this)"><?php echo $element->getLabel(); ?></big>
	<div class="filter-radiogroup">
		<ul>
			<?php foreach ($element->items as $v=>$el): ?>
				<?php
				$class = ($model->$attribute == $v) ? ' class="active"' : '';
				; ?>
				<li<?php echo $class; ?>>
					<a href="javascript:void(0);" onclick="setItemRadiogroup(this, <?php echo $v; ?>);">
						<span><?php echo $el; ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php echo CHtml::activeHiddenField($model, $attribute); ?>
	</div>
</div>