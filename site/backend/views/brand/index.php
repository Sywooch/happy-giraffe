<div class="centered">
    <h1>Категории товаров</h1>

    <div class="total_block">
        <p>Категорий (подкатегорий)- 58</p>

        <p>
            <span class="deactive_items">- 13</span>
            <span class="active_items">- 27</span>
        </p>
    </div>

    <div class="search_ct">
        <form action="#">
            <p>
                <label for="findText">Поиск категории</label>
                <input id="findText" type="text" class="search_catg"/>
                <input type="button" class="search_subm" value="Найти"/>
            </p>
        </form>
    </div>
    <!-- .much_catg -->
    <div class="clear"></div>
    <!-- .clear -->
</div>
<!-- .centered -->
<div class="sett_block">
    <table class="common_sett brands">
        <tr>
            <th class="name_ct">
                <span>Название бренда</span>
                <span class="add_main_ct" title="Добавить бренд">+</span>
            </th>
            <th class="logo_ct">Логотип</th>
            <th class="active_ct">Действие</th>
            <th class="goods_ct">Товары</th>
            <th class="sell_ct">
                <span>Продажи <ins>(руб.)</ins></span>
                <ul>
                    <li><a href="#" class="active">д</a></li>
                    <li>|</li>
                    <li><a href="#">н</a></li>
                    <li>|</li>
                    <li><a href="#">м</a></li>
                    <li>|</li>
                    <li><a href="#">г</a></li>
                </ul>
            </th>
            <th class="ad_ct"></th>
        </tr>
        <?php foreach($brands as $b): ?>
            <?php $this->renderPartial('_tr', array('brand' => $b)); ?>
        <?php endforeach; ?>
    </table>
</div>
<!-- .sett_block -->

<div class="pagination pagination-center clearfix">
            <span class="text">
                Страницы:
            </span>
    <ul>
        <li class="previous"><a href="#"></a></li>
        <li class="page"><a href="#"><span>1</span></a></li>
        <li class="page"><a href="#"><span>2</span></a></li>
        <li class="page selected"><a href="#"><span>321</span></a></li>
        <li class="page"><a href="#"><span>4</span></a></li>
        <li class="page"><a href="#"><span>5</span></a></li>
        <li class="page"><a href="#"><span>6</span></a></li>
        <li class="page"><a href="#"><span>7</span></a></li>
        <li class="next"><a href="#"></a></li>
    </ul>
</div>