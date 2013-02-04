<?php
/* @var $this Controller
 * @var $models Page[]
 */

$model = new Page();
?><div class="add-article">

    <div class="block-title">Добавить статью</div>

    <div class="clearfix">
        <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'article-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => false,
            'validateOnType' => false,
            'validationUrl' => $this->createUrl('validate'),
            'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    SeoModule.SaveArticleKeys();
                                else{

                                }
                                return false;
                              }",
        )));  ?>
        <div class="step-1">
            <div class="num"><span>1</span>Ключевое слово или фраза</div>
            <?= $form->textArea($model, 'keywords') ?>
            <?= $form->error($model, 'keywords'); ?>
        </div>

        <div class="arrow"></div>

        <div class="step-2">
            <div class="num"><span>2</span>Ссылка на статью</div>
            <?= $form->textField($model, 'url', array('class'=>'article-url')) ?>
            <?= $form->error($model, 'url'); ?>
            <button class="btn btn-green">Ok</button>
        </div>
        <?php $this->endWidget(); ?>
    </div>

</div>

<div class="seo-table">
    <div class="meta">
        <span>Статей: <span class="count articles-count"><?=Page::model()->count(); ?></span></span>
        <span>Ключевых слов: <span class="count keywords-count"><?=Yii::app()->db_keywords->createCommand('select count(keyword_id) from happy_giraffe_seo.keyword_group_keywords')->queryScalar(); ?></span></span>
    </div>
    <div class="table-box">
        <table>
            <colgroup>
                <col width="60" />
                <col width="400" />
                <col />
            </colgroup>
            <thead>
            <tr>
                <th class="col-1">№<br/>п/п</th>
                <th>Название статьи, ссылка</th>
                <th>Ключевые слова и фразы</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($models as $model): ?>
                <?php $this->renderPartial('_article',compact('model')); ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<style type="text/css">
    span.count{
        margin-left: 0 !important;
    }
</style>