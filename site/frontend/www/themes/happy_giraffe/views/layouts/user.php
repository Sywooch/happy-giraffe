<?php $this->beginContent('//layouts/main'); ?>

<div id="user">

    <div class="header clearfix">

        <div class="user-fast">
            <div class="ava"></div>
            <div class="details">
                <span class="icon-status status-online"></span>
                <a href="" class="username">Александр Богоявленский</a><br/>
                <div class="location"><div class="flag flag-ru"></div>Гаврилов-Ям</div>
                <div class="birthday"><span>Д.р.</span> 15 декабря (39 лет)</div>
            </div>
        </div>

        <div class="user-nav">
            <ul>
                <li><a href="">Анкета</a></li>
                <li class="active"><a href="">Блог</a></li>
                <li><a href="">Фото</a></li>
                <li><a href="">Друзья</a></li>
                <li><a href="">Клубы</a></li>
            </ul>
        </div>

    </div>

    <?php echo $content; ?>

</div>

<?php $this->endContent(); ?>