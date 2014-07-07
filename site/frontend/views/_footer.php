<div class="layout-footer clearfix">
    <div class="layout-footer_hold">

        <ul class="footer-list">
            <!--<li class="footer-list_li"><a href="http://m.happy-giraffe.ru" class="footer-list_a">Мобильная версия</a></li>-->
            <li class="footer-list_li"><span>О проекте</span></li>
            <li class="footer-list_li"><span>Правила</span></li>
            <li class="footer-list_li"><a href="<?=$this->createUrl('/site/page', array('view' => 'advertiser'))?>" class="footer-list_a">Реклама </a></li>
            <li class="footer-list_li"><a href="<?=$this->createUrl('/site/page', array('view' => 'abuse'))?>" class="footer-list_a">Правообладателям </a></li>
            <li class="footer-list_li"><span>Контакты </span></li>
            <li class="footer-list_li"><a href="http://www.rambler.ru/" class="footer-list_a" target="_blank">Партнер "Рамблера"</a><span id="counter-rambler" class="footer-list_rambler-count"></span></li>
        </ul>
        <?php if ($this->route != 'site/index' && $this->route != 'site/vacancy'): ?>
            <ul class="footer-ul-bold">
                <li class="footer-ul-bold_li"><a href="<?=$this->createUrl('/community/default/section', array('section_id'=>1)) ?>" class="footer-ul-bold_a">Беременность и дети</a></li>
                <li class="footer-ul-bold_li"><a href="<?=$this->createUrl('/community/default/section', array('section_id'=>2)) ?>" class="footer-ul-bold_a">Наш дом</a></li>
                <li class="footer-ul-bold_li"><a href="<?=$this->createUrl('/community/default/section', array('section_id'=>3)) ?>" class="footer-ul-bold_a">Красота и здоровье</a></li>
                <li class="footer-ul-bold_li"><a href="<?=$this->createUrl('/community/default/section', array('section_id'=>4)) ?>" class="footer-ul-bold_a">Муж и жена</a></li>
                <li class="footer-ul-bold_li"><a href="<?=$this->createUrl('/community/default/section', array('section_id'=>5)) ?>" class="footer-ul-bold_a">Интересы и увлечения</a></li>
                <li class="footer-ul-bold_li"><a href="<?=$this->createUrl('/community/default/section', array('section_id'=>6)) ?>" class="footer-ul-bold_a">Семейный отдых</a></li>
            </ul>
        <?php endif; ?>

        <div class="layout-footer_tx"> &copy; 2012-2013 Веселый Жираф. Социальная сеть для всей семьи. Использование редакционных материалов happy-giraffe.ru возможно только <br> с письменного разрешения редакции и/или при наличии активной ссылки на источник. Все права на пользовательские картинки и тексты принадлежат их авторам.
            Сайт предназначен для лиц старше 16 лет.</div>
    </div>
</div>