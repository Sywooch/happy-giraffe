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


<div class="subtitle">Семейное положение:</div>

<div class="row">
    <?php echo CHtml::dropDownList('relationship_status', $this->user->relationship_status,
    array('' => 'нет ответа') + $this->user->getRelashionshipList(),
    array(
        'class' => 'chzn',
    )); ?>
</div>

<div id="partner_name_bl"<?php
    if (!in_array($this->user->relationship_status, array(1, 4, 5))) echo ' style="display:none;"' ?>>
    <div class="row row-inline clearfix">

        <div class="row-title">
            <span><?php echo $this->user->getPartnerTitle($this->user->relationship_status) ?></span>
            <?php echo CHtml::textField('partner_name', empty($this->user->partner) ? '' : $this->user->partner->name) ?>
        </div>
    </div>
    <div class="row row-inline clearfix">
        <div class="row-title">Заметка:
            <?php echo CHtml::textField('partner_notice', empty($this->user->partner) ? '' : $this->user->partner->notice) ?>
        </div>
    </div>

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
        <div class="img-box <?php echo ($this->user->gender == 1) ? 'female' : 'male' ?> ava">
            <?php $url = isset($this->user->partner)?$this->user->partner->photo->getUrl('ava'):''; ?>
            <?php if (!empty($url)): ?>
                <?php echo CHtml::image($url) ?>
                <a href="" class="remove"></a>
            <?php endif; ?>

        </div>
        <p>Вы можете загрузить сюда только фотографию Вашего мужа.</p>
    </div>

    <div class="upload-btn">
        <div class="file-fake">
            <button class="btn btn-orange"><span><span>Загрузить фото</span></span></button>
            <?php echo CHtml::activeFileField(new UserPartner(), 'photo', array('id' => 'UserPartnerPhotoFile')); ?>
        </div>
        <br/>
        Загрузите файл (jpg, gif, png не более 4 МБ)
    </div>
    <?php $this->endWidget(); ?>
</div>
</div>

<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'baby-form',
    'action' => $this->createUrl('profile/preview'),
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data'
    ))); ?>

<?php for ($i = 0; $i < $maxBabies; $i++): ?>
<?php
    $baby_model = $baby_models[$i];
    ?>
<div class="child" id="child<?php echo $baby_model->id ?>">
    <?php echo CHtml::hiddenField('Baby[' . $i . '][isset]', 1, array('class' => 'isset_child')) ?>
    <div class="age-box">
        <img src="<?php echo $baby_model->getAgeImageUrl() ?>"/><br/>
        <span><?php echo isset($baby_model->birthday) ? $baby_model->getAge() : '0-1' ?></span>
    </div>
    <div class="child-in">
        <a href="javascript:void(0);" class="fill-form" onclick="toggleChildForm(this);">Заполнить
            данные <?php echo (!empty($baby_model->name)) ? 'ребенка по имени ' . $baby_model->name : ($i + 1) . '-го ребенка' ?></a>
        <?php echo CHtml::link('Удалить', array('/profile/removeBaby', 'id' => $i), array('style' => 'display:none;', 'class' => 'remove-baby', 'confirm' => 'Вы действительно хотите удалить ребенка?')); ?>
    </div>

    <div class="child-form">
        <?php echo $form->errorSummary($baby_model); ?>
        <div class="row row-inline">

            <div class="row-title">Имя ребенка:</div>
            <div class="row-elements">
                <div class="col">
                    <?php echo CHtml::textField('Baby[' . $i . '][name]', $baby_model->name, array('maxlength' => 255)) ?>
                </div>
            </div>

            <div class="row-title">Заметка:</div>
            <div class="row-elements">
                <div class="col">
                    <?php echo CHtml::textField('Baby[' . $i . '][notice]', $baby_model->notice, array('maxlength' => 1024)) ?>
                </div>
            </div>

        </div>
        <div class="row row-inline">

            <div class="row-title">Дата рождения:</div>
            <div class="row-elements">
                <div class="col">
                    <?php $days = array(); for ($day = 1; $day <= 31; $day++) $days[$day] = $day; ?>
                    <?php $years = array(); for ($year = 1980; $year <= date('Y'); $year++) $years[$year] = $year; ?>
                    <?php echo CHtml::dropDownList('Baby[' . $i . '][day]', date('j', strtotime($baby_model->birthday)), $days, array('class'=>'chzn', 'style' => 'width:79px')); ?>
                    <?php echo CHtml::dropDownList('Baby[' . $i . '][month]', date('n', strtotime($baby_model->birthday)), Yii::app()->locale->monthNames, array('class'=>'chzn', 'style' => 'width:79px')); ?>
                    <?php echo CHtml::dropDownList('Baby[' . $i . '][year]', date('Y', strtotime($baby_model->birthday)), $years, array('class'=>'chzn', 'style' => 'width:79px')); ?>
                </div>
                <div class="col age">
                    Возраст: <?=$baby_model->getTextAge()?>
                </div>

            </div>

        </div>

        <div class="row row-inline">

            <div class="row-title">Пол:</div>
            <div class="row-elements">
                <div class="col">
                    <label><input type="radio" <?php if ($baby_model->sex == 0) echo 'checked="checked"' ?> name="Baby[<?=$i?>][sex]" id="Baby_<?=$i?>_sex_0" value="0" />
                    Девочка</label>
                </div>
                <div class="col">
                    <label><input type="radio" <?php if ($baby_model->sex == 1) echo 'checked="checked"' ?> name="Baby[<?=$i?>][sex]" id="Baby_<?=$i?>_sex_1" value="1" />
                     Мальчик</label>
                </div>
            </div>

        </div>

        <div class="photo-upload">

            <div class="left">
                <div class="img-box <?= ($this->user->gender == 0) ? 'female' : 'male' ?> ava">
                    <?php $url = isset($baby_model->photo) ? $baby_model->photo->getUrl() : '' ?>
                    <?php if (!empty($url))
                    echo CHtml::image($baby_model->photo->getUrl('ava'), '', array('id' => 'babyImg-' . $i)).'<a href="" class="remove"></a>';?>
                </div>
                <p>Вы можете загрузить сюда только фотографию Вашего ребенка.</p>
            </div>

            <div class="upload-btn">
                <div class="file-fake">
                    <button class="btn btn-orange"><span><span>Загрузить фото</span></span></button>
                    <?php echo CHtml::activeFileField(new Baby(), 'photo', array(
                    'id' => 'baby-photo-' . $i,
                    'name' => 'Baby[' . $i . '][photo]',
                    'class' => 'baby-photo-file')); ?>
                </div>
                <br/>
                Загрузите файл (jpg, gif, png не более 4 МБ)
            </div>

        </div>
    </div>

</div>
<?php endfor; ?>

<input type="hidden" id="active_baby_num" name="baby_num">
<input type="hidden" id="user_partner_name" name="User[partner_name]">
<input type="hidden" id="user_partner_notice" name="User[partner_notice]">
<input type="hidden" id="user_relationship_status" name="User[relationship_status]">

<?php $this->endWidget(); ?>

<a href="" class="btn btn-yellow-medium" id="addBaby"><span><span>Добавить ребенка</span></span></a>

<div class="bottom">
    <button id="submit-btn" class="btn btn-green-medium btn-arrow-right"><span><span>Сохранить<img
        src="/images/arrow_r.png"/></span></span></button>
</div>

<script id="photo-tmpl" type="text/x-jquery-tmpl">
    <?php echo CHtml::image('${url}', '${title}'); ?>
    <a href="" class="remove"></a>
</script>
<script type="text/javascript">
    var baby_num = null;
    $('#submit-btn').click(function () {
        $('#baby-form').attr('action', '<?php echo CController::createUrl('profile/family') ?>').removeAttr('target');
        $('#user_partner_name').val($('#partner_name').val());
        $('#user_partner_notice').val($('#partner_notice').val());
        $('#user_relationship_status').val($('#relationship_status').val());
        $('#baby-form').submit();

        return false;
    });

    $('#relationship_status').change(function () {
        if ($(this).val() == 1 || $(this).val() == 4 || $(this).val() == 5) {
            if ($(this).val() == 1)
                $('#partner_name_bl .row-title span').text('<?php echo $this->user->getPartnerTitle(1) ?>');
            if ($(this).val() == 4)
                $('#partner_name_bl .row-title span').text('<?php echo $this->user->getPartnerTitle(4) ?>');
            if ($(this).val() == 5)
                $('#partner_name_bl .row-title span').text('<?php echo $this->user->getPartnerTitle(5) ?>');
            $('#partner_name_bl').show();
        } else {
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

    $('body').delegate('#UserPartnerPhotoFile', 'change', function () {
        $(this).parents('form').submit();
    });

    $('#baby-form').iframePostForm({
        complete:function (response) {
            $('#babyImg-' + baby_num).attr('src', response);
        }
    });

    $('body').delegate('.child .baby-photo-file', 'change', function () {
        baby_num = $('.child').index($(this).parents('div.child'));
        $('input#active_baby_num').val(baby_num);
        $(this).parents('form').submit();
    });

    $('body').delegate('.child .photo-upload a.remove', 'click', function () {
        var id = $(this).parents('.child').attr('id').replace(/child/, '');
        $.ajax({
            url:'<?php echo Yii::app()->createUrl("profile/RemoveBabyPhoto") ?>',
            data:{id:id},
            type:'POST',
            dataType:'JSON',
            success:function (response) {
                if (response.status)
                    $(this).parent().html('');
            },
            context:$(this)
        });
        return false;
    });

    $('body').delegate('#partner_photo_upload  a.remove', 'click', function () {
        $.ajax({
            url:'<?php echo Yii::app()->createUrl("profile/RemovePartnerPhoto") ?>',
            type:'POST',
            dataType:'JSON',
            success:function (response) {
                if (response.status)
                    $(this).parent().html('');
            },
            context:$(this)
        });
        return false;
    });
</script>