<div id="product-choose">

    <div class="title">

        <h2>Как выбрать продукты?</h2>

    </div>

    <div class="clearfix">

        <div class="product-choose-in">

            <div class="wysiwyg-content">

                <h1>Выбираем продукты вместе с нами</h1>

                <p>Задумываетесь ли вы о том, как правильно выбрать продукты в супермаркете, магазине или на рынке? Скорее всего – да. Каждый здравомыслящий человек понимает, что «он есть то, что он
                    ест», а потому к выбору продуктов относится серьёзно.</p>

                <p>Реалии нашей жизни таковы, что продавцы и производители продуктов в погоне за большей прибылью стараются снизить себестоимость продукции, а это чревато тем, что в состав привычных
                    нам изделий попадают некачественные компоненты: натуральные красители заменяются химическими «аналогами», аромат создаётся искусственными добавками, чтобы продукт хранился дольше –
                    добавляются консерванты и так далее.</p>

                <p>Хорошо, когда состав продукта написан на упаковке, а если это рынок и нужно выбрать овощи, фрукты, зелень или ягоды? Как выбрать спелый и полезный плод? Ведь, чтобы скоропортящийся
                    товар хранился подольше, продавцы могут орошать его специальными растворами, предотвращающими порчу, однако пользы для здоровья от оросителей, конечно, нет, а вот вред они принести
                    могут серьёзный.</p>

                <p>Поэтому мы решили создать своеобразный справочник по выбору качественных продуктов. Заходите в любой из разделов и ищите то, что вы собираетесь купить в ближайшее время. Читайте
                    короткие статьи – практические советы, конкретные, простые и понятные, которые подскажут вам, как выбрать спелый фрукт, прекрасное вино и другие нужные вам продукты.</p>

                <p>Мы очень рассчитываем на вашу помощь. Возможно, у вас есть какие-то свои хитрости, касающиеся того, как правильно выбрать любимые продукты, или, наоборот, вам хочется узнать, как
                    выбрать какой-то конкретный товар. Пишите комментарии – мы с большим вниманием относимся к вашим просьбам, пожеланиям, советам и обещаем очень быстро отреагировать на все ваши
                    послания новыми интересными материалами.</p>
            </div>

            <?php
            $perColumn = ceil((CookChoose::model()->count() + CookChooseCategory::model()->count() * 4) / 3);
            $perColumn = ($perColumn == 0) ? 1 : $perColumn;
            $i = 0;
            $column = 1;
            $closeColumn = false;
            ?>

            <div class="product-choose-abc clearfix">
                <ul>
                    <li>
                        <?php
                        foreach ($categories as $category) {
                            if ($i + count($category->chooses) / 2 >= $column * $perColumn)
                                $closeColumn = true;
                            if ($closeColumn && $column <= 3) {
                                echo '</li><li>';
                                $closeColumn = false;
                                $column++;
                            }

                            echo '<div class="cat-title"><span class="cook-cat active"><i class="icon-cook-cat icon-product-' . $category->id . '"></i><span>' . $category->title . '</span></span></div>';
                            echo '<ul>';
                            $i = $i + 5;

                            foreach ($category->chooses as $product) {
                                echo '<li><a href="' . $this->createUrl('view', array('id' => $product->slug)) . '">' . $product->title . '</a></li>';
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

        </div>

        <div class="product-choose-categories">
            <?php $this->renderPartial('_categories', array('category_slug' => 'root')); ?>
        </div>

    </div>

</div>