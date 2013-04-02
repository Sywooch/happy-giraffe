<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js"> <!--<![endif]-->
<head>

    <?php 
    $path = $_SERVER['DOCUMENT_ROOT'];
    include $path.'/html/seo2/include/head.php'; ?>
    
</head>
<body >
<div class="layout-page">
    <div class="layout-page_w1">
        <?php include $path.'/html/seo2/include/community-header.php'; ?>

        <div class="block">
            <?php include $path.'/html/seo2/include/month-list.php'; ?>
            
            <div class="external-link-add">
                <input type="text" name="" id="" class="itx-bluelight external-link-add_itx" placeholder="Где проставлена ссылка">
                <div class="external-link-add_ico"></div>
                <input type="text" name="" id="" class="itx-bluelight external-link-add_itx" placeholder="Моя запись на Веселом Жирафе">
                <button class="external-link-add_btn btn-green">Ok</button>
            </div>
            
            <table class="external-link">
                <tr class="external-link_odd">
                    <td class="external-link_td-date">
                        <div class="b-date">2 МАРТА 2013</div>
                    </td>
                    <td class="external-link_td-outer">
                        <a href="" class="external-link_outer">http://www.towave.ru/pub/klyuchevyetrendyrynkaposevnykhinvestitsiivrossii.html</a>
                    </td>
                    <td class="external-link_td-count">
                        <div class="external-link_count">654</div>
                    </td>
                    <td class="external-link_td-inner">
                        <a href="" class="external-link_inner">Путешественники во времени и пространстве, присаживайтесь за свободный столик</a>
                    </td>
                    <td class="external-link_td-close"><a href="" class="external-link_close"></a></td>
                </tr>
                <tr class="">
                    <td class="external-link_td-date">
                        <div class="b-date">2 МАРТА 2013</div>
                    </td>
                    <td class="external-link_td-outer">
                        <a href="" class="external-link_outer">http://towave.ru/pub/klyuchevye-</a>
                    </td>
                    <td class="external-link_td-count">
                        <div class="external-link_count">4</div>
                    </td>
                    <td class="external-link_td-inner">
                        <a href="" class="external-link_inner">Путешественникивовремениипространстве,присаживайтесьзасвободныйстолик</a>
                    </td>
                    <td class="external-link_td-close"><a href="" class="external-link_close"></a></td>
                </tr>
                <tr class="external-link_odd">
                    <td class="external-link_td-date">
                        <div class="b-date">2 МАРТА 2013</div>
                    </td>
                    <td class="external-link_td-outer">
                        <a href="" class="external-link_outer">http://www.towave.ru/pub/klyuchevye-trendy-rynka- posevnykh-investitsii-v-rossii.html</a>
                    </td>
                    <td class="external-link_td-count">
                        <div class="external-link_count">96654</div>
                    </td>
                    <td class="external-link_td-inner">
                        <a href="" class="external-link_inner">Путешественники во времени</a>
                    </td>
                    <td class="external-link_td-close"><a href="" class="external-link_close"></a></td>
                </tr>
            </table>
        </div>

    </div>
</div>      
<?php include $path.'/html/seo2/include/footer.php'; ?>


</body>
</html>
