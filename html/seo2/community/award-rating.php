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
                    <tr>
                        <td>
                            <div class="win-place-2 win-place-2__1"></div>
                        </td>
                        <td>200</td>
                    </tr>
                </table>
            </div>
            
            <div class="award-me clearfix">
                <div class="award-me_i award-me_i__1">
                    <div class="award-me_t">Новые <br>друзья</div>
                    <div class="award-me_value">785</div>
                    <div class="award-me_place">
                        <div class="award-me_place-value">222</div>
                        <div class="award-me_place-tx">место</div>
                    </div>
                    <div class="award-me_desc">
                        <div class="ico-info"></div> <br>
                        <a href="">Как завести наиболшее количество дружеских связей (болше всего друзей на сайте)</a>
                    </div>
                </div>
                <div class="award-me_i award-me_i__2 win">
                    <div class="award-me_t">Просмотры <br> анкеты</div>
                    <div class="award-me_value">5</div>
                    <div class="award-me_place">
                        <div class="win-place win-place__1"></div>
                    </div>
                    <div class="award-me_desc">
                        <div class="ico-info"></div> <br>
                        <a href="">Как сделать личную страницу, включая блог и фотогалерею, наиболее посещаемой по количеству просмотров</a>
                    </div>
                </div>
                <div class="award-me_i award-me_i__3 win">
                    <div class="award-me_t">Личная <br> переписка</div>
                    <div class="award-me_value">56543</div>
                    <div class="award-me_place">
                        <div class="win-place win-place__2"></div>
                    </div>
                    <div class="award-me_desc">
                        <div class="ico-info"></div> <br>
                        <a href="">Самый коммуникабельный сотрудник (тот , кто больше всего отправил сообщений по внутренней почте) - входящие и исходящие сообщения</a>
                    </div>
                </div>
                <div class="award-me_i award-me_i__4 win">
                    <div class="award-me_t">Поисковые <br>системы</div>
                    <div class="award-me_value">5546</div>
                    <div class="award-me_place">
                        <div class="win-place win-place__3"></div>
                    </div>
                    <div class="award-me_desc">
                        <div class="ico-info"></div> <br>
                        <a href="">Как писать посты, которые приведут на сайт наибольшее количество людей из поисковиков (блог и записи в клубах)</a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>      
<?php include $path.'/html/seo2/include/footer.php'; ?>


</body>
</html>
