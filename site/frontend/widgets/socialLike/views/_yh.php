<button onclick="pushYohoho(this);" class="<?php echo Yii::app()->user->isGuest ? 'yohoho_guest ' : '' ?><?php echo !Yii::app()->user->isGuest && isset($this->model->author) && Yii::app()->user->id == $this->model->author->id ? 'yohoho_me ' : '' ?>btn btn-green-smedium<?php echo HGLike::model()->findByEntity($this->model) ? ' btn-purple-smedium' : ''; ?>"><span><span>+2</span></span></button>
<div class="count"><?php echo Rating::model()->countByEntity($this->model, 'yh') / 2; ?></div>
<?php
$js = 'function pushYohoho(elem) {
            ' . (Yii::app()->user->isGuest || (!Yii::app()->user->isGuest && isset($this->model->author) && Yii::app()->user->id == $this->model->author->id) ? 'return false;' : '
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