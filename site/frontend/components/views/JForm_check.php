<?php
$model = $element->getParent()->getModel();
$attribute = $element->name;

$selected = $model->$attribute ? $model->$attribute : array();

?>
<div class="filter-box">
	<big class="box-title" onclick="toggleFilterBox(this)"><?php echo $element->getLabel(); ?></big>
	<div class="filter-radiogroup filter-radiogroup-multiply">
		<ul>
			<?php foreach ($element->items as $v=>$el): ?>
				<?php
				$class = (in_array($v, $selected)) ? ' class="active"' : '';
				?>
				<li<?php echo $class; ?>>
					<a id="<?php echo $attribute.'_'.$v.'_'; ?>" href="javascript:void(0);" onclick="setItemRadiogroup(this, <?php echo $v; ?>);">
						<span><?php echo $el; ?></span>
					</a>
					<a class="remove" onclick="unsetItemRadiogroup(this);"></a>
					<?php echo CHtml::hiddenField(get_class($model).'['.$attribute.'][]', in_array($v, $selected) ? $v : '', array(
						'id'=>$attribute.'_'.$v.'_hidden',
					)); ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>