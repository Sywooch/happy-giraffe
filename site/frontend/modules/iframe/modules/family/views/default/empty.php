<?php
/**
 * @var LiteController $this
 * @var integer $userId
 */
$this->pageTitle = 'Моя семья';
$this->breadcrumbs = array(
    'Семья',
);
?>

<div class="notice-header clearfix notice-header--dialog">
    <div class="notice-header__item notice-header__item--left">
        <div class="notice-header__title"><span class="notice-header-kids__icon"></span> Мои дети</div>
    </div>
    <div class="notice-header__item notice-header__item--right"><a href="javascript:history.back();" class="notice-header__ico-close i-close i-close--sm"></a></div>
</div>

<div class="b-main_cont b-main_cont__wide">
    <div class="family-user family-user__think">
        <!-- cap-empty-->
        <div class="cap-empty cap-empty__profile-family">
            <div class="cap-empty_hold">
                <div class="notice-header-kids__icon-big"></div>
                <div class="cap-empty-iframe_t">Нет информации о детях</div>
                <div class="cap-empty-ifram_tx-sub"><a href='<?=$this->createUrl('/iframe/family/default/fill', array('userId' => $userId))?>' class='btn btn-success btn-xm'>Добавить ребенка</a></div>
            </div>
        </div>
        <!-- /cap-empty-->
    </div>
</div>