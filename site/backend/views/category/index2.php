<div class="centered">
    <h1>Категории товаров</h1>

    <div class="total_block">
        <p>Категорий (подкатегорий)- <ins><?php echo $count['total']; ?></ins></p>

        <p>
            <span class="deactive_items">- <ins><?php echo $count['off']; ?></ins></span>
            <span class="active_items">- <ins><?php echo $count['on']; ?></ins></span>
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
    <!-- .search_ct -->
    <div class="clear"></div>
    <!-- .clear -->
</div>

<div class="grid">
    <div class="grid_head">
        <div class="name_ct">
            <span>Название категории</span>
            <span class="add_main_ct" title="Создание подкатегории">+</span>
        </div>
        <div class="active_ct">Действие</div>
        <div class="goods_ct">Товары</div>
        <div class="sell_ct">
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
        </div>
        <div class="ad_ct"></div>
    </div>
    <div class="grid_body">
        <?php echo $this->getTreeItems($tree); ?>
    </div>
</div>

<script type="text/javascript">
    $('.grid .grid_body ul').nestedSortable({
        listType : 'ul',
        items: 'li',
        placeholder: 'placeholder',
        helper : 'original',
        maxLevels : 5
    });
</script>