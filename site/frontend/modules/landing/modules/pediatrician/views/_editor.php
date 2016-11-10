<?php
/**
 * @var site\frontend\modules\som\modules\qa\models\QaQuestion $model
 * @var site\frontend\modules\som\modules\qa\models\QaCategory $category
 * @var site\frontend\components\requirejsHelpers\ActiveForm $form
 */
Yii::app()->clientScript->registerAMD('qa-redactor', array('hgwswg' => 'care-wysiwyg'), 'var wysiwyg = new hgwswg($("#question-form textarea").get(0), {
            minHeight       : 200,
            plugins         : ["text", "imageCustom", "smilesModal"],
            toolbarExternal : "#editor-toolbar",
            placeholder     : "Опишите вопрос подробнее",
            callbacks       : {},
            attr            : qText
        }); wysiwyg.run();');

Yii::app()->clientScript->registerAMD('photo-albums-create', array('kow'));
?>

<div class="landing__body landing-question textalign-c login-button" data-bind="follow: {}">
    <div class="landing-question__title font__title-s">Возраст Вашего ребенка?</div>
	<?php
    $form = $this->beginWidget('site\frontend\components\requirejsHelpers\ActiveForm', array(
        'id' => 'question-form',
        'action' => $this->createUrl('/som/qa/default/questionAddForm/'),
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'focus' => array($model, 'title'),
        'htmlOptions' => array(
            'class' => 'add-post__form',
        )
    ));
    ?>
    <?= $form->errorSummary($model) ?>
    <ul class="landing-question__list">
    	<?php
        $classRelashion = [
            3 => 'landing-question__ico-one',
            7 => 'landing-question__ico-two',
            11 => 'landing-question__ico-three',
            15 => 'landing-question__ico-four'
        ];
    	foreach ($category->tags as $tag) {?>
		<li class="landing-question__li">
        	<input type="radio" name="tags" tag_id="<?=$tag->id?>" id="qbn<?=$tag->id?>" class="landing-question__radio">
            <label for="qbn<?=$tag->id?>" class="landing-question__label"><span class="landing-question__ico <?=$classRelashion[$tag->id]?>"></span><span class="landing-question__text"><?=$tag->name?></span></label>
        </li>
    	<?php } ?>
    	<div class="inp-valid_error" id="qTtagsE" data-bind="validationMessage: qThemeE">Выберите возраст ребенка</div>
    </ul>
    <div class="textalign-l">
        <div class="add-post__body-panel inp-valid inp-valid__abs">
			<?=
            $form->textField($model, 'title', array(
                'placeholder' => 'Введите заголовок вопроса',
                'class' => 'itx-gray_big login-button',
                'id' => 'qTtitle'
            ))
            ?>
            <div class="inp-valid_error" id="qTtitleE" data-bind="validationMessage: qTtitle">Это обязательное поле</div>
        </div>
        <div class="add-post__body-panel margin-b10">
        	<div class="answer-form__footer--style clearfix">
                <div class="answer-form__footer-panel">
                	<div id="editor-toolbar"></div>
                </div>
            </div>
            <input type="text" name="site_frontend_modules_som_modules_qa_models_QaQuestion[categoryId]" class="hidden" value="<?=$category->id?>">
            <input type="text" id="category_tag_id" name="site_frontend_modules_som_modules_qa_models_QaQuestion[tag_id]" class="hidden" value="7">
            <div class="add-post__textarea-body inp-valid inp-valid__abs">
				<?=
                $form->textArea($model, 'text', array(
                    'class'         => 'popup-widget_cont_textarea',
                    'id'            => 'qText'
                ))
                ?>
                <div class="inp-valid_error" id="qTextE" data-bind="validationMessage: qText">Это обязательное поле</div>
            </div>
        </div>
      	<div class="textalign-c">
        	<button class="btn btn-forum btn-success login-button" data-bind="follow: {}">Задать вопрос</button>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
<script type="text/javascript">

$(document).ready(function () {
	scope = {
        testTitleTok: function (obj) {
            return function (event) {
                if ($(this).val() == '') {
                    $('#' + this.id + 'E').show();
                    $(this).addClass('error');
                } else {
                    $('#' + this.id + 'E').hide();
                    $(this).removeClass('error');
                }
            }
        },

        validateText: function (textLength) {
        	switch (true)
            {
            	case textLength > 0 && textLength < 30:
                	$("#qText").addClass('error');
                    $("#qTextE").text('Введите более 30 символов').show();
                    return false;
            	case textLength > 999:
                	$("#qText").addClass('error');
                    $("#qTextE").text('Не более 1000 символов').show();
                    return false;
        		default:
        			$("#qText").removeClass('error');
                	$("#qTextE").hide();
                	return true;
            }
        },

        validateTitle: function (textLength) {
        	switch (true)
            {
            	case textLength == 0:
                    $("#qTtitle").addClass('error');
                    $("#qTtitleE").text('Это обязательное поле').show();
                    return false;
            	case textLength < 20:
                	$("#qTtitle").addClass('error');
                    $("#qTtitleE").text('Введите более 20 символов').show();
                    return false;
        		default:
        			$("#qTtitle").removeClass('error');
                	$("#qTtitleE").hide();
                	return true;
            }
        },

        isFormValidTok: function (obj) {
            return function (event) {
                var flagError = false;

                /* @todo replace('[object HTMLTextAreaElement]', "") <- костыль! до перехода плагина redactor на версию 10 */
                var textValue = $.trim($($('#qText').val().replace('[object HTMLTextAreaElement]', "")).text());

                flagError = !scope.validateText(textValue.length) || !scope.validateTitle($.trim($("#qTtitle").val()).length);

                var selected = $("input[type='radio'][name='tags']:checked");
                if (selected.length > 0) {
                    $('#category_tag_id').attr('value', selected.attr('tag_id'));
                    $("#qTtagsE").hide();
                }
                else
                {
                	flagError = true;
                    $("#qTtagsE").show();
                }

                if (!flagError) {
                    $('select.tags.hidden').remove();
                }

                return !flagError;
            }
        }
	};

    $("input[type='radio'][name='tags']").change(function(){
    	$("#qTtagsE").hide();
    });

    $("#qTtitle").change(scope.testTitleTok(this)).keyup(scope.testTitleTok(this));

    $("#question-form").submit(scope.isFormValidTok(this));
});
</script>