<?php
/**
 * @var LiteController $this
 */
$this->beginContent('//layouts/lite/common');
?>

<div class="layout-header">
    <!-- header -->
    <header class="header header__homepage">
        <div class="header_hold">
            <div class="header_row-home">
                <!-- logo-->
                <div class="logo logo__l"><a title="Веселый жираф - сайт для всей семьи" href="<?=$this->createUrl('/site/index')?>" class="logo_i">Веселый жираф - сайт для всей семьи</a><span class="logo_slogan">САЙТ ДЛЯ ВСЕЙ СЕМЬИ</span></div>
                <!-- /logo-->
            </div>
        </div>
        <div class="info-menu">
            <?php
                $this->widget('zii.widgets.CMenu', array(
                    'htmlOptions' => array(
                        'class' => 'info-menu-list',
                    ),
                    'itemCssClass' => 'info-menu-item',
                    'items' => array(
                        array(
                            'label' => 'О нас',
                            'url' => array('/pages/default/page', 'view' => 'about'),
                            'linkOptions' => array('class' => 'info-menu-link'),
                        ),
                        array(
                            'label' => 'Правила сайта',
                            'url' => array('/pages/default/page', 'view' => 'useragreement'),
                            'linkOptions' => array('class' => 'info-menu-link'),
                        ),
                        array(
                            'label' => 'Реклама',
                            'url' => array('/pages/default/page', 'view' => 'ad'),
                            'linkOptions' => array('class' => 'info-menu-link'),
                        ),
                        array(
                            'label' => 'Контакты',
                            'url' => array('/pages/default/page', 'view' => 'contacts'),
                            'linkOptions' => array('class' => 'info-menu-link'),
                        ),
                    ),
                ));
            ?>
        </div>
    </header>
</div>

<div class="layout-loose_hold clearfix">
    <?=$content?>
    <?php $this->renderPartial('//_footer'); ?>
</div>

<?php $this->endContent(); ?>