<div class="b-main_cont b-main_cont__wide">


    <!--+userSubscribers('visible-md-block')-->
    <div class="b-main_col-hold clearfix">
        <!--/////-->
        <!-- Основная колонка-->
        <div class="b-main_col-article">
            <!-- Статья с текстом-->
            <!-- b-article-->
            <?php
                $this->widgets('LiteListView');
            ?>

            <!-- paginator-->
            <div class="yiipagination yiipagination__center">
                <div class="pager">
                    <ul class="yiiPager">
                        <li class="previous"><a href=""></a></li>
                        <li class="page"><a href="">1</a></li>
                        <!-- class .page-points нужно заменить на стандартный класс yii для этого элемента-->
                        <li class="page-points">...</li>
                        <li class="page"><a href="">6</a></li>
                        <li class="page selected"><a href="">7</a></li>
                        <li class="page"><a href="">8</a></li>
                        <!-- class .page-points нужно заменить на стандартный класс yii для этого элемента-->
                        <li class="page-points">...</li>
                        <li class="page"><a href="">15</a></li>
                        <li class="next"><a href=""></a></li>
                    </ul>
                </div>
            </div>
            <!-- /paginator-->
        </div>
        <!-- /Основная колонкa-->

        <!--/////-->
        <!-- Сайд бар-->
        <!-- Содержимое загружaть отложено-->
        <aside class="b-main_col-sidebar visible-md">
            <div class="bnr-sidebar"><a href="#"> <img src="/lite/images/banner/mygiraffe.png" alt=""></a></div>
        </aside>
    </div>
</div>