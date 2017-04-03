
<!-- layout-footer-->
<div class="layout-footer clearfix">
    <div class="layout-footer_hold">
        <ul class="footer-list">
            <li class="footer-list_li visible-md-inline-block"><a href="<?=$this->createUrl('/pages/default/page', array('view' => 'about'))?>" class="footer-list_a">О нас</a></li>
            <li class="footer-list_li"><a href="<?=$this->createUrl('/pages/default/page', array('view' => 'useragreement'))?>" class="footer-list_a">Правила сайта</a></li>
            <li class="footer-list_li"><a href="<?=$this->createUrl('/pages/default/page', array('view' => 'legal'))?>" class="footer-list_a">Правообладателям</a></li>
            <li class="footer-list_li"><a href="<?=$this->createUrl('/pages/default/page', array('view' => 'advertising'))?>" class="footer-list_a footer-list__reklama">Реклама </a></li>
            <li class="footer-list_li"><a href="<?=$this->createUrl('/pages/default/page', array('view' => 'contacts'))?>" class="footer-list_a">Контакты </a></li>
        </ul>
        <div class="layout-footer_tx margin-b5">ИП Гаврилина Елена Владимировна, ИНН 771471845300</div>
        <div class="layout-footer_tx">© 2012–<?php echo date('Y'); ?> Веселый Жираф. Социальная сеть для всей семьи. Использование редакционных материалов happy-giraffe.ru возможно только с письменного разрешения редакции и/или при наличии активной ссылки на источник. Все права на пользовательские картинки и тексты принадлежат их авторам. Сайт предназначен для лиц старше 16 лет.</div>
        <span class="layout-footer_tx">Политики конфиденциальности:
            <a href="<?=$this->createUrl('/pages/default/page', array('view' => 'confidential'))?>" class="layout-footer_privacy">Веселый Жираф,</a>
            <a href="<?=$this->createUrl('/pages/default/page', array('view' => 'mypediatrician/privacypolicy'))?>" class="layout-footer_privacy">Мой педиатр,</a>
            <a href="<?=$this->createUrl('/pages/default/page', array('view' => 'pediatrician/privacypolicy'))?>" class="layout-footer_privacy">Жираф.Педиатр</a> |
        </span>
        <?php if ($this->route != 'archive/default/map'): ?><a href="<?=$this->createUrl('/archive/default/map')?>" class="layout-footer_privacy">Карта сайта</a><?php endif; ?></div>
    </div>
</div>
<!-- /layout-footer-->
