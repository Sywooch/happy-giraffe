<div class="serv-category serv-category__cook-choose clearfix">
    <?php
    foreach ($categories as $category)
    {
        ?>
        <ul class="serv-category_ul">
            <li class="serv-category_li">
                <div class="serv-category_top">
                    <div class="serv-category_ico ico-product ico-product__<?= $category->id ?>"></div>
                    <div class="serv-category_t"><?= $category->title ?></div>
                </div>
                <ul class="serv-category_in-ul">
                    <?php
                    foreach ($category->chooses as $choose)
                    {
                        ?>
                        <li class="serv-category_in-li"><a class="a-light" href="<?= $this->createUrl('view', array('id' => $choose->slug)) ?>"><?= $choose->title ?></a></li>
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