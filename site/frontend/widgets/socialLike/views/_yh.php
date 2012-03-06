<button onclick="pushYohoho(this);" class="<?php echo Yii::app()->user->isGuest ? 'yohoho_guest ' : '' ?>btn btn-green-smedium<?php echo RatingYohoho::model()->findByEntity($this->model) ? ' btn-purple-smedium' : ''; ?>"><span><span>+2</span></span></button>
<div class="count"><?php echo Rating::model()->countByEntity($this->model, 'yh'); ?></div>
<?php
$js = 'function pushYohoho(elem) {
            ' . (Yii::app()->user->isGuest ? 'return false;' : '
            if($(elem).hasClass("disabled"))
                return false;
            $(elem).addClass("disabled");
            $(elem).toggleClass("btn-purple-smedium");
            Social.key = "yh";
            Social.elem = elem;
            Social.update(2, null, function() {$(elem).removeClass("disabled");});') . '
        }';
Yii::app()->clientScript->registerScript('yohoho_script', $js, CClientScript::POS_HEAD);
?>