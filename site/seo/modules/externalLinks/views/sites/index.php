<?php
/* @var $this SitesController
 * @var $form CActiveForm
 */
?><div class="ext-links-add">

    <div class="nav clearfix">
        <?php

        $this->widget('zii.widgets.CMenu', array(
            'items' => array(
                array(
                    'label' => 'Добавить',
                    'url' => array('/externalLinks/sites/index')
                ),
                array(
                    'label' => 'Отчеты',
                    'url' => array('/externalLinks/sites/reports'),
                ),
            )));
        ?>
    </div>

    <div class="flash-message added" style="display: none;">
        Ваша ссылка добавлена &nbsp;&nbsp; <a href="">Перейти</a>
    </div>

    <div class="check-url">
        <input id="site_url" type="text" placeholder="Введите URL сайта "/>
        <button class="btn-g" onclick="ExtLinks.CheckSite()">Проверить</button>
    </div>

    <div class="url-actions" id="site_status_1" style="display: none;">

        <span class="new-site">Новый сайт</span>

        <button class="btn-g" onclick="$('div.form').show()">Добавить</button>

        <a href="javascript:;" class="pseudo" onclick="ExtLinks.CancelSite()">Отмена</a>

        <a href="javascript:;" class="icon-blacklist" onclick="ExtLinks.AddToBL()">ЧС</a>

    </div>

    <div class="url-actions" id="site_status_2" style="display: none;">

        <span class="have-links">Есть ссылки</span>

        <button class="btn-g disabled" onclick="$('div.form').show()">Добавить</button>

        <a href="javascript:;" class="pseudo" onclick="ExtLinks.CancelSite()">Отмена</a>

        <a href="javascript:;" class="icon-blacklist" onclick="ExtLinks.AddToBL()">ЧС</a>

    </div>

    <div class="url-actions" id="site_status_3" style="display: none;">

        <span class="in-blacklist" onclick="ExtLinks.AddToBL()">В черном списке</span>

        <button class="btn-g orange" onclick="ExtLinks.CancelSite()">Отмена</button>

        <a href="javascript:;" onclick="$('div.form').show()" class="pseudo">Добавить</a>

    </div>

    <div class="url-list" style="display: none;">

        <ul>
            <li><a href=""></a></li>
        </ul>

    </div>

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'link-form',
        'enableAjaxValidation'=>false,
    ));
    $model = new ELLink();
    $model->author_id = Yii::app()->user->id;
    $model->created = date("Y-m-d");
    ?>
        <div class="form" <?php //style="display: none;" ?>>

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

            <div class="row">
                <div class="row-title">
                    <span>Анкор</span>
                </div>
                <div class="row-elements">
                    <input type="text"/> <a href="" class="icon-btn-add"></a>
                    <input type="text"/>
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
                        <?=$form->dateField($model, 'created', array('placeholder'=>'Дата', 'class'=>'date')) ?>
                        <a href="" class="icon-date"></a>
                        <?=$form->error($model, 'created') ?>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="row-title">
                    <span>Тип ссылки</span>
						<span class="link-types">
							<a href="javascript:;" class="icon-link link" onclick="$('#ELLink_link_type').val(<?=ELLink::TYPE_LINK ?>);">С</a> - ссылка
							<a href="javascript:;" class="icon-link comment" onclick="$('#ELLink_link_type').val(<?=ELLink::TYPE_COMMENT ?>);">К</a> - комментарий
							<a href="javascript:;" class="icon-link post" onclick="$('#ELLink_link_type').val(<?=ELLink::TYPE_POST ?>);">П</a> - постовой
						</span>
                    <?=$form->hiddenField($model, 'link_type') ?>
                    <?=$form->error($model, 'link_type') ?>
                </div>
            </div>

            <div class="row">
                <div class="row-title">
                    <span>Платная</span>
                    <span class="title-cost">Стоимость</span>
                    <span class="title-sys">Система</span>

                </div>
                <div class="row-elements">
                    <div class="col col-free">
                        <input type="checkbox"/>
                    </div>
                    <div class="col col-cost">
                        <?=$form->textField($model, 'link_cost') ?> руб.
                        <?=$form->error($model, 'link_cost') ?>
                    </div>
                    <div class="col col-sys">
                        <?=$form->dropDownList($model, 'system_id', CHtml::listData(ELSystem::model()->findAll(), 'id', 'name')) ?>
                        <?=$form->error($model, 'system_id') ?>
                    </div>
                </div>
            </div>

            <div class="row row-btn">
                <button class="btn-g">Добавить</button>
            </div>

        </div>

    <?php $this->endWidget(); ?>


</div>