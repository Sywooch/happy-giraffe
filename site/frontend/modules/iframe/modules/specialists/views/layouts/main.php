<?php
/**
 * @var $this site\frontend\modules\iframe\controllers\DefaultController
 * @var string $content
 */

$this->beginContent('application.modules.iframe.views._parts.main');
?>
<style>
    .b-main-iframe{
        padding-top: 0;
    }
    .b-main-iframe .b-main__inner{
        padding: 0;
    }
    .userSection-iframe {
        margin: 0;
    }
    .userSection-iframe_left{
        width: 210px;
    }
    .userSection-iframe_name{
        font-size: 32px;
    }
    .userSection-iframe_right{
        float: right;
        display: block;
        width: 300px;
        text-align: center;
        padding-top: 40px;
    }
    .userSection-iframe-stat{
        display: table;
        width: 100%;
        margin-top: 20px;
    }
    .userSection-iframe-stat>li{
        display: table-cell;
        text-align: center;
    }
    .userSection-iframe-stat>li:last-child{
        width: 100%;
    }
    .userSection-iframe-stat_count{
        font-size: 24px;
        font-weight: 600;
        color: #FFFFFF;
        margin-bottom: 10px;
        line-height: 1;
    }
    .userSection-iframe-stat_desc{
        font-size: 14px;
        color: #ffffff;
        opacity: 0.6;
    }
    .userSection-iframe-info{
        margin-bottom: 10px;
    }
    .userSection-iframe-info_opacity{
        color: #ffffff;
        font-size: 14px;
        opacity: 0.6;
    }
    .userSection-iframe-info_bold {
        color: #ffffff;
        font-size: 14px;
        font-weight: 600;
    }
    .userSection-iframe-info_orange{
        font-size: 14px;
        color: #ee809b;
        font-weight: 600;
    }
</style>
<div class="b-col__container">
    <?=$content?>
</div>
<?php $this->endContent(); ?>