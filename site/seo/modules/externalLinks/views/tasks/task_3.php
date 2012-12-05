<?php
/** @var $task ELTask
 */
Yii::app()->clientScript->registerScript('init_site_id','ExtLinks.site_id = '.$task->site_id);
?>
<div class="tasks-list">

    <ul>
        <li>
            <div class="task-title">Поставьте ссылку на <?=$task->site->getTitle() ?>е
                <a target="_blank" href="<?=$task->site->getUrl()?>">
                    <span class="hl"><?=$task->site->getUrl()?></span>
                </a>
            </div>
        </li>
        <?php if (empty($task->site->account)): ?>
        <li>
            <div class="task-title">Внесите данные регистрации</div>
            <?php $this->renderPartial('/forums/_reg_data'); ?>
        </li>
        <?php else: ?>
        <li>
            <a href="javascript:;" class="pseudo" onclick="$(this).next().toggle()">Показать данные</a>

            <?php $this->renderPartial('/forums/_reg_data', array('show'=>false, 'account'=>$task->site->account)); ?>
        </li>
        <?php endif ?>
    </ul>

</div>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'link-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'action' => '#',
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => false,
        'validateOnType' => false,
        'validationUrl' => $this->createUrl('addLink'),
        'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    window.location.reload();
                                return false;
                              }",
    )));

    $model = new ELLink();
    $model->site_id = $task->site_id;
    echo $form->hiddenField($model, 'site_id');
    echo CHtml::hiddenField('id', $task->id);
    ?>

    <div class="row">
        <div class="row-title">
            <span>Внешний сайт</span> - адрес страницы
            <small>(на которой проставлена ссылка)</small>
        </div>
        <div class="row-elements">
            <?=$form->textField($model, 'url', array('placeholder'=>'Введите URL')) ?>
            <?=$form->error($model, 'url') ?>
        </div>
    </div>

    <div class="row">
        <div class="row-title">
            <span>Наш сайт</span> - адрес статьи / сервиса
            <small>(которые мы продвигаем)</small>
        </div>
        <div class="row-elements">
            <?=$form->textField($model, 'our_link', array('placeholder'=>'Введите URL')) ?>
            <?=$form->error($model, 'our_link') ?>
        </div>
    </div>

    <div class="row anchors">
        <div class="row-title">
            <span>Анкор</span>
        </div>
        <div class="row-elements">
            <input name="ELLink[anchors][]" type="text">
            <a href="javascript:;" class="icon-btn-add" onclick="$(this).hide().next().show()"></a>
            <input name="ELLink[anchors][]" type="text" style="display: none;">
        </div>
    </div>

    <div class="row row-btn-done">

        <button class="btn-g">Выполнено</button>

        <?php $this->renderPartial('_problem',compact('task')); ?>

    </div>

    <?php $this->endWidget(); ?>

</div>
