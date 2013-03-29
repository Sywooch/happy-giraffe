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
            
            <div class="task-add clearfix textalign-c">
                <a href="" class="btn-green btn-big">Добавить задачу</a>
            </div>
            
            <div class="task-add clearfix">
                <div class="task-act inactive">
                    <div class="task-act_t">Что сделать?</div>
                    <a href="" class="task-act_i">
                        <span class="task-act_ico-hold">
                            <span class="task-act_ico task-act_ico__comment"></span>
                        </span>
                        <span class="task-act_tx">Добавить <br> коммент</span>
                    </a>
                    <div class="task-act_or"></div>
                    
                    <a href="" class="task-act_i">
                        <span class="task-act_ico-hold">
                            <span class="task-act_ico task-act_ico__like"></span>
                        </span>
                        <span class="task-act_tx">Поставить <br> лайк</span>
                    </a>
                </div>
                <div class="task-add_itx-hold">
                    <input type="text" placeholder="Введите ссылку на страницу" class="itx-bluelight task-add_itx" id="" name="">
                    <button class="task-add_btn btn-green">Ok</button>
                </div>
            </div>
            
            <div class="task-add clearfix">
                <div class="task-act">
                    <div class="task-act_t">Что сделать?</div>
                    <a href="" class="task-act_i">
                        <span class="task-act_ico-hold">
                            <span class="task-act_ico task-act_ico__comment"></span>
                        </span>
                        <span class="task-act_tx">Добавить <br> коммент</span>
                    </a>
                    <div class="task-act_or"></div>
                    
                    <a href="" class="task-act_i">
                        <span class="task-act_ico-hold">
                            <span class="task-act_ico task-act_ico__like"></span>
                        </span>
                        <span class="task-act_tx">Поставить <br> лайк</span>
                    </a>
                </div>
                <div class="task-add_itx-hold">
                    <span class="task-add_a-hold">
                        <a href="" class="task-add_a">Путешественники во времени и пространстве, присаживайтесь за свободный столик во времени и пространстве, присаживайтесь за свободный столик</a>
                        <a href="" class="task-add_close"></a>
                    </span>
                </div>
            </div>
            
            <div class="task-tb">
                <div class="margin-b10">
                    <div class="b-date">2 МАРТА 2013</div>
                </div>
                <table class="task-tb_tb">
                    <tr>
                        <td class="task-tb_td-ico">
                            <div class="task-tb_ico task-tb_ico__like"></div>
                        </td>
                        <td class="task-tb_td-a">
                            <a href="">Путешественники во времени и пространстве, присаживайтесь за свободный столик</a>
                        </td>
                        <td class="task-tb_playerbar">
                            <div class="task-tb_playerbar task-tb_playerbar__play"></div>
                        </td>
                        <td class="task-tb_td-count">
                            <a href="" class="task-tb_count color-alizarin">38</a> 
                            |
                            <a href="" class="task-tb_count color-green">19</a> 
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
