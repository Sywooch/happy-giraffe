<?php if ($model->isNewRecord): ?>
    <div class="user-add-record user-add-record__yellow clearfix">
        <div class="user-add-record_ava-hold">
            <?php $this->widget('Avatar', array('user' => $this->user)); ?>
        </div>
        <div class="user-add-record_hold js_add_menu">
            <div class="user-add-record_tx">Я хочу добавить</div>
            <a href="<?=$this->createUrl('form', array('type' => 1))?>" class="user-add-record_ico user-add-record_ico__article fancy-top <?php if ($type == 1) echo 'active' ?>">Статью</a>
            <a href="<?=$this->createUrl('form', array('type' => 3))?>" class="user-add-record_ico user-add-record_ico__photo fancy-top <?php if ($type == 3) echo 'active' ?>">Фото</a>
            <a href="<?=$this->createUrl('form', array('type' => 2))?>" class="user-add-record_ico user-add-record_ico__video fancy-top <?php if ($type == 2) echo 'active' ?>">Видео</a>
            <a href="<?=$this->createUrl('form', array('type' => 5))?>" class="user-add-record_ico user-add-record_ico__status fancy-top <?php if ($type == 5) echo 'active' ?>">Статус</a>
        </div>
    </div>
<?php endif; ?>
<script type="text/javascript">
    $('body').delegate('a.fancy-top', 'click', function () {
        var onComplete_function = function () {
            var scTop = $(document).scrollTop();
            var box = $('#fancybox-wrap');

            boxTop = parseInt(Math.max(scTop + 20));
            box.stop().animate({'top' : boxTop}, 200);
        };

        $(this).clone().fancybox({
            overlayColor:'#2d1a3f',
            overlayOpacity:'0.6',
            padding:0,
            showCloseButton:false,
            centerOnScroll:false,
            onComplete:onComplete_function
        }).trigger('click');
        return false;
    });
</script>