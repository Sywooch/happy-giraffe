<?php
/* @var CActiveForm $form
 * @var CommunityContent $model
 */
$cs = Yii::app()->clientScript;
if (!isset($redirectUrl))
    $redirectUrl = Yii::app()->request->urlReferrer;


$js = "
        $('#preview').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: '/ajax/video/',
                type: 'POST',
                dataType:'JSON',
                data: {
                    url: $('#CommunityVideo_link').val(),
                },
                success: function(response) {
                    if (response.status){
                        $('div.test-video div.img').html(response.html);
                        $('#CommunityVideo_link').parents('.row').removeClass('error');
                    }
                    else
                        if (!$('#CommunityVideo_link').parents('.row').hasClass('error'))
                            $('#CommunityVideo_link').parents('.row').addClass('error');
                },
            });
        });
        ";

$cs
    ->registerScript('add_video', $js)
    ->registerScriptFile(Yii::app()->baseUrl . '/javascripts/jquery.tooltip.pack.js');
?>

<div class="add-nav default-nav clearfix">
    <div class="content-title">Добавить в новости:</div>
    <?php
    $this->widget('zii.widgets.CMenu', array(
        'items' => array(
            array(
                'label' => 'Запись',
                'url' => $this->getUrl(array('content_type_slug' => 'post'), 'community/add'),
                'active' => $content_type_slug == 'post',
            ),
        ),
    ));
    ?>
</div>

<div class="main">
    <div class="main-in">

        <?php echo CHtml::errorSummary(array($model, $slave_model)); ?>

        <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'community-form',
        'enableClientValidation' => false,
        'enableAjaxValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => false,
            'beforeValidate'=>'js:function(form){
                        $(".row-elements textarea").val(CKEDITOR.instances["CommunityPost[text]"].getData());
                        return true;
                    }'
        ),
    )); ?>
        <?php echo $form->errorSummary(array($model, $slave_model)); ?>
        <div class="hidden" style="display: none;">
            <?php
            echo $form->error($model, 'title');
            echo $form->error($slave_model, 'text');
            echo $form->error($model, 'rubric_id');
            ?>
        </div>
        <div class="form row-form clearfix">

            <?php if (Yii::app()->user->checkAccess('editor')): ?>
            <div class="row clearfix">
                <div class="row-title"><?php echo $form->label($model, 'by_happy_giraffe'); ?>:</div>
                <div class="row-elements">
                    <?php echo $form->checkBox($model, 'by_happy_giraffe'); ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($model->type_id == 1): ?>
            <div class="row clearfix">
                <div class="row-title"><?php echo $form->label($model, 'title') ?>:</div>
                <div class="row-elements">
                    <?php echo $form->textField($model, 'title', array('class' => 'w-500')); ?>
                </div>
            </div>

            <div class="row clearfix">
                <div class="row-title"><?php echo $form->label($slave_model, 'text') ?>:</div>
                <div class="row-elements">
                    <?php
                    $this->widget('ext.ckeditor.CKEditorWidget', array(
                        'model' => $slave_model,
                        'attribute' => 'text',
                    ));
                    ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($model->type_id == 2): ?>
            <div class="row clearfix">
                <div class="row-title"><?php echo $form->label($model, 'title') ?>:</div>
                <div class="row-elements">
                    <?php echo $form->textField($model, 'title', array('class' => 'w-400')); ?>
                </div>
            </div>

            <div class="row clearfix">
                <div class="row-title">Ссылка на видео:</div>
                <div class="row-elements">
                    <?php echo $form->textField($slave_model, 'link', array('class' => 'w-400')); ?>
                    <div class="row-note">
                        <div class="tale"></div>
                        <p><span class="mdash">&mdash;</span>Вы можете разместить видео с YouTube и RuTube</p>
                    </div>

                </div>
            </div>

            <div class="row clearfix test-video w-400">
                <div class="row-title">
                    <div class="img">

                    </div>
                    Проверить ролик? <a href="" class="btn btn-green-small"
                                        id="preview"><span><span>ДА</span></span></a>

                    <p class="small w-200">В случае, если ссылка добавилась некорректно, вы сможете изменить ее до
                        добавления</p>
                </div>
            </div>

            <div class="row clearfix">
                <div class="row-title">Комментарий к видео:</div>
                <div class="row-elements">
                    <?php
                    $this->widget('ext.ckeditor.CKEditorWidget', array(
                        'model' => $slave_model,
                        'attribute' => 'text',
                        'config' => array(
                            'toolbar' => 'Simple',
                        ),
                    ));
                    ?>
                </div>
            </div>
            <?php endif; ?>

            <div class="row clearfix">
                <div class="row-title">Где разместить:</div>
                <div class="row-elements">
                    <div class="select-box">
                        <span class="subtitle">Рубрика</span>
                        <?php echo $form->dropDownList($model, 'rubric_id', CHtml::listData($rubrics, 'id', 'title'), array('prompt' => 'Выберите рубрику', 'class' => 'chzn w-200')); ?>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="row-title">Жанр:</div>
                <div class="row-elements">
                    <div class="select-box">
                        <?php echo $form->dropDownList($slave_model, 'genre', CommunityPost::$genres, array('prompt' => 'Выберите жанр', 'class' => 'chzn w-200')); ?>
                    </div>
                </div>
            </div>

            <div class="row row-buttons">
                <button class="btn btn-gray-medium"<?php if ($model->isNewRecord) echo ' onclick="document.location.href =\''. $redirectUrl .'\';"'; ?>><span><span>Отменить</span></span></button>
                <!--<button class="btn btn-yellow-medium"><span><span>Предпросмотр</span></span></button>-->
                <button class="btn btn-green-medium">
                    <span><span><?php echo ($model->isNewRecord) ? 'Добавить' : 'Сохранить'; ?></span></span></button>
            </div>

            <?= CHtml::hiddenField('redirectUrl', $redirectUrl) ?>

        </div>
        <?php $this->endWidget(); ?>

    </div>
</div>

<div class="side-left">
</div>

<div style="display: none;">
    <div class="upload-btn">
        <?php
        $fileAttach = $this->beginWidget('application.widgets.fileAttach.FileAttachWidget', array(
            'model' => $slave_model,
        ));
        $fileAttach->button();
        $this->endWidget();
        ?>
    </div>
</div>

<script type="text/javascript">
    var cke_instance = '<?php echo get_class($slave_model); ?>[text]';
</script>

<script id="photo_item" type="text/x-jquery-tmpl">
    <li>
        <input type="hidden" name="CommunityContentGalleryItem[${id}][description]" value="${description}" />
        <input type="hidden" name="CommunityContentGalleryItem[${id}][photo_id]" value="${id}" />
        <div class="img">
            <img src="${src}" />
            <div class="actions">
                <a href="javascript:;" class="remove tooltip" title="Удалить галерею" onclick="$(this).parents('li:eq(0)').remove();"></a>
            </div>
        </div>
    </li>
</script>