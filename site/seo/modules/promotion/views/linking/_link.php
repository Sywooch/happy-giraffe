<?php
/**
 * @var $data InnerLink
 */
?><div style="padding-bottom: 5px;">Со страницы <span style="width: 400px;display: inline-block"><?= CHtml::link($data->page->getArticleTitle(), $data->page->url) ?></span>
    ссылка <?= CHtml::link($data->pageTo->getArticleTitle(), $data->pageTo->url) ?></div>