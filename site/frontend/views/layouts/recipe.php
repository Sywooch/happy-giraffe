<?php $this->beginContent('//layouts/community'); ?>

<div class="content-cols clearfix">
    <div class="col-1">

        <div class="readers2">
            <a class="btn-green btn-medium" href="">Вступить в клуб</a>
            <ul class="readers2_ul clearfix">
                <li class="readers2_li clearfix">
                    <a class="ava female small" href="">
                        <span class="icon-status status-online"></span>
                        <img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
                    </a>
                </li>
                <li class="readers2_li clearfix">
                    <a class="ava female small" href="">
                        <img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
                    </a>
                </li>
                <li class="readers2_li clearfix">
                    <a class="ava female small" href="">
                        <span class="icon-status status-online"></span>
                        <img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
                    </a>
                </li>
                <li class="readers2_li clearfix">
                    <a class="ava female small" href="">
                    </a>
                </li>
                <li class="readers2_li clearfix">
                    <a class="ava female small" href="">
                        <span class="icon-status status-online"></span>
                        <img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
                    </a>
                </li>
                <li class="readers2_li clearfix">
                    <a class="ava male small" href="">
                        <span class="icon-status status-online"></span>
                    </a>
                </li>
            </ul>
            <div class="clearfix">
                <div class="readers2_count">Все участники клуба (129)</div>
            </div>
        </div>

        <div class="sidebar-search sidebar-search__gray clearfix">
            <input type="text" placeholder="Поиск из 15611 рецептов" class="sidebar-search_itx" id="" name="">
            <!--
            В начале ввода текста, скрыть sidebar-search_btn добавить класс active"
             -->
            <button class="sidebar-search_btn"></button>
        </div>

        <div class="menu-simple">
            <ul class="menu-simple_ul">
                <?php foreach (CActiveRecord::model($this->modelName)->types as $id => $label): ?>
                    <li class="menu-simple_li<?php if ($this->currentType == $id): ?> active<?php endif; ?>">
                        <?=HHtml::link($label, $this->getTypeUrl($id), array('class' => 'menu-simple_a'), true)?>
                        <div class="menu-simple_count"><?=isset($this->counts[$id]) ? $this->counts[$id] : 0?></div>
                    </li>
                <?php endforeach; ?>

                <?php if (false): ?>
                <li class="menu-simple_li">
                    <a class="menu-simple_a" href="">Все рецепты</a>
                    <div class="menu-simple_count">789</div>
                </li>
                <li class="menu-simple_li">
                    <a class="menu-simple_a" href="">Первые блюда</a>
                    <div class="menu-simple_count">789</div>
                </li>
                <li class="menu-simple_li">
                    <a class="menu-simple_a" href="">Вторые блюда </a>
                    <div class="menu-simple_count">789</div>
                </li>
                <li class="menu-simple_li">
                    <a class="menu-simple_a" href="">Салаты  </a>
                    <div class="menu-simple_count">789</div>
                </li>
                <li class="menu-simple_li">
                    <a class="menu-simple_a" href="">Закуски и бутерброды </a>
                    <div class="menu-simple_count">789</div>
                </li>
                <li class="menu-simple_li">
                    <a class="menu-simple_a" href="">Сладкая выпечка </a>
                    <div class="menu-simple_count">7</div>
                </li>
                <li class="menu-simple_li active">
                    <a class="menu-simple_a" href="">Торты и пирожные </a>
                    <div class="menu-simple_count">79</div>
                </li>
                <li class="menu-simple_li">
                    <a class="menu-simple_a" href="">Несладкая выпечка </a>
                    <div class="menu-simple_count">123789</div>
                </li>
                <li class="menu-simple_li">
                    <a class="menu-simple_a" href="">Торты и пирожные </a>
                    <div class="menu-simple_count">79</div>
                </li>
                <li class="menu-simple_li">
                    <a class="menu-simple_a" href="">Десерты </a>
                    <div class="menu-simple_count">9</div>
                </li>
                <li class="menu-simple_li">
                    <a class="menu-simple_a" href="">Напитки </a>
                    <div class="menu-simple_count">71189</div>
                </li>
                <li class="menu-simple_li">
                    <a class="menu-simple_a" href="">Соусы и кремы </a>
                    <div class="menu-simple_count">23434</div>
                </li>
                <li class="menu-simple_li">
                    <a class="menu-simple_a" href="">Консервация </a>
                    <div class="menu-simple_count">782239</div>
                </li>
                <?php endif; ?>
            </ul>
        </div>

        <div class="banner">
            <a href="">
                <img src="/images/banners/6.jpg" alt="">
            </a>
        </div>
    </div>
    <div class="col-23-middle ">


        <div class="clearfix margin-r20 margin-b20">
            <a href="" class="btn-blue btn-h46 float-r">Добавить рецепт</a>
        </div>
        <div class="col-gray">

            <?=$content?>

        </div>
    </div>
</div>

<?php $this->endContent(); ?>