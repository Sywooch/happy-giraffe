<footer class="footer footer--style">
    <div class="b-container b-container--padding">
        <ul class="footer__list footer__list--style-1">
            <li class="footer__li footer__li--style-1"><a href="<?=$this->createUrl('/pages/default/page', array('view' => 'about'))?>" class="footer__link footer__link--color">О нас</a></li>
            <li class="footer__li footer__li--style-1"><a href="<?=$this->createUrl('/pages/default/page', array('view' => 'useragreement'))?>" class="footer__link footer__link--color">Правила сайта</a></li>
            <li class="footer__li footer__li--style-1"><a href="<?=$this->createUrl('/pages/default/page', array('view' => 'legal'))?>" class="footer__link footer__link--color">Правообладателям</a></li>
            <li class="footer__li footer__li--style-1"><a href="<?=$this->createUrl('/pages/default/page', array('view' => 'advertising'))?>" class="footer__link footer__link--color footer__link--orange">Реклама</a></li>
            <li class="footer__li footer__li--style-1"><a href="<?=$this->createUrl('/pages/default/page', array('view' => 'contacts'))?>" class="footer__link footer__link--color">Контакты</a></li>
        </ul>
        <div class="footer__text b-margin--bottom_5">ИП Гаврилина Елена Владимировна, ИНН 771471845300</div>
        <div class="footer__text">© 2012–<?php echo date('Y'); ?> Веселый Жираф. Социальная сеть для всей семьи. Использование редакционных материалов happy-giraffe.ru возможно только с письменного разрешения редакции и/или при наличии активной ссылки на источник. Все права на пользовательские
            картинки и тексты принадлежат их авторам. Сайт предназначен для лиц старше 16 лет.</div>
        <ul class="footer__list footer__list--style-2">
            <li class="footer__li footer__li--style-2"><a href="<?=$this->createUrl('/pages/default/page', array('view' => 'confidential'))?>" class="footer__link footer__link--color-2">Политика конфеденциальности</a></li>
            <?php if ($this->route != 'archive/default/map'): ?>
            	<li class="footer__li footer__li--style-2"><a href="<?=$this->createUrl('/archive/default/map')?>" class="footer__link footer__link--color-2">Карта сайта</a></li>
        	<?php endif; ?>
        </ul>
    </div>
</footer>