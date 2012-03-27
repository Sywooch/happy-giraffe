<?php
    $cs = Yii::app()->clientScript;
    $url = $this->createUrl('ajax/video');
    $js = "
        $('#preview').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: " . CJSON::encode($url) . ",
                type: 'POST',
                data: {
                    url: $('#CommunityVideo_link').val(),
                },
                success: function(response) {
                    $('div.test-video div.img').html(response);
                },
            });
        });
        $('.close').click(function () {
            $('.validate .right-v').hide();
            $('#preview_container').html('');
        });
    ";
    $css = "
    .validate .right-v {
        display: none;
    }";
    $cs
        ->registerScript('add_video', $js)->registerCss('add_video', $css);
?>

<div class="add-nav default-nav clearfix">
    <div class="content-title">Добавить в блог:</div>
    <?php
        $this->widget('zii.widgets.CMenu', array(
            'items'=>array(
                array(
                    'label' => 'Запись',
                    'url' => array('/blog/add', 'content_type_slug' => 'post'),
                    'active' => $content_type_slug == 'post',
                ),
                array(
                    'label' => 'Видео',
                    'url' => array('/blog/add', 'content_type_slug' => 'video'),
                    'active' => $content_type_slug == 'video',
                ),
            ),
        ));
    ?>
</div>

<div class="main">
    <div class="main-in">

        <?php $form = $this->beginWidget('CActiveForm'); ?>
            <div class="form row-form clearfix">

                <?php if ($model->type_id == 1): ?>
                    <div class="row clearfix">
                        <div class="row-title">Заголовок:</div>
                        <div class="row-elements">
                            <?php echo $form->textField($model, 'name', array('class' => 'w-500')); ?>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="row-title">Текст:</div>
                        <div class="row-elements">
                            <?php
                                $this->widget('ext.ckeditor.CKEditorWidget', array(
                                    'model' => $slave_model,
                                    'attribute' => 'text',
                                    'config' => array(
                                        'toolbar' => 'Chat',
                                        'width' => 410,
                                        'height' => 100,
                                    ),
                                ));
                            ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($model->type_id == 2): ?>
                    <div class="row clearfix">
                        <div class="row-title">Заголовок:</div>
                        <div class="row-elements">
                            <?php echo $form->textField($model, 'name', array('class' => 'w-400')); ?>
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
                            Проверить ролик? <a href="" class="btn btn-green-small" id="preview"><span><span>ДА</span></span></a>
                            <p class="small w-200">В случае, если ссылка добавилась некорректно, вы сможете изменить ее до добавления</p>
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
                                        'toolbar' => 'Chat',
                                        'width' => 410,
                                        'height' => 100,
                                    ),
                                ));
                            ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="row clearfix">
                    <div class="row-title">Рубрика:</div>
                    <div class="row-elements">
                        <div class="select-box">
                            <?php echo $form->dropDownList($model, 'rubric_id', CHtml::listData($rubrics, 'id', 'name'), array('class' => 'chzn w-200')); ?>
                        </div>
                    </div>
                </div>

                <div class="row row-buttons">
                    <button class="btn btn-gray-medium"><span><span>Отменить</span></span></button>
                    <!--<button class="btn btn-yellow-medium"><span><span>Предпросмотр</span></span></button>-->
                    <button class="btn btn-green-medium"><span><span><?php echo ($model->isNewRecord) ? 'Добавить' : 'Сохранить' ; ?></span></span></button>
                </div>

            </div>
        <?php $this->endWidget(); ?>

    </div>
</div>

<div class="side-left">

    <center><img src="/images/img_blog_add.png" /></center>

</div>