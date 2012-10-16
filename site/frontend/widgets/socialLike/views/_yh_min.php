<div class="like-btn">
     <?php if (Yii::app()->user->isGuest):?>
         <a class="btn-icon heart fancy" href="#login" data-theme="white-square"></a>
     <?php else: ?>
         <a class="btn-icon heart heart2<?=(! Yii::app()->user->isGuest && get_class($this->model) == 'ContestWork' && Yii::app()->user->model->scores->full != 2) ? ' yohoho_steps':''?><?php echo isset($this->model->author) && Yii::app()->user->id == $this->model->author->id ? ' yohoho_me ' : '' ?><?php echo RatingYohoho::model()->findByEntity($this->model) ? ' active' : ''; ?>" href="javascript:;" onclick="pushYohoho(this);"></a>
     <?php endif ?>

     <div class="count"><?php echo Rating::model()->countByEntity($this->model, 'yh') / 2; ?></div>

    <?php if (! Yii::app()->user->isGuest && get_class($this->model) == 'ContestWork'): ?>
        <div class="contest-error-hint" style="display: none;">
            <h4>Oops!</h4><p>Чтобы проголосовать, вам нужно пройти <?=CHtml::link('пройти первые 6 шагов', Yii::app()->user->model->url)?> в свой анкете </p>
        </div>
    <?php endif; ?>
 </div>
<script type="text/javascript">
    function pushYohoho(elem) {
        <?php if(Yii::app()->user->isGuest || (!Yii::app()->user->isGuest && isset($this->model->author) && Yii::app()->user->id == $this->model->author->id) || (! Yii::app()->user->isGuest && get_class($this->model) == 'ContestWork' && Yii::app()->user->model->scores->full != 2)): ?>
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