<?php
/* @var $this Controller
 * @var $name Name
 */
?>
<div class="bodyr long">
    <div class="editName">
        <h1 class="edit name"<?php AdminHelper::HideIfTrue($name->isNewRecord) ?>><?php echo $name->name ?></h1>
        <div class="name"<?php AdminHelper::HideIfTrue(!$name->isNewRecord) ?>>
            <input type="text" class="h1" value="<?php echo $name->name ?>"/>
            <input type="button" class="greenGradient" value="Ok"/>

            <div class="clear"></div>
        </div>
        <div class="clear"></div>

        <div class="right"<?php if ($name->isNewRecord) echo ' style="display:none;"' ?>>
            <div class="right_block">
                <div class="translate">
                    <div class="name_bold edit">Значение имени</div>
                    <div class="edit_value"<?php AdminHelper::HideIfNotEmpty($name->translate) ?>>
                        <textarea rows="10" cols="20"></textarea>
                        <input id="translate-cancel" type="button" value="Отменить" class="greyGradient"/>
                        <input type="submit" value="Ok" class="greenGradient"/>
                    </div>
                    <p class="name_value"<?php AdminHelper::HideIfEmpty($name->translate) ?>>"<span><?php echo $name->translate ?></span>"</p>
                </div>

                <div class="name_bold">Святцы</div>
                <div class="calendar">
                    <?php foreach ($name->nameSaintDates as $saint): ?>
                        <?php $this->renderPartial('_saint_date',array('model'=>$saint)); ?>
                    <?php endforeach; ?>

                    <a href="#add_calendar" class="add fancy" title="Добавить дату">+</a>

                    <div class="clear"></div>
                </div>
            </div>

        </div>
        <div class="center"<?php if ($name->isNewRecord) echo ' style="display:none;"' ?>>

            <div class="sex">
                <p class="name">Имя</p>
                <a href="#" class="boys<?php if ($name->gender == '1') echo ' active' ?>">Мальчики</a>
                <a href="#" class="girls<?php if ($name->gender == '2') echo ' active' ?>">Девочки</a>

                <div class="clear"></div>
            </div>

            <div class="name_info">
                <div class="line">
                    <?php $this->renderPartial('_options',array('name'=>$name)); ?>
                </div>
                <div class="line">
                    <?php $this->renderPartial('_sweet',array('name'=>$name)); ?>
                </div>
            </div>

            <div class="character_name descr">
                <div class="name_bold edit">Характеристика имени</div>
                <div<?php AdminHelper::HideIfNotEmpty($name->description) ?>>
                    <textarea rows="20" cols="50"><?php echo $name->description ?></textarea>
                    <input id="descr-cancel" type="button" value="Отменить" class="greyGradient"/>
                    <input type="submit" value="Ok" class="greenGradient"/>
                </div>
                <p<?php AdminHelper::HideIfEmpty($name->description) ?>><?php echo $name->description ?></p>
            </div>
            <div class="clear"></div>

            <div class="character_name origin">
                <div class="name_bold edit">Происхождение имени</div>
                <div<?php AdminHelper::HideIfNotEmpty($name->origin) ?>>
                    <textarea rows="20" cols="50"><?php echo $name->origin ?></textarea>
                    <input id="origin-cancel" type="button" value="Отменить" class="greyGradient"/>
                    <input type="submit" value="Ok" class="greenGradient"/>
                </div>
                <p<?php AdminHelper::HideIfEmpty($name->origin) ?>><?php echo $name->origin ?></p>
            </div>
            <div class="clear"></div>

            <div class="patronymic clearfix">
                <?php $this->renderPartial('_middle',array('name'=>$name)); ?>
            </div>

            <div class="famous">
                <div class="name_bold">Известные личности с именем</div>
                <?php foreach ($name->famous as $famous): ?>
                    <?php $this->renderPartial('_famous',array('model'=>$famous)); ?>
                <?php endforeach; ?>
                <a class="famous_add fancy" href="#famous_add"></a>

                <div class="clear"></div>
            </div>

            <div class="clear"></div>
        </div>
    </div>
</div>
<?php $this->renderPartial('_init_widgets',array('name'=>$name)); ?>
<div style="display:none">
    <div id="famous_add" class="popup">
        <a href="javascript:void(0);" onclick="$.fancybox.close();" class="popup-close">Закрыть</a>

        <div>
            <h2>Добавить известную личность</h2>

            <div class="content_block">
                <div class="input_block">
                    <form id="famous-form">
                        <p>
                            <label>Фамилия</label>
                            <input type="text" value="" name="NameFamous[last_name]"/>
                        </p>

                        <p>
                            <label>Известен</label>
                            <textarea name="NameFamous[description]"></textarea>
                        </p>

                        <p>
                            <label>www</label>
                            <input type="text" value="" name="NameFamous[link]"/>
                        </p>
                        <input type="hidden" name="NameFamous[photo]">
                        <input type="hidden" name="NameFamous[id]">
                    </form>
                </div>
                <?php $model = new NameFamous() ?>
                <?php $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'small_foto_upload',
                    'action' => $this->createUrl('uploadPhoto'),
                    'htmlOptions' => array(
                        'enctype' => 'multipart/form-data',
                    ),
                )); ?>
                <a class="add_photo fake_file" id="link_upload">
                    <div class="add_photo_ins">
                        <ins>Загрузить фото</ins>
                    </div>
                    <?php echo CHtml::fileField('photo', '', array('id'=>'photo_file_upload')); ?>
                </a>
                <?php $this->endWidget(); ?>

                <div class="clear"></div>
            </div>
            <input type="submit" class="greenGradient" value="Добавить"/>

            <div class="clear"></div>
        </div>
    </div>
</div>
<div style="display:none">
    <div id="add_calendar" class="popup">
        <a href="javascript:void(0);" onclick="$.fancybox.close();" class="popup-close">Закрыть</a>

        <form action="#" id="calendar-form">
            <div class="content_block">
                <?php echo CHtml::dropDownList('day','',HDate::Days(), array('empty'=>' ')) ?>
                <?php echo CHtml::dropDownList('month','',HDate::ruMonths(), array('empty'=>' ')) ?>
                <input type="button" value="Ok" class="greenGradient ok"/>
            </div>

            <input type="submit" class="greenGradient" value="Сохранить"/>

            <div class="clear"></div>
        </form>
    </div>
</div>
<script type="text/javascript">
    var model_id = <?php echo ($name->isNewRecord)?'null':$name->id ?>;
    $(function() {
        $('select').selectBox();

        /**************************** Ласковые имена, варианты, отчества **************************************/
        $('.add.small').click(function(){
            $(this).parent().append('<form class="input-text-add-form" action="#">' +
                '<input type="text" value=""/>' +
                '<input type="submit" value="Ok" class="greenGradient ok"/>' +
                '</form>');
            $(this).hide();
            return false;
        });

        $('body').delegate('form.input-text-add-form input[type=submit]', 'click', function(){
            var bl = $(this).parent('form').parent();
            var text = $(this).parent('form').find('input[type=text]').val();
            var modelName = bl.find('input[name=modelName]').val();

            $.ajax({
                url: '/club/names/addValue/',
                data: {
                    text: text,
                    modelId: model_id,
                    modelName:modelName
                },
                type: 'POST',
                dataType:'JSON',
                success: function(data) {
                    if (data.status){
                        bl.find('form').remove();
                        bl.find('.add.small').show();
                        bl.find('.add.small').before(data.html);
                        RefreshTooltip(bl.find('.add.small').prev().find('a'));
                    }
                },
                context:bl
            });

            return false;
        });

        /********** Название *********/
        $('h1.edit').click(function () {
            $(this).hide();
            $(this).next().show();

            return false;
        });

        $('div.name input[type=button]').click(function () {
            var title = $(this).prev().val();
            if (title != '') {
                if (model_id == null)
                    $.ajax({
                        url:'/club/names/create/',
                        data:{title:title},
                        type:'POST',
                        dataType:'JSON',
                        success:function (data) {
                            if (data.status) {
                                $('div.editName > div.center').show();
                                $('div.editName > div.right').show();
                                model_id = data.id;

                                $(this).parent().hide();
                                $(this).parent().prev().text(title);
                                $(this).parent().prev().show();
                            }
                        },
                        context:$(this)
                    });
                else {
                    $.ajax({
                        url:'<?php echo Yii::app()->createUrl("ajax/SetValue") ?>',
                        data:{
                            modelPk:model_id,
                            attribute:'name',
                            modelName:'Name',
                            value:title
                        },
                        type:'POST',
                        success:function (data) {
                            $(this).parent().hide();
                            $(this).parent().prev().text(title);
                            $(this).parent().prev().show();
                        },
                        context:$(this)
                    });
                }
            }
        });

        /********** Пол имени *********/
        $('.sex .boys').click(function () {
            if (!$(this).hasClass('active')) SetGender(1, $(this));
            return false;
        });
        $('.sex .girls').click(function () {
            if (!$(this).hasClass('active')) SetGender(2, $(this));
            return false;
        });

        /********** Описание имени *********/
        $('#descr-cancel').click(function () {
            if (model_id != null) {
                $(this).parent().hide();
                $(this).parent().next().show();
            }
        });

        $('.descr .edit').click(function () {
            $(this).next().show();
            $(this).next().next().hide();
            $(this).parent().find('textarea').val($(this).parent().find('p').text());

            return false;
        });

        $('.descr input[type=submit]').click(function () {
            var text = $(this).prev().prev().val();
            $.ajax({
                url:'<?php echo Yii::app()->createUrl("ajax/SetValue") ?>',
                data:{
                    modelPk:model_id,
                    attribute:'description',
                    modelName:'Name',
                    value:text
                },
                type:'POST',
                success:function (data) {
                    if (data) {
                        $(this).parent().hide();
                        $(this).parent().parent().find('p').text(text);
                        $(this).parent().parent().find('p').show();
                    }
                },
                context:$(this)
            });
            return false;
        });

        /********** Происхождение имени *********/
        $('#origin-cancel').click(function () {
            if (model_id != null) {
                $(this).parent().hide();
                $(this).parent().next().show();
            }
        });

        $('.origin .edit').click(function () {
            $(this).next().show();
            $(this).next().next().hide();
            $(this).parent().find('textarea').val($(this).parent().find('p').text());

            return false;
        });

        $('.origin input[type=submit]').click(function () {
            var text = $(this).prev().prev().val();
            $.ajax({
                url:'<?php echo Yii::app()->createUrl("ajax/SetValue") ?>',
                data:{
                    modelPk:model_id,
                    attribute:'origin',
                    modelName:'Name',
                    value:text
                },
                type:'POST',
                success:function (data) {
                    if (data) {
                        $(this).parent().hide();
                        $(this).parent().parent().find('p').text(text);
                        $(this).parent().parent().find('p').show();
                    }
                },
                context:$(this)
            });
            return false;
        });


        /********** Значение имени *********/
        $('#translate-cancel').click(function () {
            if (model_id != null) {
                $(this).parent().hide();
                $(this).parent().next().show();
            }
        });

        $('.translate .edit').click(function () {
            $(this).next().show();
            $(this).next().next().hide();
            $(this).parent().find('textarea').val($(this).parent().find('p span').html());

            return false;
        });

        $('.translate input[type=submit]').click(function () {
            var text = $(this).prev().prev().val();
            $.ajax({
                url:'<?php echo Yii::app()->createUrl("ajax/SetValue") ?>',
                data:{
                    modelPk:model_id,
                    attribute:'translate',
                    modelName:'Name',
                    value:text
                },
                type:'POST',
                success:function (data) {
                    if (data) {
                        $(this).parent().hide();
                        $(this).parent().parent().find('p span').html(text);
                        $(this).parent().parent().find('p').show();
                    }
                },
                context:$(this)
            });
            return false;
        });

        /*************************** Add saint date*******************************/
        $('#add_calendar input[type=submit]').click(function(){
            $.ajax({
                url: '/club/names/AddSaintDate/',
                data: $('#calendar-form').serialize()+'&model_id='+model_id,
                type: 'POST',
                dataType:'JSON',
                success: function(response) {
                    if (response.status){
                        $('.calendar a.add').before(response.html);
                        $.fancybox.close();
                        RefreshTooltip($('.calendar a.add').prev().find('a'));
                    }
                },
                context: $(this)
            });
            return false;
        });

        /*************************** Add famous person ****************************************/
        $('#famous_add input[type=submit]').click(function(){
            var new_model = $('#famous-form input[name="NameFamous[id]"]').val() == '';
            $.ajax({
                url: '/club/names/AddFamous/',
                data: $('#famous-form').serialize()+'&NameFamous[name_id]='+model_id,
                type: 'POST',
                dataType:'JSON',
                success: function(response) {
                    if (response.status){
                        if (new_model){
                            $('.famous_add.fancy').before(response.html);
                            $.fancybox.close();
                            RefreshTooltip($('.famous_add.fancy').prev().find('a'));
                        }else{
                            var bl = $('.famous_block.id'+$('#famous-form input[name="NameFamous[id]"]').val());
                            bl.find('p').text(response.info);
                            bl.find('img.person-photo').attr('src',response.url);
                            $.fancybox.close();
                        }
                    }
                },
                context: $(this)
            });
            return false;
        });

        $('#small_foto_upload').iframePostForm({
            json: true,
            complete: function(response) {
                if (response.status == '1')
                {
                    $('#link_upload').find('img').remove();
                    $('#small_foto_upload a div.add_photo_ins').hide();
                    $('#link_upload').append('<img src="'+response.image+'" />');
                    $('input[name="NameFamous[photo]"]').val(response.name);
                }
            }
        });

        $('body').delegate('#photo_file_upload', 'change', function() {
            $('form#small_foto_upload').submit();
        });

        $('body').delegate('.famous_block.edit > img', 'click', function(){
            var id = $(this).prev().find('input[name=modelPk]').val();
            $.ajax({
                url: '/club/names/FamousInfo/',
                data: {id:id},
                type: 'POST',
                dataType:'JSON',
                success: function(response) {
                    $('.famous_add.fancy').trigger('click');
                    $('#famous-form input[name="NameFamous[last_name]"]').val(response.last_name);
                    $('#famous-form input[name="NameFamous[link]"]').val(response.link);
                    $('#famous-form input[name="NameFamous[id]"]').val(response.id);
                    $('#famous-form textarea').val(response.description);
                    $('#link_upload').find('img').remove();
                    $('#small_foto_upload a div.add_photo_ins').hide();
                    $('#link_upload').append('<img src="'+response.url+'" />');
                },
                context: $(this)
            });
            return false;
        });

        $('body').delegate('.famous_add.fancy', 'click', function(){
            $('#famous-form input[name="NameFamous[last_name]"]').val('');
            $('#famous-form input[name="NameFamous[link]"]').val('');
            $('#famous-form textarea').val('');
            $('#famous-form input[name="NameFamous[id]"]').val('');
            $('#famous-form input[name="NameFamous[photo]"]').val('');
            $('#link_upload').find('img').remove();
            $('#small_foto_upload a div.add_photo_ins').show();
        });

    });

    function SetGender(value, sender) {
        $.ajax({
            url:'<?php echo Yii::app()->createUrl("ajax/SetValue") ?>',
            data:{
                modelPk: model_id,
                attribute:'gender',
                modelName:'Name',
                value:value
            },
            type:'POST',
            success:function (data) {
                sender.parent().find('a').removeClass('active');
                sender.addClass('active');
            },
            context:sender
        });
    }
</script>