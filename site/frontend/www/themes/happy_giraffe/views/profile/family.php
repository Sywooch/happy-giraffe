<?php
$this->user->refresh();
	$cs = Yii::app()->clientScript;
	
	$js = "
		$('div.child:gt(" . count($this->user->babies) . "), div.child:eq(" . count($this->user->babies) . ")').each(function() {
	        $(this).hide();
            $(this).find('.isset_child').val(0);
		});

		$('div.child-in').hover(function() {
		    $(this).children('.remove-baby').toggle();
		});
	
		function addField()
		{
			var div = $('div.child:hidden:first');
			div.show();
			div.find('.isset_child').val(1);
			if ($('div.child:hidden').length == 0)
			{
				$('#addBaby').parent().hide();
			}
		}
	
		$('#addBaby').click(function(e) {
			e.preventDefault();
			addField();
		});
	";
	
	$cs->registerScript('travel_add', $js)
    ->registerScriptFile('/javascripts/jquery.iframe-post-form.js')
    ->registerScriptFile('/javascripts/jquery.tmpl.min.js');
?>

<?php $this->breadcrumbs = array(
	'Профиль' => array('/profile'),
	'<b>Моя семья</b>',
); ?>

	<div class="profile-form-in">

		<div class="subtitle">Семейное положение:</div>

        <div class="photo-upload">
            <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'partner_form',
            'action' => $this->createUrl('family'),
        )); ?>

		<div class="row">
            <?php echo CHtml::dropDownList('relationship_status', $this->user->relationship_status,
            array('' => 'нет ответа') + $this->user->getRelashionshipList(),
            array(
                'class' => 'chzn',
            )); ?>
		</div>
	
		<div class="row row-inline" id="partner_name_bl"<?php
        if (!in_array($this->user->relationship_status, array(1,4,5))) echo ' style="display:none;"' ?>>
		
			<div class="row-title"><?php echo $this->user->getPartnerTitle($this->user->relationship_status) ?></div>
			<div class="row-elements">
				<div class="col">
                    <?php echo CHtml::textField('partner_name', empty($this->user->partner)?'':$this->user->partner->name) ?>
				</div>									
			</div>
	
		</div>

            <?php $this->endWidget(); ?>


		<div class="photo-upload">
            <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'partner_photo_upload',
            'action' => $this->createUrl('uploadPartnerPhoto'),
            'htmlOptions' => array(
                'enctype' => 'multipart/form-data',
            ),
        )); ?>
            <?php echo $form->hiddenField($this->user, 'id'); ?>

			<div class="left">
				<div class="img-box">
                    <?php if (isset($this->user->partner))
                        echo CHtml::image($this->user->partner->photo->getUrl('ava')); ?>
                    <?php
//                    $this->widget('DeleteWidget', array(
//                        'model' => $this->user->partner,
//                        'selector' => 'li',
//                    ));
                    ?>

				</div>
				<p>Вы можете загрузить сюда только фотографию Вашего мужа.</p>
			</div>
		
			<div class="upload-btn">
				<div class="file-fake">
					<button class="btn btn-orange"><span><span>Загрузить фото</span></span></button>
                    <?php echo CHtml::activeFileField(new UserPartner(), 'photo'); ?>
				</div>
				<br/>
				Загрузите файл (jpg, gif, png не более 4 МБ)
			</div>
            <?php $this->endWidget(); ?>

		</div>
		<br/>
        <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'baby-form',
        'htmlOptions'=>array(
            'enctype'=>'multipart/form-data'
        ))); ?>

        <?php for ($i = 0; $i < $maxBabies; $i++): ?>
			<?php
				$baby_model = $baby_models[$i];
			?>
			<div class="child">
                <?php echo CHtml::hiddenField('Baby['.$i.'][isset]', 1, array('class' => 'isset_child')) ?>
				<div class="age-box">
					<img src="/images/profile_age_img_01.png" /><br/>
					<span>0 - 1</span>
				</div>
				<div class="child-in">
					<a href="javascript:void(0);" class="fill-form" onclick="toggleChildForm(this);">Заполнить данные <?php echo (! empty($baby_model->name)) ? 'ребенка по имени ' . $baby_model->name : ($i + 1) . '-го ребенка' ?></a>
                    <?php echo CHtml::link('Удалить', array('/profile/removeBaby', 'id' => $i), array('style' => 'display:none;', 'class' => 'remove-baby', 'confirm' => 'Вы действительно хотите удалить ребенка?')); ?>
				</div>
	
				<div class="child-form">
		            <?php echo $form->errorSummary($baby_model); ?>
					<div class="row row-inline">
			
						<div class="row-title">Имя ребенка:</div>
						<div class="row-elements">
							<div class="col">
								<?php echo CHtml::textField('Baby['.$i.'][name]', $baby_model->name, array('maxlength' => 255)) ?>
							</div>
						</div>
		
					</div>
					<div class="row row-inline">
	
						<div class="row-title">Дата рождения:</div>
						<div class="row-elements">
							<div class="col">
                                <?php $days = array(); for($day = 1;$day <= 31;$day++) $days[$day] = $day; ?>
                                <?php $years = array(); for($year = 1980;$year <= date('Y');$year++) $years[$year] = $year; ?>
                                <?php echo CHtml::dropDownList('Baby['.$i.'][day]', date('d', strtotime($baby_model->birthday)), $days); ?>
								<?php echo CHtml::dropDownList('Baby['.$i.'][month]', date('m', strtotime($baby_model->birthday)), Yii::app()->locale->monthNames); ?>
                                <?php echo CHtml::dropDownList('Baby['.$i.'][year]', date('Y', strtotime($baby_model->birthday)), $years); ?>
							</div>
							<div class="col age">
								Возраст: <b>29</b> лет
							</div>
				
						</div>
		
					</div>
		
					<div class="row row-inline">
	
						<div class="row-title">Пол:</div>
						<div class="row-elements">
                            <?php echo CHtml::radioButtonList('Baby['.$i.'][sex]', $baby_model->sex, array(0 => 'Мальчик', 1 => 'Девочка')); ?>
						</div>
		
					</div>
		
					<div class="photo-upload">
			
						<div class="left">
							<div class="img-box noimg">
								<img src="/images/ava_noimg_female.png" />
					
							</div>
							<p>Вы можете загрузить сюда только фотографию Вашего ребенка.</p>
						</div>
			
						<div class="upload-btn">
							<div class="file-fake">
								<button class="btn btn-orange"><span><span>Загрузить фото</span></span></button>
								<input type="file" />
							</div>
							<br/>
							Загрузите файл (jpg, gif, png не более 4 МБ)
						</div>
			
					</div>
				</div>
	
			</div>
		<?php endfor; ?>
		<?php $this->endWidget(); ?>
	
		<a href="" class="btn btn-yellow-medium" id="addBaby"><span><span>Добавить ребенка</span></span></a>
	
	</div>
</div>
<div class="bottom">
	<button class="btn btn-green-medium btn-arrow-right" onclick="$('#baby-form').submit();"><span><span>Сохранить<img src="/images/arrow_r.png" /></span></span></button>
</div>
<script id="photo-tmpl" type="text/x-jquery-tmpl">
    <?php echo CHtml::image('${url}', '${title}'); ?>
</script>
<script type="text/javascript">
    $('#relationship_status').change(function(){
        if ($(this).val() == 1 || $(this).val() == 4 || $(this).val() == 5){
            if ($(this).val() == 1)
                $('#partner_name_bl .row-title').text('<?php echo $this->user->getPartnerTitle(1) ?>');
            if ($(this).val() == 4)
                $('#partner_name_bl .row-title').text('<?php echo $this->user->getPartnerTitle(4) ?>');
            if ($(this).val() == 5)
                $('#partner_name_bl .row-title').text('<?php echo $this->user->getPartnerTitle(5) ?>');

            $('#partner_name_bl').show();
        }else{
            $('#partner_name_bl').hide();
            $('#partner_name').val('');
        }
    });

    $('#partner_photo_upload').iframePostForm({
        json:true,
        complete:function (response) {
            if (response.status == '1') {
                $('#partner_photo_upload .img-box').html(
                    $('#photo-tmpl').tmpl({url:response.url, title:response.title})
                );
            }
        }
    });

    $('body').delegate('#UserPartner_photo', 'change', function () {
        $(this).parents('form').submit();
    });
</script>