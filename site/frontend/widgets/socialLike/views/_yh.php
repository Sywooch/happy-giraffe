<div class="hg-like">
    <button onclick="pushYohoho();" class="btn btn-green-smedium"><span><span>+2</span></span></button>
    <div class="count"><?php echo Rating::countByEntity($this->model, 'yh'); ?></div>
</div>
<?php
$js = 'function pushYohoho() {
            ' . (Yii::app()->user->isGuest ? 'return false;' : '') . '
            Social.key = "yh";
            Social.update(2);
        }';
Yii::app()->clientScript->registerScript('yohoho_script', $js, CClientScript::POS_HEAD);
?>