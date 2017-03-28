<?php

$this->beginContent('application.modules.iframe.views._parts.main');
?>
    <style>
        .b-main-iframe{
            position: initial;
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
        .b-pediator-iframe{
            padding: 40px 34px;
            padding-bottom: 0;
        }
        .userSection-iframe-stat_thanks{
            display: inline-block;
            vertical-align: sub;
            background: url("/app/builds/static/img/assets/user-box/flover.svg") left top;
            background-size: auto 15px;
            background-repeat: no-repeat;
            width: 7px;
            height: 15px;
        }
        .b-family-iframe_top{
            font-size: 15px;
            text-align: center;
        }
        .padding-iframe-container{
            padding: 35px;
            padding-bottom: 135px;
        }
        .b-pediatrician-list-item{
            display: block;
            float: left;
            width: 33.33%;
            height: 370px;
            padding: 30px 50px;
            padding-bottom: 0;
        }
        .b-pediatrician-list-item_ava{
            display: block;
            margin: 0 auto;
            margin-bottom: 10px;
            border-radius: 200px;
            height: 200px;
            width: 200px;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
        .b-pediatrician-list-item_link{
            display: block;
            text-align: center;
        }
        .b-pediatrician-list-item_name{
            font-size: 12px;
        }
        .b-pediatrician-list-item_orange{
            font-size: 12px;
            color: #ee809b;
        }
        .b-pediatrician-list-item_city{
            font-size: 12px;
            color: rgba(0,0,0,0.42);
        }
        .b-pediatrician-list-item_box{
            display: table;
            width: 100%;
            margin-top: 15px;
        }
        .b-pediatrician-list-item_cell{
            display: table-cell;
        }
        .b-pediatrician-list-item_count{
            font-size: 24px;
            color: #000000;
            display: block;
        }
        .b-pediatrician-list-item_gray{
            display: block;
            font-size: 14px;
            color: rgba(0,0,0,0.6);
        }
        .b-pediatrician-list-item_gray .b-answer-header-box__ico{
            margin-right: -3px;
        }
    </style>
    <div class="b-col__container">
        <div class="padding-iframe-container">
            <?=$content?>
        </div>
    </div>
<?php $this->endContent(); ?>