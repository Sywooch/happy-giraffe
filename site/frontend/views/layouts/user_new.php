<?php $this->beginContent('//layouts/main'); ?>

<?php
    $cs = Yii::app()->clientScript;
    $cs
        ->registerCssFile('/stylesheets/user.css')
    ;
?>

<div id="user">

    <div class="user-cols clearfix">

        <?=$content?>

    </div>

</div>

<?php $this->endContent(); ?>