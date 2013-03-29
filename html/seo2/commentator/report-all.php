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
        <?php include $path.'/html/seo2/include/commentator-header.php'; ?>
        
        <div class="block">

            <?php include $path.'/html/seo2/include/month-list.php'; ?>
            
            <div class="report report__center">
                <table class="report_table">
                    <tr>
                        <th>
                            Комментаторы
                        </th>
                        <th>
                            Записей в блог
                        </th>
                        <th>
                            Записей в клуб
                        </th>
                        <th>
                            Комментариев
                        </th>
                        <th>
                            План
                        </th>
                    </tr>
                    <tr class="report_odd">
                        <td class="report_td-user">
                            <div class="user-info clearfix">
                                <a href="" class="ava small"></a>
                                <div class="user-info_details">
                                    <a href="" class="user-info_username">Аллахвердиева Зульфия</a>
                                </div>
                            </div>
                        </td>
                        <td class="report_td-count">
                            <div class="report_count">68654</div>
                            <div class="report_precent color-green">
                                <!-- 
                                    Выполнено    - blog-green-small.png
                                    Не выполнено - blog-red-small.png
                                  -->
                                <img src="/images/seo2/ico/blog-green-small.png" alt="" class="report_count-ico">
                                120%
                            </div>
                        </td>
                        
                        <td class="report_td-count">
                            <div class="report_count">68654</div>
                            <div class="report_precent color-green">
                                <img src="/images/seo2/ico/club-green-small.png" alt="" class="report_count-ico">
                                120%
                            </div>
                        </td>
                        <td class="report_td-count">
                            <img src="/images/seo2/ico/comment-green-small.png" alt="" class="report_count-ico">
                            <div class="report_count">566654</div>
                        </td>
                        <td class="report_td-status">
                            <div class="report_status color-green">Выполнен</div>
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
