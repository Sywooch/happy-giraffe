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
        
        <?php include $path.'/html/seo2/include/community-nav-hor.php'; ?>
        
        <div class="block">
            
            <?php include $path.'/html/seo2/include/month-list.php'; ?>
            
            <div class="visits-row">
                <div class="visits-filter">
                    <a href="" class="visits-filter_i">по дате</a>
                    <a href="" class="visits-filter_i active">по трафику</a>
                </div>
                <div class="visits-row_t">
                    Общее количество заходов  
                    <div class="visits-row_count">5687</div>
                </div>
            </div>
            
            <table class="visits-table">
                <tr class="visits-table_odd">
                    <td class="visits-table_td-link" colspan="2">
                        <a href="">Укажите интересующие параметры и нажмите кнопку «Подобрать» Нажмите кнопку «Подписаться» внизу страницы с объявлениями </a>
                    </td>
                    <td class="visits-table_td-count">
                        <div class="visits-table_count visits-table_count__blue">68654</div>
                    </td>
                </tr>
                <tr class="">
                    <td class="visits-table_td-link" colspan="2">
                        <a href="">Укажите интересующие Нажмите кнопку «Подписаться» внизу страницы с объявлениями </a>
                    </td>
                    <td class="visits-table_td-count">
                        <div class="visits-table_count visits-table_count__blue">78944</div>
                    </td>
                </tr>
                <tr class="visits-table_odd">
                    <td class="visits-table_td-link" colspan="2">
                        <a href="">страницы с объявлениями </a>
                    </td>
                    <td class="visits-table_td-count">
                        <div class="visits-table_count visits-table_count__blue">62344</div>
                    </td>
                </tr>
                <tr class="">
                    <td class="visits-table_td-link" colspan="2">
                        <a href="">Укажите интересующие параметры и нажмите кнопку «Подобрать» Нажмите кнопку «Подписаться» внизу страницы с объявлениями интересующие параметры и нажмите кнопку «Подобрать» Нажмите кнопку «Подписаться» внизу страницы с объявлениями </a>
                    </td>
                    <td class="visits-table_td-count">
                        <div class="visits-table_count visits-table_count__blue">62</div>
                    </td>
                </tr>
            </table>
            </div>
        </div>

    </div>
</div>      
<?php include $path.'/html/seo2/include/footer.php'; ?>


</body>
</html>
