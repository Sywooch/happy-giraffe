<?php
/** @var $task ELTask
 */
?>
<div class="tasks-list">

    <ul>
        <li>
            <div class="task-title">Поставьте ссылку на форуме
                <a target="_blank" href="http://<?=$task->site->url?>">
                    <span class="hl">http://<?=$task->site->url?></span>
                </a>
            </div>
        </li>
        <li>
            <a href="javascript:;" class="pseudo" onclick="$(this).next().toggle()">Показать данные</a>

            <div class="reg-form" style="display: none;">
                <label>Логин:</label><input type="text" value="<?=$task->site->account->login ?>"><br>
                <label>Пароль:</label><input type="text" value="<?=$task->site->account->password ?>"><br>
            </div>
        </li>
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
        <div class="problem">
            <a href="javascript:void(0);" class="pseudo" onclick="$(this).next().toggle()">Возникла проблема</a>

            <div class="problem-in" style="display: none;">
                <a href="javascript:;" class="btn-g small" onclick="ExtLinks.Problem(<?=$task->id ?>)">Ok</a>
                <a href="javascript:;" class="radio" onclick="ExtLinks.checkProblem(this, 1)">Аккаунт заблокировали</a>
                <a href="javascript:;" class="radio" onclick="ExtLinks.checkProblem(this, 2)">Сайт недоступен</a>
            </div>
            <div class="problem-in" style="display: none;">
                <a href="javascript:;" class="btn-g small" onclick="ExtLinks.Problem(<?=$task->id ?>)">Ok</a>
            </div>
        </div>

    </div>

    <?php $this->endWidget(); ?>

</div>
