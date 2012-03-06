<button onclick="pushYohoho(this);" class="btn btn-green-smedium<?php echo RatingYohoho::model()->findByEntity($this->model) ? ' selected' : ''; ?>"><span><span>+2</span></span></button>
<div class="count"><?php echo Rating::model()->countByEntity($this->model, 'yh'); ?></div>
<?php
$js = 'function pushYohoho(elem) {
            if($(elem).hasClass("disabled"))
                return false;
            $(elem).addClass("disabled");
            if($(elem).hasClass("selected"))
                $(elem).removeClass("selected");
            else
                $(elem).addClass("selected");
            ' . (Yii::app()->user->isGuest ? 'return false;' : '') . '
            Social.key = "yh";
            Social.elem = elem;
            Social.update(2, null, function() {$(elem).removeClass("disabled");});
        }';
Yii::app()->clientScript->registerScript('yohoho_script', $js, CClientScript::POS_HEAD);
?>