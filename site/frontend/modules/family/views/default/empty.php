<?php
/**
 * @var LiteController $this
 * @var integer $userId
 */
$this->pageTitle = 'Моя семья';
?>

<div class="b-main_cont b-main_cont__wide">
    <div class="family-user family-user__think">
        <div class="textalign-c">
            <div class="ico-myfamily ico-myfamily__l"></div>
        </div>
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