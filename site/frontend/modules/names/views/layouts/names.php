<?php $this->beginContent('//layouts/baby_no_left_banner'); ?>
<script type="text/javascript">
    $(function() {
        $('body').delegate('a.like-btn', 'click', function(){
            var id = $(this).attr('rel');
            $.ajax({
                url:'<?php echo Yii::app()->createUrl("/names/default/like") ?>',
                data:{
                    id:id
                },
                type:'GET',
                dataType: 'JSON',
                success:function (data) {
                    if (data.success){
                        $(this).toggleClass('dislike_nm').toggleClass('like_nm');
                        $('li.likes span span').html(data.count);
                    }
                },
                context:$(this)
            });
            return false;
        });
    });
</script>
<div class="baby_hanbook_names">
    <ul class="handbook_changes_u">
        <li<?php if ($this->action->id == 'index') echo ' class="current_t"' ?>><a href="<?php
        echo $this->createUrl('/names/default/index', array()) ?>"><span>По алфавиту</span></a></li>
        <li<?php if ($this->action->id == 'top10') echo ' class="current_t"' ?>><a href="<?php echo $this->createUrl('/names/default/top10', array()) ?>"><span>ТОР-10 </span></a></li>
        <li<?php if ($this->action->id == 'saint') echo ' class="current_t"' ?>><a href="<?php echo $this->createUrl('/names/default/saint', array()) ?>"><span>По святцам</span></a></li>
        <?php if (!Yii::app()->user->isGuest):?>
            <li class="likes<?php if ($this->action->id == 'likes') echo ' current_t' ?>"><a href="<?php echo $this->createUrl('/names/default/likes', array()) ?>"><span>Нравятся<?php
                echo ' (<span>'.Yii::app()->controller->likes.'</span>)' ?></span></a></li>
        <?php endif ?>
    </ul>
</div><!-- .baby_hanbook_names -->
<?php echo $content; ?>

<?php $this->endContent(); ?>