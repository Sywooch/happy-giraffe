<?php
/**
 * @var LiteController $this
 */
$this->beginContent('//layouts/lite/common');
?>
<div class="layout-loose_hold clearfix">
<!-- b-main -->
<div class="b-main clearfix">
    <?php if (!Yii::app()->user->isGuest && !($this instanceof LiteController && $this->hideUserAdd)): ?>
        <div class="b-main_cols clearfix">
            <div class="b-main_col-1">
                <div class="sidebar-search clearfix sidebar-search__big">
                    <?php $this->widget('site.frontend.modules.search.widgets.YaSearchWidget'); ?>
                </div>
            </div>
            <div class="b-main_col-23">
                <!-- userAddRecord-->
                <div class="userAddRecord clearfix userAddRecord__s userAddRecord__s">
                    <div class="userAddRecord_ava-hold">
                        <?php $this->widget('Avatar', array('user' => Yii::app()->user->getModel(), 'size' => Avatar::SIZE_SMALL)); ?>
                    </div>
                    <div class="userAddRecord_hold">
                        <div class="userAddRecord_tx">Я хочу добавить
                        </div>
                        <a href="<?= $this->createUrl('/blog/default/form', array('type' => CommunityContent::TYPE_POST, 'useAMD' => true)) ?>" data-theme="transparent" title="Статью" class="userAddRecord_ico userAddRecord_ico__article fancy powertip"></a>
                        <a href="<?= $this->createUrl('/blog/default/form', array('type' => CommunityContent::TYPE_PHOTO_POST, 'useAMD' => true)) ?>" data-theme="transparent" title="Фото" class="userAddRecord_ico userAddRecord_ico__photo fancy powertip"></a>
                        <a href="<?= $this->createUrl('/blog/default/form', array('type' => CommunityContent::TYPE_VIDEO, 'useAMD' => true)) ?>" data-theme="transparent" title="Видео" class="userAddRecord_ico userAddRecord_ico__video fancy powertip"></a>
                        <a href="<?= $this->createUrl('/blog/default/form', array('type' => CommunityContent::TYPE_STATUS, 'useAMD' => true)) ?>" data-theme="transparent" title="Статус" class="userAddRecord_ico userAddRecord_ico__status fancy powertip"></a>
                    </div>
                </div>
                <!-- /userAddRecord-->
            </div>
        </div>
    <?php endif; ?>
    <div class="b-main_cont b-main_cont__broad">
        <?php if ($this->breadcrumbs): ?>
            <div class="b-crumbs b-crumbs__s">
                <div class="b-crumbs_tx">Я здесь:</div>
                <?php
                $this->widget('\site\frontend\components\lite\UserBreadcrumbs', array(
                    'user' => $this->owner,
                    'tagName' => 'ul',
                    'separator' => ' ',
                    'htmlOptions' => array('class' => 'b-crumbs_ul'),
                    'homeLink' => '<li class="b-crumbs_li"><a href="' . $this->createUrl('/site/index') . '" class="b-crumbs_a">Главная </a></li>',
                    'activeLinkTemplate' => '<li class="b-crumbs_li"><a href="{url}" class="b-crumbs_a">{label}</a></li>',
                    'inactiveLinkTemplate' => '<li class="b-crumbs_li b-crumbs_li__last"><span class="b-crumbs_last">{label}</span></li>',
                    'links' => $this->breadcrumbs,
                    'encodeLabel' => false,
                ));
                ?>
            </div>
        <?php endif; ?>
    </div>
    <?= $content ?>
</div>
<!-- b-main -->

<?php $this->renderPartial('//_footer'); ?>

<?php if (false): ?>
<!-- Old version -->
<!-- layout-footer-->
<div class="layout-footer clearfix">
    <div class="layout-footer_hold">
        <ul class="footer-list">
            <li class="footer-list_li visible-md-inline-block"><span class="footer-list_a">О нас</span></li>
            <li class="footer-list_li"><span class="footer-list_a">Правила сайта</span></li>
            <li class="footer-list_li"><a href="<?= $this->createUrl('/site/page', array('view' => 'abuse')) ?>" class="footer-list_a">Правообладателям</a></li>
            <li class="footer-list_li"><a href="<?= $this->createUrl('/site/page', array('view' => 'advertiser')) ?>" class="footer-list_a footer-list__reklama">Реклама </a></li>
            <li class="footer-list_li"><span class="footer-list_a">Контакты </span></li>
            <!-- <li class="footer-list_li footer-list_li__rambler visible-md-inline-block"><a href="http://www.rambler.ru" class="footer-list_a">Партнер "Рамблера"</a><span id="counter-rambler" class="footer-list_rambler-count"><a href="http://top100.rambler.ru/home?id=2900190" target="_blank"><img src="http://counter.rambler.ru/top100.scn?2892367&amp;rn=1382511841&amp;v=0.3&amp;bs=1680x983&amp;ce=1&amp;rf=http%3A%2F%2Fwww.happy-giraffe.ru%2Fmy%2F&amp;en=UTF-8&amp;pt=%D0%92%D0%B5%D1%81%D0%B5%D0%BB%D1%8B%D0%B9%20%D0%96%D0%B8%D1%80%D0%B0%D1%84%20-%20%D1%81%D0%B0%D0%B9%D1%82%20%D0%B4%D0%BB%D1%8F%20%D0%B2%D1%81%D0%B5%D0%B9%20%D1%81%D0%B5%D0%BC%D1%8C%D0%B8&amp;cd=32-bit&amp;sr=1680x1050&amp;la=ru&amp;ja=1&amp;acn=Mozilla&amp;an=Netscape&amp;pl=Win32&amp;tz=-120&amp;fv=12.0%20r0&amp;sv&amp;le=0" title="Rambler&quot;s Top100" alt="Rambler&quot;s Top100" ></a></span></li> -->
        </ul>
        <ul class="footer-menu visible-md">
            <li class="footer-menu_li"><a href="<?= $this->createUrl('/community/default/section', array('section_id' => 1)) ?>" class="footer-menu_a footer-menu_a__pregnancy">Беременность и дети</a></li>
            <li class="footer-menu_li"><a href="<?= $this->createUrl('/community/default/section', array('section_id' => 2)) ?>" class="footer-menu_a footer-menu_a__home">Наш дом</a></li>
            <li class="footer-menu_li"><a href="<?= $this->createUrl('/community/default/section', array('section_id' => 3)) ?>" class="footer-menu_a footer-menu_a__beauty">Красота и здоровье</a></li>
            <li class="footer-menu_li"><a href="<?= $this->createUrl('/community/default/section', array('section_id' => 4)) ?>" class="footer-menu_a footer-menu_a__husband-and-wife">Муж и жена</a></li>
            <li class="footer-menu_li"><a href="<?= $this->createUrl('/community/default/section', array('section_id' => 5)) ?>" class="footer-menu_a footer-menu_a__hobby">Интересы и увлечения</a></li>
            <li class="footer-menu_li"><a href="<?= $this->createUrl('/community/default/section', array('section_id' => 6)) ?>" class="footer-menu_a footer-menu_a__family-holiday">Семейный отдых</a></li>
        </ul>
        <div class="layout-footer_tx">© 2012–2014 Веселый Жираф. Социальная сеть для всей семьи. Использование редакционных материалов happy-giraffe.ru возможно только с письменного разрешения редакции и/или при наличии активной ссылки на источник. Все права на пользовательские картинки и тексты принадлежат их авторам. Сайт предназначен для лиц старше 16 лет.</div>
        <div class="layout-footer_privacy-hold"><span class="layout-footer_privacy">Политика конфедициальности</span><?php if ($this->route != 'archive/default/map'): ?><a href="<?= $this->createUrl('/archive/default/map') ?>" class="layout-footer_privacy">Карта сайта</a><?php endif; ?></div>
    </div>
</div>
<!-- /layout-footer-->
<?php endif; ?>
</div>
<?php $this->endContent(); ?>