
<!-- layout-footer-->
<div class="layout-footer clearfix">
    <div class="layout-footer_hold">
        <ul class="footer-list">
            <li class="footer-list_li visible-md-inline-block"><span class="footer-list_a">О нас</span></li>
            <li class="footer-list_li"><span class="footer-list_a">Правила сайта</span></li>
            <li class="footer-list_li"><a href="<?=$this->createUrl('/site/page', array('view' => 'abuse'))?>" class="footer-list_a">Правообладателям</a></li>
            <li class="footer-list_li"><a href="<?=$this->createUrl('/site/page', array('view' => 'advertiser'))?>" class="footer-list_a footer-list__reklama">Реклама </a></li>
            <li class="footer-list_li"><span class="footer-list_a">Контакты </span></li>
        </ul>
        <ul class="footer-menu visible-md">
            <li class="footer-menu_li"><a href="<?=$this->createUrl('/community/default/section', array('section_id' => 1))?>" class="footer-menu_a footer-menu_a__pregnancy">Беременность и дети</a></li>
            <li class="footer-menu_li"><a href="<?=$this->createUrl('/community/default/section', array('section_id' => 2))?>" class="footer-menu_a footer-menu_a__home">Наш дом</a></li>
            <li class="footer-menu_li"><a href="<?=$this->createUrl('/community/default/section', array('section_id' => 3))?>" class="footer-menu_a footer-menu_a__beauty">Красота и здоровье</a></li>
            <li class="footer-menu_li"><a href="<?=$this->createUrl('/community/default/section', array('section_id' => 4))?>" class="footer-menu_a footer-menu_a__husband-and-wife">Муж и жена</a></li>
            <li class="footer-menu_li"><a href="<?=$this->createUrl('/community/default/section', array('section_id' => 5))?>" class="footer-menu_a footer-menu_a__hobby">Интересы и увлечения</a></li>
            <li class="footer-menu_li"><a href="<?=$this->createUrl('/community/default/section', array('section_id' => 6))?>" class="footer-menu_a footer-menu_a__family-holiday">Семейный отдых</a></li>
        </ul>
        <div class="layout-footer_tx">© 2012–2014 Веселый Жираф. Социальная сеть для всей семьи. Использование редакционных материалов happy-giraffe.ru возможно только с письменного разрешения редакции и/или при наличии активной ссылки на источник. Все права на пользовательские картинки и тексты принадлежат их авторам. Сайт предназначен для лиц старше 16 лет.</div>
        <div class="layout-footer_privacy-hold"><span class="layout-footer_privacy">Политика конфедициальности</span><?php if ($this->route != 'archive/default/map'): ?><a href="<?=$this->createUrl('/archive/default/map')?>" class="layout-footer_privacy">Карта сайта</a><?php endif; ?></div>
    </div>
</div>
<!-- /layout-footer-->