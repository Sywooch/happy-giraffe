
<!-- layout-footer-->
<div class="layout-footer clearfix">
    <div class="layout-footer_hold">
        <ul class="footer-list">
            <li class="footer-list_li visible-md-inline-block"><a href="<?=$this->createUrl('/pages/default/page', array('view' => 'about'))?>" class="footer-list_a">О нас</a></li>
            <li class="footer-list_li"><a href="<?=$this->createUrl('/pages/default/page', array('view' => 'useragreement'))?>" class="footer-list_a">Правила сайта</a></li>
            <li class="footer-list_li"><a href="<?=$this->createUrl('/pages/default/page', array('view' => 'legal'))?>" class="footer-list_a">Правообладателям</a></li>
            <li class="footer-list_li"><a href="<?=$this->createUrl('/pages/default/page', array('view' => 'ad'))?>" class="footer-list_a footer-list__reklama">Реклама </a></li>
            <li class="footer-list_li"><a href="<?=$this->createUrl('/pages/default/page', array('view' => 'contacts'))?>" class="footer-list_a">Контакты </a></li>
        </ul>
        <?php if ($this->route != 'site/index'): ?>
            <ul class="footer-menu visible-md">
                <li class="footer-menu_li">
                <div class="footer-menu_t footer-menu_t__husband-and-wife">
                    Муж и жена
                </div>
                <ul class="footer-menu_in">
                    <li class="footer-menu_in-li"><a href="/wedding/" class="footer-menu_in-a">Свадьба </a></li>
                    <li class="footer-menu_in-li"><a href="/relations/" class="footer-menu_in-a">Отношения в семье</a></li>
                </ul>
                </li>
                <li class="footer-menu_li">
                <div class="footer-menu_t footer-menu_t__pregnancy">
                    Беременность и дети
                </div>
                <ul class="footer-menu_in">
                    <li class="footer-menu_in-li"><a href="/planning-pregnancy/" class="footer-menu_in-a">Планирование </a></li>
                    <li class="footer-menu_in-li"><a href="/pregnancy-and-birth/" class="footer-menu_in-a">Беременность и роды</a></li>
                    <li class="footer-menu_in-li"><a href="/babies/" class="footer-menu_in-a">Дети до года</a></li>
                    <li class="footer-menu_in-li"><a href="/kids/" class="footer-menu_in-a">Дети старше года</a></li>
                    <li class="footer-menu_in-li"><a href="/preschoolers/" class="footer-menu_in-a">Дошкольники</a></li>
                    <li class="footer-menu_in-li"><a href="/schoolers/" class="footer-menu_in-a">Школьники</a></li>
                </ul>
                </li>
                <li class="footer-menu_li">
                <div class="footer-menu_t footer-menu_t__home">
                    Наш дом
                </div>
                <ul class="footer-menu_in">
                    <li class="footer-menu_in-li"><a href="/cook/" class="footer-menu_in-a">Готовим на кухне</a></li>
                    <li class="footer-menu_in-li"><a href="/repair-house/" class="footer-menu_in-a">Ремонт в доме</a></li>
                    <li class="footer-menu_in-li"><a href="/homework/" class="footer-menu_in-a">Домашние хлопоты</a></li>
                    <li class="footer-menu_in-li"><a href="/garden/" class="footer-menu_in-a">Сад и огород</a></li>
                    <li class="footer-menu_in-li"><a href="/pets/" class="footer-menu_in-a">Наши питомцы </a></li>
                </ul>
                </li>
                <li class="footer-menu_li">
                <div class="footer-menu_t footer-menu_t__beauty">
                    Красота и здоровье
                </div>
                <ul class="footer-menu_in">
                    <li class="footer-menu_in-li"><a href="/beauty-and-fashion/" class="footer-menu_in-a">Красота и мода</a></li>
                    <li class="footer-menu_in-li"><a href="/health/" class="footer-menu_in-a">Наше здоровье</a></li>
                </ul>
                </li>
                <li class="footer-menu_li">
                <div class="footer-menu_t footer-menu_t__hobby">
                    Интересы и увлечения
                </div>
                <ul class="footer-menu_in">
                    <li class="footer-menu_in-li"><a href="/needlework/" class="footer-menu_in-a">Рукоделие</a></li>
                    <li class="footer-menu_in-li"><a href="/homeflowers/" class="footer-menu_in-a">Цветы в доме</a></li>
                    <li class="footer-menu_in-li"><a href="/auto/" class="footer-menu_in-a">Наш автомобиль</a></li>
                    <li class="footer-menu_in-li"><a href="/fishing/" class="footer-menu_in-a">Рыбалка</a></li>
                </ul>
                </li>
                <li class="footer-menu_li">
                <div class="footer-menu_t footer-menu_t__family-holiday">
                    Семейный отдых
                </div>
                <ul class="footer-menu_in">
                    <li class="footer-menu_in-li"><a href="/travel/" class="footer-menu_in-a">Мы путешествуем</a></li>
                    <li class="footer-menu_in-li"><a href="/weekends/" class="footer-menu_in-a">Выходные с семьей</a></li>
                    <li class="footer-menu_in-li"><a href="/holidays/" class="footer-menu_in-a">Праздники</a></li>
                </ul>
                </li>
            </ul>

            <?php if (false): ?>
                <ul class="footer-menu visible-md">
                    <li class="footer-menu_li"><
                        a href="<?=$this->createUrl('/community/default/section', array('section_id' => 1))?>" class="footer-menu_a footer-menu_a__pregnancy">Беременность и дети</a>
                    </li>
                    <li class="footer-menu_li">
                        <a href="<?=$this->createUrl('/community/default/section', array('section_id' => 2))?>" class="footer-menu_a footer-menu_a__home">Наш дом</a>
                    </li>
                    <li class="footer-menu_li"><a href="<?=$this->createUrl('/community/default/section', array('section_id' => 3))?>" class="footer-menu_a footer-menu_a__beauty">Красота и здоровье</a></li>
                    <li class="footer-menu_li"><a href="<?=$this->createUrl('/community/default/section', array('section_id' => 4))?>" class="footer-menu_a footer-menu_a__husband-and-wife">Муж и жена</a></li>
                    <li class="footer-menu_li"><a href="<?=$this->createUrl('/community/default/section', array('section_id' => 5))?>" class="footer-menu_a footer-menu_a__hobby">Интересы и увлечения</a></li>
                    <li class="footer-menu_li"><a href="<?=$this->createUrl('/community/default/section', array('section_id' => 6))?>" class="footer-menu_a footer-menu_a__family-holiday">Семейный отдых</a></li>
                </ul>
            <?php endif; ?>
        <?php endif; ?>
        <div class="layout-footer_tx">© 2012–2015 Веселый Жираф. Социальная сеть для всей семьи. Использование редакционных материалов happy-giraffe.ru возможно только с письменного разрешения редакции и/или при наличии активной ссылки на источник. Все права на пользовательские картинки и тексты принадлежат их авторам. Сайт предназначен для лиц старше 16 лет.</div>
        <div class="layout-footer_privacy-hold"><a href="<?=$this->createUrl('/pages/default/page', array('view' => 'confidential'))?>" class="layout-footer_privacy">Политика конфиденциальности</a><?php if ($this->route != 'archive/default/map'): ?><a href="<?=$this->createUrl('/archive/default/map')?>" class="layout-footer_privacy">Карта сайта</a><?php endif; ?></div>
    </div>
</div>
<!-- /layout-footer-->