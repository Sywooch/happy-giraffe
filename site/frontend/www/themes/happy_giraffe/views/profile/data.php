<?php
	$cs = Yii::app()->clientScript;
	
	if ($current_region !== null)
	{
		$js = "
setTimeout(function() {
	$('#region_id').trigger('change');
});
		";
		$cs->registerScript('profile_data', $js, CClientScript::POS_READY);
	}
?>

<?php $this->breadcrumbs = array(
	'Профиль' => array('/profile'),
	'<b>Личная информация</b>',
); ?>

<?php $form = $this->beginWidget('CActiveForm'); ?>
	<div class="profile-form-in">
	
		<?php echo $form->errorSummary($this->user); ?>
	
		<div class="row row-inline">
		
			<div class="row-title">Персональные данные:</div>
			<div class="row-elements">
				<div class="col">
					<?php echo $form->textField($this->user, 'last_name', array(
						'placeholder' => 'Фамилия',
						'class' => 'placeholder',
						'onfocus' => 'unsetPlaceholder(this);',
						'onblur' => 'setPlaceholder(this);',
					)); ?>
				</div>
				<div class="col">
					<?php echo $form->textField($this->user, 'first_name', array(
						'placeholder' => 'Имя',
						'class' => 'placeholder',
						'onfocus' => 'unsetPlaceholder(this);',
						'onblur' => 'setPlaceholder(this);',
					)); ?>
				</div>
			
			</div>
	
		</div>
	
		<div class="row row-inline">
			
			<div class="row-title">Дата рождения:</div>
			<div class="row-elements">
				<div class="col">
					<?php
						$this->widget('DateWidget', array(
							'model' => $this->user,
							'attribute' => 'birthday',
						));
					?>
				</div>
				<div class="col age">
					Возраст: <b><?php echo $this->user->age; ?></b> лет
				</div>
				
			</div>
		
		</div>
	
		<div class="row row-inline">
		
			<div class="row-title">Пол:</div>
			<div class="row-elements">
				<div class="col">
					<label><?php echo $form->radioButton($this->user, 'gender', array('value' => 0)); ?> Женщина</label>
				
				</div>
				<div class="col">
					<label><?php echo $form->radioButton($this->user, 'gender', array('value' => 1)); ?> Мужчина</label>
				</div>
			
			</div>
	
		</div>
	
		<div class="row row-inline">
		
			<div class="row-title">Место жительства:</div>
			<div class="row-elements">
				<div class="col">
					<?php echo CHtml::dropDownList('region_id', $current_region, $regions, array(
						'ajax' => array(
							'type'=>'POST',
							'url'=>CController::createUrl('ajax/settlements'),
							'update'=>'#User_settlement_id',
						),
					)); ?>
				</div>
				<div class="col">
					<? echo CHtml::dropDownList('User[settlement_id]','', array()); ?>
				</div>
			
			</div>
	
		</div>
	
		<div class="row row-inline">
		
			<div class="row-title">E-mail:</div>
			<div class="row-elements">
				<div class="col">
					<?php echo $form->textField($this->user, 'email'); ?>
				</div>									
			</div>
	
		</div>
	
		<div class="row row-inline">
			<div class="row-title">Удалить анкету:</div>
			<div class="row-elements"><div class="text">Да, я хочу <?php echo CHtml::link('Удалить анкету', array('remove'), array('class' => 'remove', 'confirm' => 'Вы действительно хотите удалить анкету?')) ?>, потеряв всю введенную информацию без возможности восстановления.</div></div>
		</div>
	
	</div>
</div>
<div class="bottom">
	<button class="btn btn-green-medium btn-arrow-right"><span><span>Сохранить<img src="/images/arrow_r.png" /></span></span></button>
</div>
<?php $this->endWidget(); ?>