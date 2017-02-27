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
        <div class="notice-header__title">Семья</div>
    </div>
    <div class="notice-header__item notice-header__item--right"><a href="javascript:history.back();" class="notice-header__ico-close i-close i-close--sm"></a></div>
</div>

<div class="b-main_cont b-main_cont__wide">
    <div class="family-user family-user__think">
        <!-- cap-empty-->
        <div class="cap-empty cap-empty__profile-family">
            <div class="cap-empty_hold">
                <div class="cap-empty_img cap-empty_img__family-big"></div>
                <div class="cap-empty_t">У вас не заполнена информация о вашей семье</div>
                <div class="cap-empty_tx-sub"><a href='<?=$this->createUrl('/family/default/fill', array('userId' => $userId))?>' class='btn btn-success btn-xm'>Заполнить</a></div>
            </div>
        </div>
        <!-- /cap-empty-->
    </div>
</div>