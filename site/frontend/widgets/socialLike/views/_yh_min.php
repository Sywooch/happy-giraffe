<div class="like-btn">
     <a class="btn-icon heart<?php echo Yii::app()->user->isGuest ? ' yohoho_guest' : '' ?><?php echo !Yii::app()->user->isGuest && isset($this->model->author) && Yii::app()->user->id == $this->model->author->id ? ' yohoho_me ' : '' ?><?php echo RatingYohoho::model()->findByEntity($this->model) ? ' active' : ''; ?>" href="javascript:;" onclick="pushYohoho(this);"></a>

     <div class="count"><?php echo Rating::model()->countByEntity($this->model, 'yh') / 2; ?></div>
 </div>
<script type="text/javascript">
    function pushYohoho(elem) {
        <?php if(Yii::app()->user->isGuest || (!Yii::app()->user->isGuest && isset($this->model->author) && Yii::app()->user->id == $this->model->author->id)): ?>
            return false;
        <?php else: ?>
            if($(elem).hasClass("disabled"))
                return false;
            $(elem).addClass("disabled");
            $(elem).toggleClass("active");
            Social.key = "yh";
            Social.elem = elem;
            Social.update(2, null, function() {$(elem).removeClass("disabled");});
        <?php endif; ?>
    }
</script>