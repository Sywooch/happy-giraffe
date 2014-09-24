<div class="serv-category serv-category__child-disease clearfix">
    <?php
    // Для формирования ровных столбцов, переставляем некоторые элементы
    $neurologyAndOncology = array_splice($categories, 7, 2);
    array_splice($categories, 6, 0, $neurologyAndOncology);
    
    foreach ($categories as $category)
    {
        ?>
        <ul class="serv-category_ul">
            <li class="serv-category_li">
                <div class="serv-category_top">
                    <div class="serv-category_ico ico-child-disease ico-child-disease__<?= $category->id ?>"></div>
                    <div class="serv-category_t"><?= $category->title ?></div>
                </div>
                <ul class="serv-category_in-ul">
                    <?php
                    foreach ($category->diseases as $disease)
                    {
                        ?>
                        <li class="serv-category_in-li"><a class="a-light" href="<?= $this->createUrl('default/view', array('id' => $disease->slug)) ?>"><?= $disease->title ?></a></li>
                        <?php
                    }
                    ?>
                </ul>
            </li>
        </ul>
        <?php
    }
    ?>
</div>