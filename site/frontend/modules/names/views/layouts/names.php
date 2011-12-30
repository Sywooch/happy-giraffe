<?php $this->beginContent('//layouts/baby_no_left_banner'); ?>
<script type="text/javascript">
    $(function() {
        $('body').delegate('a.like','click',function(){
            $.ajax({
                url: '<?php echo Yii::app()->createUrl("/names/default/like") ?>',
                data: {'id':$(this).attr('obj_id')},
                dataType:'JSON',
                type: 'GET',
                success: function(data) {
                    if (data.success === false){
                        $(this).text('unlike');
                    }else
                        $(this).text('like');
                },
                context:$(this)
            });
            return false;
        });
    });
</script>
<div class="baby_hanbook_names">
    <ul class="handbook_changes_u">
        <li class="current_t"><a href="<?php echo $this->createUrl('/names/default/index', array()) ?>"><span>По алфавиту</span></a></li>
        <li><a href="<?php echo $this->createUrl('/names/default/top10', array()) ?>"><span>ТОР-10 </span></a></li>
        <li><a href="<?php echo $this->createUrl('/names/default/saint', array()) ?>"><span>По святцам</span></a></li>
        <li class="likes"><a href="<?php echo $this->createUrl('/names/default/likes', array()) ?>"><span>Нравятся<?php
            if (Yii::app()->controller->likes != 0 ) echo ' ('.Yii::app()->controller->likes.')' ?></span></a></li>
    </ul>
</div><!-- .baby_hanbook_names -->
<?php echo $content; ?>

<?php $this->endContent(); ?>