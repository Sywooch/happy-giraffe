<style type="text/css">
    .admin-btn-temp {
        background: green;
        color: #FFFFFF;
        font-size: 16px;
        font-weight: bold;
        height: 30px;
        width: 150px;
    }
    .famous, .famous2{
        margin: 15px;
        padding: 5px;
        border: 1px solid #000;
    }
</style>
<script type="text/javascript">
    var num = 1;
    $(function () {
        $('#plus-famous').click(function () {
            var block = '<br>Новая знаменитость<div class="row">' +
                '<label for="">Фамилия</label>' +
                '<input type="text" id="famous_' + num + '_last_name" name="famous[' + num + '][last_name]" value="">' +
                '</div>' +
                '<div class="row">' +
                '<label for="">Описание</label>' +
                '<input type="text" id="famous_' + num + '_description" name="famous[' + num + '][description]" value="">' +
                '</div>' +
                '<div class="row">' +
                '<label for="">Фото</label>' +
                '<input type="file" id="famous_' + num + '_photo" name="famous[' + num + '][photo]" value="">' +
                '</div>';

            $('.famous').append(block);
            num++;
            return false;
        });

        $('.delete-famous').click(function(){
            var id = $(this).attr('rel');
            $.ajax({
                url: '<?php echo Yii::app()->createUrl("admin/nameFamous/delete2") ?>',
                data: 'id='+id,
                type: 'POST',
                success: function(data) {
                    $('#name_famous_'+id).remove();
                }
            });

            return false;
        });
    });
</script>
<?php
/* @var $this Controller
 * @var $form CActiveForm
 */
?>
<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'name-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data'),
)); ?>

    <p class="note">Поля с <span class="required">*</span> обязательны.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 30, 'maxlength' => 30)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'gender'); ?>
        <?php echo $form->dropDownList($model, 'gender', array('1' => 'мужское', '2' => 'женское')); ?>
        <?php echo $form->error($model, 'gender'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'translate'); ?>
        <?php echo $form->textField($model, 'translate', array('size' => 60, 'maxlength' => 512)); ?>
        <?php echo $form->error($model, 'translate'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'origin'); ?>
        <?php echo $form->textField($model, 'origin', array('size' => 60, 'maxlength' => 2048)); ?>
        <?php echo $form->error($model, 'origin'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php echo $form->textArea($model, 'description', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'options'); ?>
        <?php echo $form->textField($model, 'options', array('size' => 60, 'maxlength' => 512)); ?>
        <?php echo $form->error($model, 'options'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'sweet'); ?>
        <?php echo $form->textField($model, 'sweet', array('size' => 60, 'maxlength' => 512)); ?>
        <?php echo $form->error($model, 'sweet'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'middle_names'); ?>
        <?php echo $form->textField($model, 'middle_names', array('size' => 60, 'maxlength' => 1024)); ?>
        <?php echo $form->error($model, 'middle_names'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'saints'); ?>
        <?php echo $form->textArea($model, 'saints', array('rows' => 3, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'saints'); ?>
    </div>

    <br>
    <h2>Знаменитости</h2>
    <br>

<?php foreach ($model->nameFamouses as $famous): ?>
    <div id="name_famous_<?php echo $famous->id ?>" class="famous2">
    <?php echo $famous->GetAdminPhoto() ?>
    <?php echo $famous->last_name ?><br>
    <a class="delete-famous" rel="<?php echo $famous->id ?>" href="#">удалить</a>
    </div>
<?php endforeach; ?>

    <div class="famous">
        <div class="row">
            <?php echo CHtml::label('Фамилия', ''); ?>
            <?php echo CHtml::textField('famous[0][last_name]', ''); ?>
        </div>
        <div class="row">
            <?php echo CHtml::label('Описание', ''); ?>
            <?php echo CHtml::textField('famous[0][description]', ''); ?>
        </div>
        <div class="row">
            <?php echo CHtml::label('Фото', ''); ?>
            <?php echo CHtml::fileField('famous[0][photo]', ''); ?>
        </div>
    </div>
    <a id="plus-famous" href="#">Добавить знаменитость</a>


    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('class' => 'admin-btn-temp')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->