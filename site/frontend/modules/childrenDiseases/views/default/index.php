<?php Yii::app()->clientScript->registerScript('children-dizzy', "
        $('#disease-alphabet2 a').click(function () {
            if (!$(this).hasClass('current_t')) {
                $('#category-list').hide();
                $('#alphabet-list').show();
                $('.sortable_u li').removeClass('current_t');
                $(this).parent('li').addClass('current_t');
            }
            return false;
        });

        $('#disease-type2 a').click(function () {
            if (!$(this).hasClass('current_t')) {
                $('#category-list').show();
                $('#alphabet-list').hide();
                $('.sortable_u li').removeClass('current_t');
                $(this).parent('li').addClass('current_t');
            }
            return false;
        });
"); ?>
<div class="handbook_alfa">
    <span class="handbook_title">Выберите болезнь</span>
    <ul class="sortable_u">
        <li id="disease-alphabet2" class="current_t"><a href="#"><span>По алфавиту</span></a></li>
        <li>|</li>
        <li id="disease-type2"><a href="#"><span>По типу заболевания</span></a></li>
    </ul>
    <div class="clear"></div>
    <!-- .clear -->
    <div id="alphabet-list" class="handbook_multi">
        <?php foreach ($alphabetList as $letter => $diseases): ?>
        <ul class="handbook_list">
            <li><span><?php echo strtoupper($letter) ?></span></li>
            <?php foreach ($diseases as $disease): ?>
            <li><a
                href="<?php echo $this->createUrl('/childrenDiseases/default/view', array('url' => $disease->slug)) ?>"><?php
                echo $disease->name ?></a></li>
            <?php endforeach; ?>
        </ul>
        <?php endforeach; ?>
    </div>
    <!-- .handbook_multi -->

    <div id="category-list" class="handbook_multi" style="display: none;">
        <?php foreach ($categoryList as $category => $diseases): ?>
        <ul class="handbook_list">
            <li><span><?php echo strtoupper($category) ?></span></li>
            <?php foreach ($diseases as $disease): ?>
            <li><a
                href="<?php echo $this->createUrl('/childrenDiseases/default/view', array('url' => $disease->slug)) ?>"><?php
                echo $disease->name ?></a></li>
            <?php endforeach; ?>
        </ul>
        <?php endforeach; ?>
    </div>
    <!-- .handbook_multi -->

</div><!-- .handbook_alfa -->
<div class="seo-text">
    <h1 class="summary-title">Справочник детских болезней</h1>

    <p>Существует такой термин – «детские болезни». Раз он есть, значит, заболевания, которые выпадают на долю наших
        деток, особенные.</p>

    <p>Детский организм работает совсем иначе, нежели взрослый. Посмотрите хотя бы на то, как много детки двигаются – и
        не устают. Взрослый бы при таких обстоятельствах не выдержал. Как много дети успевают за день – и запоминают
        все, а взрослый бы забыл. Как быстро дети растут, наконец! Все это – благодаря способностям, которыми их
        организм наделила природа. У нас, у взрослых, этого уже нет. А потому думать, что дети – это маленькие взрослые,
        ошибочно. Например, есть некоторые болезни, которыми не заболеют взрослые, но дети могут быть им подвержены.</p>

    <p>Какие это болезни? Про некоторые мы знаем: скарлатина, ветрянка, коклюш, краснуха. Но и ангина, и бронхит, и
        гастрит тоже бывают детскими, т.е. отличными от взрослых. И лечат их не взрослыми средствами, а методами и
        лекарствами, предназначенными для детей.</p>

    <p>Диагностика детских болезней сложна. Детки реагируют на болячки по-разному, поэтому описать яркие симптомы как
        присущие только одной болезни, невозможно. Например, обычная простуда может у одного ребенка вызвать только боль
        в горле, а у другого – еще и аллергию, понос и сыпь. И определить, что есть что, очень сложно.</p>

    <p>Конечно, если ребенок заболел, надо звать врача. Но бывают разные ситуации, поэтому родителям стоит владеть
        информацией о детских болезнях. Именно с этой целью мы создали сервис – Справочник детских болезней. Пусть он
        будет в ваших закладках, чтобы при необходимости оказаться вам полезным. Информация о заболевании, его причинах,
        симптомах дается в удобной и понятной форме, также есть рекомендации по лечению и профилактике.</p>

    <p>Мы не призываем самостоятельно диагностировать и лечить болезни ваших детей. В любом случае старайтесь обращаться
        к врачу. Но знание симптомов болезней своего ребенка поможет вам составить его анамнез, т.е. историю здоровья, а
        это очень пригодится в будущем.</p>

    <p>Мы надеемся, что наш сервис поможет вам вовремя «ловить» начальные симптомы болезней, быстро реагировать и тем
        самым сводить к минимуму опасность осложнений и значительно сокращать время лечения.</p>

    <p><i>Будьте во всеоружии – владейте информацией! И будьте здоровы!</i></p>

    <p class="notice">Внимание! Все публикации на портале «Веселый жираф» носят ознакомительный характер. Советы и
        рекомендации, размещенные на сайте, помогают узнать больше об интересующей вас проблеме, но ни в коем случае не
        заменяют очной консультации врача.</p>
</div>