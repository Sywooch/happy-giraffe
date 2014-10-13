<!-- css для продакшена member-user.css  -->
<div class="b-main_cont b-main_cont__wide">
<div class="postAdd margin-t40">
<div class="postAdd_hold">

<?php

/**
 * @var site\frontend\modules\editorialDepartment\models\Content $model
 * @var CActiveForm $form
 */
use \site\frontend\modules\editorialDepartment\models as departmentModels;
use \site\frontend\modules\editorialDepartment\components as departmentComponents;

$form = $this->beginWidget('site\frontend\components\requirejsHelpers\ActiveForm', array(
    'id' => 'blog-form',
    //'action' => $action,
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
    'clientOptions' => array(
        'validateOnSubmit' => false,
        'validateOnType' => false,
    )));
$forum = Community::model()->with('club')->findByPk($model->forumId);
$users = departmentComponents\UsersControl::getUsersList();
$users = array_combine($users, $users);
$form->hiddenField($model, 'clubId');
?>
<?=$form->errorSummary($model) ?>
<?=$form->textarea($model, 'markDownPreview',  array('id' => 'markDownPreview', 'class' => 'display-n')) ?>
<?=$form->textarea($model, 'htmlTextPreview',  array('id' => 'htmlTextPreview', 'class' => 'display-n')) ?>
<?=$form->textarea($model, 'markDown',  array('id' => 'markDown', 'class' => 'display-n')) ?>
<?=$form->textarea($model, 'htmlText',  array('id' => 'htmlText', 'class' => 'display-n')) ?>
<h1 class="heading-xl margin-b30">Добавление статьи</h1>
<div class="postAdd_row">
    <div class="postAdd_count">1</div>
    <div class="b-main_col-article">
        <div class="postAdd_t">Клуб  </div><?=  CHtml::link($forum->club->title, $forum->club->getUrl(), array('class'=>'heading-m margin-0')) ?>
    </div>
</div>
<!-- row -->
<div class="postAdd_row">
    <div class="postAdd_count">2</div>
    <div class="b-main_col-article">
        <div class="postAdd_t">Форум  </div><?=  CHtml::link($forum->title, $forum->getUrl(), array('class'=>'heading-m margin-0')) ?>
    </div>
</div>
<!-- row -->
<div class="postAdd_row">
    <div class="postAdd_count">3</div>
    <div class="b-main_col-article">
        <div class="postAdd_t">Рубрика  </div>

        <div class="inp-valid inp-valid__abs">
            <?=$form->dropDownList($model, 'rubricId', CHtml::listData(departmentModels\Rubric::model()->byForum($model->forumId)->findAll(), 'id', 'title'), array('class' => 'select-cus select-cus__search-off select-cus__gray')) ?>
            <?=$form->dropDownList($model, 'fromUserId', $users, array(
                'class' => 'display-n'
            )) ?>
        </div>
    </div>
</div>

<!-- Строка-->
<div class="postAdd_row">
    <div class="postAdd_count">4</div>
    <div class="b-main_col-article">
        <div class="inp-valid inp-valid__abs">
            <div class="inp-valid_count">30</div>
            <?=$form->textField($model, 'title', array('class' => 'itx-gray', 'placeholder' => 'Заголовок')) ?>
        </div>
    </div>
</div>

<!-- Строка-->
<div class="postAdd_row">
    <div class="postAdd_count">5</div>
    <div class="b-main_col-article">
        <div class="inp-valid inp-valid__abs">
            <md-redactor class="md-redactor" params="id: 'md-redactor-1', textareaId: 'markDownPreview', htmlId: 'htmlTextPreview'"></md-redactor>
        </div>
    </div>
</div>
<!-- Строка-->
<div class="postAdd_row">
    <div class="postAdd_count">6</div>
    <div class="b-main_col-article">
        <div class="inp-valid inp-valid__abs">
            <md-redactor class="md-redactor" style="display: block; border: 1px solid #e0e1e2; border-radius: 3px;" params="id: 'md-redactor-2', textareaId: 'markDown', htmlId: 'htmlText'"></md-redactor>
        </div>
    </div>
</div>

<!-- Строка-->
<!--<div class="postAdd_row">-->
<!--    <div class="postAdd_count">6</div>-->
<!--    <div class="b-main_col-article">-->
<!--        <div class="inp-valid inp-valid__abs">-->
<!--            <!-- <div class="inp-valid_count">450</div> -->
            <?=$form->textArea($model, 'meta[title]',  array('class' => 'itx-gray','class' => 'display-n')) ?>
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!-- Строка-->
<!--<div class="postAdd_row">-->
<!--    <div class="postAdd_count">7</div>-->
<!--    <div class="b-main_col-article">-->
<!--        <div class="inp-valid inp-valid__abs">-->
            <!-- <div class="inp-valid_count">450</div> -->
            <?=$form->textArea($model, 'meta[keywords]',  array('class' => 'itx-gray', 'class' => 'display-n')) ?>
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!-- Строка-->
<!--<div class="postAdd_row">-->
<!--    <div class="postAdd_count">8</div>-->
<!--    <div class="b-main_col-article">-->
<!--        <div class="inp-valid inp-valid__abs">-->
            <!-- <div class="inp-valid_count">450</div> -->
            <?=$form->textArea($model, 'meta[description]',  array('class' => 'itx-gray', 'class' => 'display-n')) ?>
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!-- Строка-->
<!--<div class="postAdd_row">-->
<!--    <div class="postAdd_count">9</div>-->
<!--    <div class="b-main_col-article">-->
<!--        <div class="inp-valid inp-valid__abs">-->
            <!-- <div class="inp-valid_count">450</div> -->
            <?=$form->textArea($model, 'social[title]',  array('class' => 'itx-gray', 'class' => 'display-n')) ?>
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!-- Строка-->
<!--<div class="postAdd_row">-->
<!--    <div class="postAdd_count">10</div>-->
<!--    <div class="b-main_col-article">-->
<!--        <div class="inp-valid inp-valid__abs">-->
            <!-- <div class="inp-valid_count">450</div> -->
            <?=$form->textArea($model, 'social[text]',  array('class' => 'itx-gray', 'class' => 'display-n')) ?>
<!--        </div>-->
<!--    </div>-->
<!--</div>-->


<?=$form->hiddenField($model, 'social[image]') ?>

<div class="postAdd_row">
    <div class="postAdd_count"></div>
    <div class="b-main_col-article clearfix">
        <div class="postAdd_btns-hold">
            <?=CHtml::resetButton('Отмена', array('class' => 'btn btn-link-gray margin-r15')) ?>
            <?=CHtml::submitButton('Опубликовать', array('class' => 'btn btn-xl btn-success')) ?>
        </div>
    </div>
</div>

<?php
$this->endWidget();

/**
 * @var ClientScript $cs
 */
$cs = Yii::app()->clientScript;
$cs->registerAMD("md-redactor", array("kow", "common"));
?>
</div>
</div>
</div>