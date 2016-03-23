<?php
/**
 * @var site\frontend\modules\som\modules\qa\models\QaQuestion $model
 * @var site\frontend\components\requirejsHelpers\ActiveForm $form
 */
?>

<div class="popup-widget ask-widget">
    <div class="popup-widget_heading">
        <div class="popup-widget_heading_icon"></div>
        <div class="popup-widget_heading_text">Задать вопрос</div>
        <a href="<?=$this->createUrl('/som/qa/default/index')?>" class="popup-widget_heading_close-btn"></a>
    </div>
    <div class="popup-widget_wrap">
        <?php $form = $this->beginWidget('site\frontend\components\requirejsHelpers\ActiveForm', array(
            'id' => 'question-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'focus' => array($model, 'title'),
            'htmlOptions' => array(
                'class' => 'popup-widget_cont',
            ),
        )); ?>
        <?=$form->errorSummary($model)?>
        <form class="popup-widget_cont">
            <div class="popup-widget_cont_tx-text"></div>
            <?=$form->textField($model, 'title', array(
                'placeholder' => 'Введите заголовок вопроса',
                'class' => 'popup-widget_cont_input-text',
            ))?>
            <?php if ($model->scenario != 'consultation'): ?>
            <div class="popup-widget_cont_list">
                <?=$form->dropDownList($model, 'categoryId', CHtml::listData(\site\frontend\modules\som\modules\qa\models\QaCategory::model()->findAll(), 'id', 'title'), array(
                    'class' => 'select-cus select-cus__search-off select-cus__gray',
                    'empty' => 'Выберите тему',
                ))?>
            </div>
            <?php endif; ?>
            <?=$form->textArea($model, 'text', array(
                'placeholder' => 'Введите сам вопрос',
                'class' => 'popup-widget_cont_textarea',
            ))?>
            <?=$form->checkBox($model, 'sendNotifications', array(
                'class' => 'popup-widget_cont_checkbox',
            ))?>
            <?=$form->label($model, 'sendNotifications')?>
            <div class="popup-widget_cont_buttons">
                <a href="<?=$this->createUrl('/som/qa/default/index')?>" class="btn btn-secondary btn-xm">Отмена</a>
                <button class="btn btn-success btn-xm"><?=($model->isNewRecord) ? 'Опубликовать' : 'Редактировать'?></button>
            </div>
            <?php $this->endWidget(); ?>
        <div class="popup-widget_sidebar">
            <div class="popup-widget_sidebar_advice-smile"></div>
            <div class="popup-widget_sidebar_advice-heading">Совет</div>
            <ol class="popup-widget_sidebar_ol">
                <li class="popup-widget_sidebar_li">Старайтесь формулировать вопрос максимально четко и понятно.</li>
                <li class="popup-widget_sidebar_li">Чем понятнее будет Ваш вопрос, тем более конкретные ответы вы получите.</li>
            </ol>
        </div>
    </div>
</div>

<?php if (false): ?>
<?php $form = $this->beginWidget('site\frontend\components\requirejsHelpers\ActiveForm', array(
    'id'=>'user-form',
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
    'focus'=>array($model,'firstName'),
)); ?>

<div class="row">
    <?php echo $form->textField($model, 'title'); ?>
    <?php echo $form->error($model, 'title'); ?>
</div>

<div class="row">
    <?php echo $form->textArea($model, 'text'); ?>
    <?php echo $form->error($model, 'text'); ?>
</div>

<div class="row">
    <?php echo $form->dropDownList($model, 'categoryId', CHtml::listData(\site\frontend\modules\som\modules\qa\models\QaCategory::model()->simple()->findAll(), 'id', 'title')); ?>
    <?php echo $form->error($model, 'categoryId'); ?>
</div>

<div class="row">
    <?php echo $form->checkBox($model, 'sendNotifications'); ?>
    <?php echo $form->error($model, 'sendNotifications'); ?>
</div>

<input type="submit">


<?php endif; ?>