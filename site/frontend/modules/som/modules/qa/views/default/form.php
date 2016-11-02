<?php
use site\frontend\modules\som\modules\qa\models\QaCategory;
/**
 * @var site\frontend\modules\som\modules\qa\models\QaQuestion $model
 * @var site\frontend\modules\som\modules\qa\models\QaCategory[] $categories
 * @var site\frontend\components\requirejsHelpers\ActiveForm $form
 */
Yii::app()->clientScript->registerAMD('qa-redactor', array('hgwswg' => 'care-wysiwyg'), 'var wysiwyg = new hgwswg($(".ask-widget textarea").get(0), {
            minHeight: 88,
            buttons: ["bold", "italic", "underline"],
            plugins: ["imageCustom", "smilesModal"],
            callbacks: {
                init: [
                ]
            }
        }); wysiwyg.run();');
#Yii::app()->clientScript->registerAMD('knockout');
Yii::app()->clientScript->registerAMD('photo-albums-create', array('kow'));
?>

<div class="popup-widget ask-widget">
    <div class="popup-widget_heading">
        <div class="popup-widget_heading_icon"></div>
        <div class="popup-widget_heading_text">Задать вопрос</div>
        <a href="<?= $this->createUrl('/som/qa/default/index') ?>" class="popup-widget_heading_close-btn"></a>
    </div>
    <div class="popup-widget_wrap">
        <?php
        $form = $this->beginWidget('site\frontend\components\requirejsHelpers\ActiveForm', array(
            'id' => 'question-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'focus' => array($model, 'title'),
            'htmlOptions' => array(
                'class' => 'popup-widget_cont'
            )
        ));
        ?>
        <?= $form->errorSummary($model) ?>
        <form class="popup-widget_cont">
            <div class="popup-widget_cont_tx-text"></div>
            <div class="inp-valid inp-valid__abs"  >
                <?=
                $form->textField($model, 'title', array(
                    'placeholder' => 'Введите заголовок вопроса',
                    'class' => 'popup-widget_cont_input-text',
                    'data-bind' => "value: qTtitle",
                    'id' => 'qTtitle'
                ))
                ?>
                <div class="inp-valid_error" id="qTtitleE" data-bind="validationMessage: qTtitle">Это обязательное поле</div>
            </div>
            <?php if ($model->scenario != 'consultation'): ?>
                <div class="inp-valid inp-valid__abs margin-b15">
                    <div class="popup-widget_cont_list">
                        <?=
                            $form->dropDownList($model, 'categoryId', CHtml::listData($categories, 'id', 'title'), array(
                                'class' => 'select-cus select-cus__search-off select-cus__gray categories',
                                'empty' => 'Выберите тему',
                            ));
                        ?>
                    </div>
                    <div class="inp-valid_error" id="qThemeE" data-bind="validationMessage: qThemeE">Это обязательное поле</div>
                </div>

                <div class="inp-valid inp-valid__abs">
                    <div class="popup-widget_cont_list">
                        <?php
                        foreach ($categories as $category) {
                            if (count($category->tags) > 0) {
                                echo $form->dropDownList($model, "tag_id", $category->getTagTitles(), array(
                                    'class' => 'select-cus select-cus__search-off select-cus__gray tags ' . ($category->id == $model->categoryId ? ' ' : 'hidden'),
                                    'empty' => 'Выберите возраст ребенка',
                                    'id' => "tags{$category->id}",
                                ));
                            }
                        }
                        ?>
                    </div>
                    <div class="inp-valid_error" id="qTtagsE" data-bind="validationMessage: qThemeE">Выберите возраст ребенка</div>
                </div>
            <?php endif; ?>
            <div class="redactor-control">
                <div class="redactor-control_toolbar clearfix"></div>
                <div class="redactor-control_hold">
                    <div class="inp-valid inp-valid__abs"  >
                        <?=
                        $form->textArea($model, 'text', array(
                            'placeholder' => 'Введите сам вопрос',
                            'class' => 'popup-widget_cont_textarea',
                            'data-bind' => "value: qText",
                            'id' => 'qText'
                        ))
                        ?>
                        <div class="inp-valid_error" id="qTextE" data-bind="validationMessage: qText">Это обязательное поле</div>
                    </div>
                </div>
            </div>
            <?=
            $form->checkBox($model, 'sendNotifications', array(
                'class' => 'popup-widget_cont_checkbox',
            ))
            ?>
            <?= $form->label($model, 'sendNotifications') ?>
            <div class="popup-widget_cont_buttons">
                <a href="<?= $this->createUrl('/som/qa/default/index') ?>" class="btn btn-secondary btn-xm">Отмена</a>
                <button class="btn btn-success btn-xm" data-bind='click: qSubmit'><?= ($model->isNewRecord) ? 'Опубликовать' : 'Редактировать' ?></button>
            </div>
            <?php $this->endWidget(); ?>
    </div>
</div>



<script type="text/javascript">

    function QuestForValid() {

        this.titleValid = false;
        pediatorCategoryId = <?=QaCategory::PEDIATRICIAN_ID?>;


        this.submitDisable = function (flag) {
            return false;
            tt = $($("#question-form").find(".btn-success")[0]);
            if (flag) {
                tt.attr('disabled', 'disabled').addClass('disabled');
            } else {
                tt.removeAttr('disabled').removeClass('disabled');
            }

        }

        this.testTitleTok = function (obj) {
            return function (event) {
                if ($(this).val() == '') {
                    $('#' + this.id + 'E').show();
                    $(this).addClass('error');
                    obj.titleValid = false;
                    obj.submitDisable(true);
                    //console.log(this.id + " error");
                } else {
                    $('#' + this.id + 'E').hide();
                    $(this).removeClass('error');
                    obj.titleValid = true;
                    obj.submitDisable(false);
                    //console.log(this.id + " ok");
                }
            }
        }

        this.testThemTok = function (obj) {
            return function (event) {
                if ($(this).val() == '') {
                    $('#' + this.id + 'E').show();
                    $(this).addClass('error');
                    obj.titleValid = false;
                } else {

                    $(this).removeClass('error');
                    obj.titleValid = true;
                }
            }
        }

        this.testTextTok = function (obj) {
            return function (event) {
                if ($(this).val() == '') {
                    $('#' + this.id + 'E').show();
                    $(this).addClass('error');
                    obj.titleValid = false;
                } else {

                    $(this).removeClass('error');
                    obj.titleValid = true;
                }
            }
        }

        this.isFormValidTok = function (obj) {
            return function (event) {
                var flagError = false;

                var textValue = $.trim($($('.redactor_box textarea').val()).text());

                if (textValue != '' && textValue.length < 30)
                {
                	flagError = true;

                    $("#qText").addClass('error');
                    $("#qTextE").text('Введите более 30 символов').show();
                }
                else
                {
                	$("#qText").removeClass('error');
                    $("#qTextE").hide();
                }

                /* if (textValue == '') {
                    flagError = true;
                    $("#qText").addClass('error');
                    $("#qTextE").show();
                } else {
                    $("#qText").removeClass('error');
                    $("#qTextE").hide();
                } */

                if ($.trim($("#qTtitle").val()) == '') {
                    flagError = true;

                    $("#qTtitle").addClass('error');
                    $("#qTtitleE").text('Это обязательное поле').show();
                } else {
                    if ($.trim($("#qTtitle").val()).length < 20)
                    {
                    	flagError = true;

                    	$("#qTtitle").addClass('error');
                        $("#qTtitleE").text('Введите более 20 символов').show();
                    }
                    else {
                        $("#qTtitle").removeClass('error');
                        $("#qTtitleE").hide();
                    }
                }

                var selectTags = $('select.tags');
                if (selectTags.val() == '' && $('select.categories').val() == pediatorCategoryId) {
                    flagError = true;

                    $("#tags" + pediatorCategoryId).addClass('error');
                    $("#qTtagsE").show();
                } else {
                    $("#tags" + this.pediatorCategoryId).removeClass('error');
                    $("#qTtagsE").hide();
                }

                /* if ($("#site_frontend_modules_som_modules_qa_models_QaQuestion_categoryId").val() == '') {
                    flagError = true;
                    $("#site_frontend_modules_som_modules_qa_models_QaQuestion_categoryId").addClass('error');
                    $("#qThemeE").show();
                } else {
                    $("#site_frontend_modules_som_modules_qa_models_QaQuestion_categoryId").removeClass('error');
                    $("#qThemeE").hide();
                } */

                // console.log('form status ' + flagError);

                setTimeout(obj.testDropBoxTok(obj), 100);

                if (!flagError) {
                    $('select.tags.hidden').remove();
                }

                return !flagError;
            }
        }

        $("#qTtitle").change(this.testTitleTok(this)).keyup(this.testTitleTok(this));

        setTimeout(function () {
            $('.redactor_popup-widget_cont_textarea').on('keyup', function (event) {
                if ($("#qText").val() == '') {
                    flagError = true;
                    $("#qText").addClass('error');
                    $("#qTextE").show();
                } else {
                    $("#qText").removeClass('error');
                    $("#qTextE").hide();
                }
            });
            $('#s2id_site_frontend_modules_som_modules_qa_models_QaQuestion_categoryId').on()
        }, 3000);

        this.testDropBoxTok = function (obj) {
            return function() {};
           /*  return function () {
                if ($("#site_frontend_modules_som_modules_qa_models_QaQuestion_categoryId").val() == '') {
                    flagError = true;
                    $("#site_frontend_modules_som_modules_qa_models_QaQuestion_categoryId").addClass('error');
                    $("#qThemeE").show();
                } else {
                    $("#site_frontend_modules_som_modules_qa_models_QaQuestion_categoryId").removeClass('error');
                    $("#qThemeE").hide();
                }
                setTimeout(obj.testDropBoxTok(obj), 100);
            } */
        }

        $("#question-form").submit(this.isFormValidTok(this));

        $('.categories').change(function() {
            var categoryId = $(this).val();
            $('.tags').each(function() {
                if (!$(this).hasClass('hidden')) {
                    $(this).addClass('hidden');
                }
            });

            $('#qTchildAge').addClass('hidden');
            if (categoryId == pediatorCategoryId)
            {
				$('#qTchildAge').removeClass('hidden');
            }

            $('#s2id_tags' + categoryId).removeClass('hidden');
            $('#tags' + categoryId).removeClass('hidden');
            $("#qTtagsE").hide();
        });
    }

    $(document).ready(function () {
        var qv = new QuestForValid();
    }
    )
</script>

