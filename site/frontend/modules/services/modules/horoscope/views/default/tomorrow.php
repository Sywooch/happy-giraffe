<?php
/* @var $this HController
 * @var $models Horoscope[]
 */
?>
<div class="horoscope-list">

    <h1><?=$this->title ?></h1>

    <ul><?php foreach ($models as $model)
        $this->renderPartial('_preview', compact('model'));
        ?></ul>

</div>

<div class="wysiwyg-content">

    <?=ServiceText::getText('horoscope', 'tomorrow') ?>

</div>