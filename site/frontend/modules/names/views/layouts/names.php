<?php $this->beginContent('//layouts/main'); ?>
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
<a href="<?php echo $this->createUrl('/names/default/index', array()) ?>">А-Я</a>
<a href="<?php echo $this->createUrl('/names/default/top10', array()) ?>">Top10</a>
<a href="<?php echo $this->createUrl('/names/default/saint', array()) ?>">Святые отцы</a>
<a href="<?php echo $this->createUrl('/names/default/likes', array()) ?>">Мне нравиться<?php
    if (Yii::app()->controller->likes != 0 ) echo ' ('.Yii::app()->controller->likes.')' ?></a>
<br><br>
    <?php echo $content; ?>
<?php $this->endContent(); ?>