<?php
    $cs = Yii::app()->clientScript;

    $js = "
        $('#CommunityRubric_name').keyup(function() {
            if ($('#BlogContent_rubric_id').val() != '' && $(this).val() != '') {
                $('#BlogContent_rubric_id').val('');
                $('#BlogContent_rubric_id').trigger('liszt:updated');
            }
        });

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

    $cs->registerScript('chnage_rubric_title', $js);

if (!isset($redirectUrl))
    $redirectUrl = Yii::app()->request->urlReferrer;
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

        <?php echo CHtml::errorSummary(array($model, $slave_model)); ?>

        <?php $form = $this->beginWidget('CActiveForm'); ?>
            <div class="form row-form clearfix">

                <?php if ($model->type_id == 1): ?>
                    <div class="row clearfix">
                        <div class="row-title">Заголовок:</div>
                        <div class="row-elements">
                            <?php echo $form->textField($model, 'title', array('class' => 'w-500')); ?>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="row-title">Текст:</div>
                        <div class="row-elements">
                            <?php
                            $this->widget('ImperaviRedactorWidget', array(
                                'model' => $slave_model,
                                'attribute' => 'text',
                                'plugins' => array(
                                    'widget' => array(
                                        'js' => array('widget.js'),
                                    ),
                                    'smiles' => array(
                                        'js' => array('smiles.js'),
                                        'css' => array('smiles.css'),
                                    ),
                                    'cuttable' => array(
                                        'js' => array('cuttable.js'),
                                        'css' => array('cuttable.css'),
                                    ),
                                    'albumPhoto' => array(
                                        'js' => array('albumPhoto.js'),
                                        'css' => array('albumPhoto.css'),
                                    ),
                                ),
                            ));
                            ?>
                            <?=$form->error($slave_model, 'text')?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($model->type_id == 2): ?>
                    <div class="row clearfix">
                        <div class="row-title">Заголовок:</div>
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
                                        'toolbar' => 'Simple',
                                    ),
                                ));
                            ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="row clearfix select-box">
                    <?php if ($model->isNewRecord): ?>
                        <table>
                            <tr>
                                <td align="right">
                                    <div class="row-title">Выберите рубрику</div>
                                    <div class="row-elements">
                                        <?php echo $form->dropDownList($model, 'rubric_id', CHtml::listData($rubrics, 'id', 'title'), array('prompt' => 'Выберите рубрику', 'class' => 'chzn w-200')); ?>
                                    </div>
                                </td>
                                <td width="120" align="center">
                                    <div class="row-title">или</div>
                                </td>
                                <td>
                                    <div class="row-title">Создайте новую</div>
                                    <div class="row-elements">
                                        <?php echo $form->textField($rubric_model, 'title', array('class' => 'new-rubric')); ?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    <?php else: ?>
                        <div class="row clearfix">
                            <div class="row-title">Рубрика:</div>
                            <div class="row-elements">
                                <div class="select-box">
                                    <?php echo $form->dropDownList($model, 'rubric_id', CHtml::listData($rubrics, 'id', 'title'), array('class' => 'chzn w-200')); ?>
                                </div>
                            </div>
                            <a class="add"><i class="icon"></i></a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="row row-buttons">
                    <button class="btn btn-gray-medium"<?php if ($model->isNewRecord) echo ' onclick="document.location.href =\''. $redirectUrl .'\';return false"'; ?>><span><span>Отменить</span></span></button>
                    <!--<button class="btn btn-yellow-medium"><span><span>Предпросмотр</span></span></button>-->
                    <button class="btn btn-green-medium"><span><span><?php echo ($model->isNewRecord) ? 'Добавить' : 'Сохранить' ; ?></span></span></button>
                </div>

            </div>
        <?= CHtml::hiddenField('redirectUrl', $redirectUrl) ?>
        <?php $this->endWidget(); ?>

    </div>
</div>

<div class="side-left">

    <center><img src="/images/img_blog_add.png" /></center>

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