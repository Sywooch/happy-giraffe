<?php
/* @var $this Controller
 * @var $categories RecipeBookDiseaseCategory[]
 */
?><h1>Справочник детских болезней</h1>

<div class="wysiwyg-content">
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


<div class="disease-abc clearfix">

    <?php
    $perColumn = ceil((RecipeBookDisease::model()->count() + RecipeBookDiseaseCategory::model()->count() * 4) / 3);
    $perColumn = ($perColumn == 0) ? 1 : $perColumn;
    $i = 0;
    $column = 1;
    $closeColumn = false;
    ?>

    <ul>
        <li>
            <?php
            foreach ($categories as $category) {
                if ($i + count($category->diseases) / 3 >= $column * $perColumn)
                    $closeColumn = true;
                if ($closeColumn && $column <= 3) {
                    echo '</li><li>';
                    $closeColumn = false;
                    $column++;
                }
                ?>
                <div class="cat-title">
                    <span class="disease-cat active">
                        <i class="icon-disease-cat icon-disease-<?= $category->id ?>"></i>
                        <span><?=$category->title ?></span>
                    </span>
                </div>
                <?php
                echo '<ul>';
                $i = $i + 5;

                foreach ($category->diseases as $diseases) {
                    echo '<li><a href="' . $this->createUrl('view', array('id' => $diseases->slug)) . '">' . $diseases->title . '</a></li>';
                    $i++;
                    if ($i >= $column * $perColumn)
                        $closeColumn = true;
                }
                echo '</ul>';

                if ($closeColumn && $column <= 3) {
                    echo '</li><li>';
                    $closeColumn = false;
                    $column++;
                }
            }
            ?>
        </li>
    </ul>

</div>