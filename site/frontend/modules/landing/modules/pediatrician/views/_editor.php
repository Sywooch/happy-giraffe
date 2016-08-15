<?php
/**
 * @var site\frontend\modules\som\modules\qa\models\QaQuestion $model
 * @var site\frontend\modules\som\modules\qa\models\QaCategory[] $categories
 * @var site\frontend\components\requirejsHelpers\ActiveForm $form
 */
Yii::app()->clientScript->registerAMD('qa-redactor', array('hgwswg' => 'care-wysiwyg'), 'var wysiwyg = new hgwswg($("#question-form textarea").get(0), {
            minHeight: 88,
            buttons: ["bold", "italic", "underline"],
            plugins: ["imageCustom"],
            callbacks: {
                init: [
                ]
            }
        }); wysiwyg.run();');
Yii::app()->clientScript->registerAMD('photo-albums-create', array('kow'));
?>

<div class="landing__body landing-question textalign-c">
    <div class="landing-question__title font__title-s">Возраст Вашего ребенка?</div>
    <ul class="landing-question__list">
        <li class="landing-question__li">
            <input type="radio" id="qbn1" checked class="landing-question__radio">
            <label for="qbn1" class="landing-question__label"><span class="landing-question__ico landing-question__ico-one"></span><span class="landing-question__text">0-1</span></label>
        </li>
        <li class="landing-question__li">
            <input type="radio" id="qbn2" class="landing-question__radio">
            <label for="qbn2" class="landing-question__label landing-question__label-two"><span class="landing-question__ico landing-question__ico-two"></span><span class="landing-question__text">1-3</span></label>
        </li>
        <li class="landing-question__li">
            <input type="radio" id="qbn3" class="landing-question__radio">
            <label for="qbn3" class="landing-question__label landing-question__label-three"><span class="landing-question__ico landing-question__ico-three"></span><span class="landing-question__text">3-6</span></label>
        </li>
        <li class="landing-question__li">
            <input type="radio" id="qbn4" class="landing-question__radio">
            <label for="qbn4" class="landing-question__label landing-question__label-four"><span class="landing-question__ico landing-question__ico-four"></span><span class="landing-question__text">6-12</span></label>
        </li>
    </ul>
    <div class="textalign-l">
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
<!--         <form class="add-post__form"> -->
        <div class="add-post__body-panel">
<!--         	<input type="text" placeholder="Введите заголовок вопроса" class="add-post__input"><span class="add-post__text">150</span> -->
			<?=
            $form->textField($model, 'title', array(
                'placeholder' => 'Введите заголовок вопроса',
                'class' => 'popup-widget_cont_input-text',
                'data-bind' => "value: qTtitle",
                'id' => 'qTtitle'
            ))
            ?>
        </div>
        <div class="add-post__body-panel margin-b10">
            <div class="add-post__textarea-header">
            	<div id="add-post-toolbar"></div>
            </div>
            <div class="redactor-control_toolbar"></div>
            <div class="add-post__textarea-body">
<!--             	<textarea id="add-comment-wysiwyg" class="wysiwyg-redactor-v"></textarea> -->
				<?=
                $form->textArea($model, 'text', array(
                    'placeholder' => 'Введите сам вопрос',
                    'class' => 'popup-widget_cont_textarea',
                    'data-bind' => "value: qText",
                    'id' => 'qText'
                ))
                ?>
            </div>
        </div>
        <div class="textalign-c">
<!--         	<a href="#" class="btn btn-forum btn-success" data-bind='click: qSubmit'>Задать вопрос</a> -->
        	<button class="btn btn-forum btn-success" data-bind='click: qSubmit'>Задать вопрос</button>
        </div>
        <?php $this->endWidget(); ?>
<!--         </form> -->
    </div>
</div>
<script type="text/javascript">

    function QuestForValid() {

        this.titleValid = false

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
                if (selectTags.val() == '' && $('select.categories').val() == 124) {
                    flagError = true;

                    $("#tags124").addClass('error');
                    $("#qTtagsE").show();
                } else {
                    $("#tags124").removeClass('error');
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
            if (categoryId == 124)
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