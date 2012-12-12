<h1 class="title-page"><i class="icon-popular-medium"></i>Как стать популярным</h1>
<ul class="link-list">
    <li>
        <a class="q-title" href="">Где найти картинки для блога: простые и не очень пути</a>

        <div style="display: none">
            <a class="back" href="">Назад</a><br><br>

            <div class="wysiwyg-content">
                <?php $this->renderPartial('_q1') ?>
            </div>
        </div>
    </li>
    <li>
        <a class="q-title" href="">Идеи для постов</a>

        <div style="display: none">
            <a class="back" href="">Назад</a><br><br>

            <div class="wysiwyg-content">
                <?php $this->renderPartial('_q2') ?>
            </div>
        </div>
    </li>
    <li>
        <a class="q-title" href="">Как выбрать тематику для блога</a>

        <div style="display: none">
            <a class="back" href="">Назад</a><br><br>

            <div class="wysiwyg-content">
                <?php $this->renderPartial('_q3') ?>
            </div>
        </div>
    </li>
    <li>
        <a class="q-title" href="">Как отличаться от других блоггеров</a>

        <div style="display: none">
            <a class="back" href="">Назад</a><br><br>

            <div class="wysiwyg-content">
                <?php $this->renderPartial('_q4') ?>
            </div>
        </div>
    </li>
    <li>
        <a class="q-title" href="">Как придумать привлекательный заголовок</a>

        <div style="display: none">
            <a class="back" href="">Назад</a><br><br>

            <div class="wysiwyg-content">
                <?php $this->renderPartial('_q5') ?>
            </div>
        </div>
    </li>
</ul>
<script type="text/javascript">
    $('body').delegate('.link-list a.q-title', 'click', function (e) {
        e.preventDefault();
        $('a.q-title').hide();
        $(this).next().show();
    });

    $('body').delegate('a.back', 'click', function (e) {
        e.preventDefault();
        $(this).parent().hide();
        $('a.q-title').show();
    });
</script>
<style type="text/css">
    p {margin-bottom: 15px;}
</style>