<?php
/**
 * @var $data InnerLink
 */
?><div style="padding-bottom: 5px;"><?=$index+1 ?>. Со страницы <span style="width: 400px;display: inline-block"><?= CHtml::link($data->page->getArticleTitle(), $data->page->url) ?></span>
    ссылка <?= CHtml::link(isset($data->keyword->name)?$data->keyword->name:'', $data->pageTo->url) ?>
    <a class="remove" href="javascript:;"
       onclick="CheckLinks.remove(<?=$data->page_id ?>, <?=$data->page_to_id ?>, this)"><img src="/images/button_cancel.png" /></a></div>