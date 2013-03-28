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
        
        <div class="nav-hor nav-hor__2 clearfix">
            <ul class="nav-hor_ul">
                <li class="nav-hor_li">
                    <a href="" class="nav-hor_i">
                        <span class="nav-hor_tx">Моя премия</span>
                    </a>
                </li>
                <li class="nav-hor_li active">
                    <a href="" class="nav-hor_i">
                        <span class="nav-hor_tx">Рейтинги</span>
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="block">

            <?php include $path.'/html/seo2/include/month-list.php'; ?>
            
            <div class="award-me-table">
                <table class="award-me-table_tb">
                    <tr>
                        <th>Место </th>
                        <th>Новые <br> друзья </th>
                        <th>Просмотры <br> анкеты  </th>
                        <th>Личная <br> переписка </th>
                        <th>Поисковые <br> системы</th>
                    </tr>
                    <tr class="award-me-table_odd">
                        <td class="award-me-table_td-place">
                            <div class="win-place-2 win-place-2__1"></div>
                        </td>
                        <td class="award-me-table_td-friend">200</td>
                        <td class="award-me-table_td-profile">2690</td>
                        <td class="award-me-table_td-message">56800</td>
                        <td class="award-me-table_td-search">96300</td>
                    </tr>
                    <tr>
                        <td class="award-me-table_td-place">
                            <div class="win-place-2 win-place-2__2"></div>
                        </td>
                        <td class="award-me-table_td-friend">20770</td>
                        <td class="award-me-table_td-profile">2690</td>
                        <td class="award-me-table_td-message">56800</td>
                        <td class="award-me-table_td-search">96300</td>
                    </tr>
                    <tr class="award-me-table_odd">
                        <td class="award-me-table_td-place">
                            <div class="win-place-2 win-place-2__3"></div>
                        </td>
                        <td class="award-me-table_td-friend active">20</td>
                        <td class="award-me-table_td-profile">2690</td>
                        <td class="award-me-table_td-message">5</td>
                        <td class="award-me-table_td-search">967300</td>
                    </tr>
                    <tr>
                        <td class="award-me-table_td-place">
                            4
                        </td>
                        <td class="award-me-table_td-friend">99200</td>
                        <td class="award-me-table_td-profile">2690</td>
                        <td class="award-me-table_td-message active">56800</td>
                        <td class="award-me-table_td-search">96300</td>
                    </tr>
                    <tr class="award-me-table_odd">
                        <td class="award-me-table_td-place">
                            5
                        </td>
                        <td class="award-me-table_td-friend">99200</td>
                        <td class="award-me-table_td-profile">2690</td>
                        <td class="award-me-table_td-message">56800</td>
                        <td class="award-me-table_td-search">96300</td>
                    </tr>
                    <tr>
                        <td class="award-me-table_td-place">
                            6
                        </td>
                        <td class="award-me-table_td-friend">99200</td>
                        <td class="award-me-table_td-profile">2690</td>
                        <td class="award-me-table_td-message">56800</td>
                        <td class="award-me-table_td-search">96300</td>
                    </tr>
                    <tr class="award-me-table_odd">
                        <td class="award-me-table_td-place">
                            7
                        </td>
                        <td class="award-me-table_td-friend">456</td>
                        <td class="award-me-table_td-profile">222</td>
                        <td class="award-me-table_td-message">5</td>
                        <td class="award-me-table_td-search">45</td>
                    </tr>
                </table>
                <div class="report-legend">
                    <div class="report-legend_i">
                        <img class="report-legend_img" alt="" src="/images/seo2/ico/award-place-tb.png"> -  ваше место в общем рейтинге
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>      
<?php include $path.'/html/seo2/include/footer.php'; ?>


</body>
</html>
