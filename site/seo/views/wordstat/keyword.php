<?php
/* @var $this Controller
 * @var $yandex YandexPopularity
 */
?>
<b>Id:</b> <?= $yandex->keyword_id ?><br>
<b>Date:</b> <?= $yandex->date ?><br>
<b>Value:</b> <?= $yandex->value ?><br>
<b>Parsed:</b> <?= $yandex->parsed ?>  <br>
<b>Theme:</b> <?= $yandex->theme ?>        <br>
<b>Count:</b> <?= Keyword::model()->findSimilarCount($yandex->keyword->name) ?><br>