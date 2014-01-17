<?php
/**
 * @var CActiveDataProvider $dp
 */
?>

<div class="page-col">
    <div class="page-col_top">
        <div class="page-col_t"><a href="" class="page-col_t-a active">Записи 54</a><a href="" class="page-col_t-a">Комментарии 165</a><a href="" class="page-col_t-a">Фотографии 65</a></div>
    </div>
    <div class="page-col_cont page-col_cont__gray">
        <!-- antispam-->
        <div class="antispam">
            <?php
            $this->widget('zii.widgets.CListView', array(
                'dataProvider' => $dp,
                'itemView' => '_check',
                'summaryText' => '',
                'cssFile' => false,
            ));
            ?>
            <?php if (false): ?>
            <!-- antispam_i-->
            <div class="antispam_i clearfix">
                <div class="antispam_cont">
                    <!-- paginator-->
                    <div class="yiipagination margin-l100">
                        <div class="pager">
                            <ul class="yiiPager">
                                <li class="page"><a href="">1</a></li>
                                <li class="page"><a href="">2</a></li>
                                <li class="page selected"><a href="">3</a></li>
                                <li class="page"><a href="">4</a></li>
                                <li class="page"><a href="">5</a></li>
                                <li class="page"><a href="">6</a></li>
                                <li class="page"><a href="">7</a></li>
                                <li class="page"><a href="">8</a></li>
                                <li class="page"><a href="">9</a></li>
                                <li class="page"><a href="">10</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- /paginator-->
                </div>
                <div class="antispam_control"></div>
            </div>
            <?php endif; ?>
        </div>
        <!-- /antispam-->
    </div>
</div>