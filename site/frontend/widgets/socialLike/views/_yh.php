<button onclick="pushYohoho(this);" class="btn btn-green-smedium"><span><span>+2</span></span></button>
<div class="count"><?php echo Rating::model()->countByEntity($this->model, 'yh'); ?></div>
<?php
$js = 'function pushYohoho(elem) {
            ' . (Yii::app()->user->isGuest ? 'return false;' : '') . '
            Social.key = "yh";
            Social.elem = elem;
            Social.update(2);
        }';
Yii::app()->clientScript->registerScript('yohoho_script', $js, CClientScript::POS_HEAD);
?>