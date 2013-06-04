<?php
$this->widget('application.extensions.YiiTagCloud.YiiTagCloud',
    array(
        'beginColor' => '00089A',
        'endColor' => 'A3AEFF',
        'minFontSize' => 12,
        'maxFontSize' => 30,
        'arrTags' => $tags,
    )
);