<?php if ($model->isNewRecord): ?>
    <div class="user-add-record user-add-record__yellow clearfix">
        <div class="user-add-record_ava-hold">
            <?php $this->widget('Avatar', array('user' => $this->user)); ?>
        </div>
        <div class="user-add-record_hold js_add_menu">
            <div class="user-add-record_tx">Я хочу добавить</div>
            <a href="" class="user-add-record_ico user-add-record_ico__article <?php if ($type == 1) echo 'active' ?>" onclick="return AddMenu.select(this, 1);">Статью</a>
            <a href="" class="user-add-record_ico user-add-record_ico__photo <?php if ($type == 3) echo 'active' ?>" onclick="return AddMenu.select(this, 3);">Фото</a>
            <a href="" class="user-add-record_ico user-add-record_ico__video <?php if ($type == 2) echo 'active' ?>" onclick="return AddMenu.select(this, 2);">Видео</a>
            <a href="" class="user-add-record_ico user-add-record_ico__status <?php if ($type == 5) echo 'active' ?>" onclick="return AddMenu.select(this, 5);">Статус</a>
        </div>
    </div>
    <script type="text/javascript">
        var AddMenu = {
            select: function (el, type) {
                $.post('/blog/form/type' + type + '/', {short: 1}, function (response) {
                    $('#add_form_container').html(response);
                    $('.js_add_menu a').removeClass('active');
                    $(el).addClass('active');
                });
                return false;
            }
        }
    </script>
<?php endif; ?>