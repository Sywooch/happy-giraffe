<?php
/* @var $this SitesController
 * @var $form CActiveForm
 */
?>
<div class="ext-links-add">

    <div class="nav clearfix">
        <?php

        $this->widget('zii.widgets.CMenu', array(
            'items' => array(
                array(
                    'label' => 'Добавить',
                    'url' => array('/externalLinks/forums/index')
                ),
                array(
                    'label' => 'Задания',
                    'url' => array('/externalLinks/forums/tasks'),
                ),
                array(
                    'label' => 'Выполнено',
                    'url' => array('/externalLinks/forums/executed'),
                ),
                array(
                    'label' => 'Отчеты',
                    'url' => array('/externalLinks/forums/reports'),
                ),
            )));
        ?>
    </div>

    <div style="height: 30px;">
        <div class="flash-message added" style="display: none;"></div>
    </div>

    <div class="check-url">
        <input id="site_url" type="text" placeholder="Введите URL форума"/>
        <button class="btn-g" onclick="ExtLinks.CheckSite()">Проверить</button>
    </div>

    <div class="url-actions" id="site_status_1" style="display: none;">

        <span class="new-site">Новый сайт</span>

        <button class="btn-g" onclick="ExtLinks.AddForum()">Добавить</button>

        <a href="javascript:;" class="pseudo" onclick="ExtLinks.CancelSite()">Отмена</a>

        <a href="javascript:;" class="icon-blacklist" onclick="ExtLinks.AddToBL(2)">ЧС</a>

    </div>

    <div class="url-actions" id="site_status_2" style="display: none;">

        <span class="have-links">Есть ссылки</span>

        <a href="javascript:;" class="pseudo" onclick="ExtLinks.CancelSite()">Отмена</a>

        <a href="javascript:;" class="icon-blacklist" onclick="ExtLinks.AddToBL(2)">ЧС</a>

    </div>

    <div class="url-actions" id="site_status_3" style="display: none;">

        <span class="in-blacklist">В черном списке</span>

        <button class="btn-g orange" onclick="ExtLinks.CancelSite()">Отмена</button>

        <a href="javascript:;" onclick="ExtLinks.AddForum()" class="pseudo">Добавить</a>

    </div>

</div>