<div id="product-choose">

    <div class="title">

        <h2>Как выбрать продукты?</h2>

    </div>

    <div class="clearfix">

        <div class="product-choose-in">

            <div class="wysiwyg-content">

                <h1>Выбираем продукты вместе с нами</h1>

                <p>Мёд – это кладезь натуральных витаминов и микроэлементов. Многие используют этот полезный продукт вместо сахара и готовят с его помощью просто потрясающе вкусные блюда. А как
                    выбрать мед? И
                    какой мед бывает вообще? Да разный! Он отличается по цвету и консистенции, по аромату, по фасовке. И как может быть иначе, ведь пчелы делают его, собирая с самых разных растений.
                    Но при
                    всём разнообразии настоящий мёд должен быть качественным, и вот про это мы сейчас и поговорим.</p>

                <p>Мёд – это кладезь натуральных витаминов и микроэлементов. Многие используют этот полезный продукт вместо сахара и готовят с его помощью просто потрясающе вкусные блюда. А как
                    выбрать мед? И
                    какой мед бывает вообще? Да разный!</p>

            </div>

            <?php
            $perColumn = ceil(CookChoose::model()->count() / 3);
            $perColumn = ($perColumn == 0) ? 1 : $perColumn;
            $i = 0;
            $closeColumn = false;
            ?>

            <div class="product-choose-abc clearfix">

                <ul>
                    <li>
                        <?php
                        foreach ($categories as $category) {
                            echo '<div class="cat-title"><span class="cook-cat active"><i class="icon-cook-cat icon-product-' . $category->id . '"></i><span>' . $category->title . '</span></span></div>';
                            echo '<ul>';
                            foreach ($category->chooses as $product) {
                                echo '<li><a href="' . $this->createUrl('view', array('id' => $product->slug)) . '">' . $product->title . '</a></li>';
                                $i++;
                                if (($i % $perColumn) == 0)
                                    $closeColumn = true;
                            }
                            echo '</ul>';
                            if ($closeColumn) {
                                echo '</li><li>';
                                $closeColumn = false;
                            }
                        }
                        ?>
                    </li>
                </ul>


            </div>

        </div>

        <div class="product-choose-categories">
            <?php $this->renderPartial('_categories', array('category_slug' => 'root')); ?>
        </div>

    </div>

</div>