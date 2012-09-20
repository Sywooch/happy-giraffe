<?php
/* @var $this SitesController
 * @var $form CActiveForm
 */
?>
<div class="ext-links-add">

    <?php $this->renderPartial('sub_menu')?>

    <div style="height: 30px;">
        <div class="flash-message added" style="display: none;"></div>
    </div>

    <div class="check-url">
        <input id="site_url" type="text" placeholder="Введите URL форума"/>
        <button class="btn-g" onclick="ExtLinks.AddForumExecuted()">Добавить</button>
    </div>

    <div class="url-actions" id="site_status_1" style="display: none;">

        <span class="new-site">Новый сайт</span>

        <a href="javascript:;" class="pseudo" onclick="ExtLinks.CancelSite()">Отмена</a>

        <a href="javascript:;" class="icon-blacklist" onclick="ExtLinks.AddToBL(2)">ЧС</a>

    </div>

    <div class="url-actions" id="site_status_2" style="display: none;">

        <span class="have-links">В работе</span>

        <a href="javascript:;" class="pseudo" onclick="ExtLinks.CancelSite()">Отмена</a>

        <a href="javascript:;" class="icon-blacklist" onclick="ExtLinks.AddToBL(2)">ЧС</a>

    </div>

    <div class="url-actions" id="site_status_3" style="display: none;">

        <span class="in-blacklist">В черном списке</span>

        <button class="btn-g orange" onclick="ExtLinks.CancelSite()">Отмена</button>

    </div>

    <div class="form" style="display:none;">

        <div class="tasks-list">

            <ul>
                <li>
                    <div class="task-title">Данные регистрации</div>
                    <?php $this->renderPartial('/forums/_reg_data'); ?>
                </li>
            </ul>

        <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'link-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'action' => '#',
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => false,
            'validateOnType' => false,
            'validationUrl' => $this->createUrl('/externalLinks/tasks/addLink'),
            'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    window.location.reload();
                                return false;
                              }",
        )));

        $model = new ELLink();
        $model->created = date("Y-m-d");
        echo $form->hiddenField($model, 'site_id');
        ?>

        <div class="row">
            <div class="row-title">
                <span>Внешний сайт</span> - адрес страницы
                <small>(на которой проставлена ссылка)</small>
            </div>
            <div class="row-elements">
                <?=$form->textField($model, 'url', array('placeholder' => 'Введите URL')) ?>
                <a href="javascript:;" class="btn-green-small" onclick="ExtLinks.loadPage()">load</a>
                <?=$form->error($model, 'url') ?>
            </div>
        </div>

        <div class="row">
            <div class="row-title">
                <span>Наш сайт</span> - адрес статьи / сервиса
                <small>(которые мы продвигаем)</small>
            </div>
            <div class="row-elements">
                <?=$form->textField($model, 'our_link', array('placeholder' => 'Введите URL')) ?>
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

        <div class="row">
            <div class="row-title">
                <span>Кто поставил</span>
            </div>
            <div class="row-elements">
                <div class="col">
                    <?=$form->dropDownList($model, 'author_id', CHtml::listData(SeoUser::getSmoUsers(), 'id', 'name')) ?>
                    <?=$form->error($model, 'author_id') ?>
                </div>
                <div class="col">
                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'created',
                    'language' => 'ru',
                    'options' => array(
                        'showAnim' => 'fold',
                        'dateFormat' => 'yy-mm-dd',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Дата',
                        'class' => 'date'
                    ),
                )); ?>
                    <a href="javascript:;" class="icon-date" onclick="$(this).prev().trigger('focus')"></a>
                    <?=$form->error($model, 'created') ?>
                </div>

            </div>
        </div>

        <div class="row row-btn-done">

            <button class="btn-g">Выполнено</button>

        </div>

        <?php $this->endWidget(); ?>

    </div>

    </div>

</div>
