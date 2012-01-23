<li>
    <div class="data">
        <div class="column name_ct">
            <a href="#" class="move_lvl" title="Переместить">&nbsp;</a>
            <a href="#" class="nm_catg turn_icon" title="Развернуть">&nbsp;</a>
            <a href="#" class="edit"><?php echo $model->category_name; ?></a>
        </div>
        <div class="column active_ct">
            <ol>
                <?php if ($model->category_level < 3): ?>
                    <li><span title="Создание подкатегории" class="add_child">
                        <img src="/images/icons/add_catg_icon.png" alt="Создание подкатегории"/></span></li>
                <?php endif; ?>
                <li><a href="#" title="Подробно о категории">
                    <img src="/images/icons/info_catg_icon.png" alt="Подробно о категории"/></a></li>
                <li><a href="#" title="Посмотреть в магазине">
                    <img src="/images/icons/view_shop_icon.png" alt="Посмотреть в магазине"/></a></li>
                <?php if (empty($model->attributeSets)):?>
                    <li>
                        <a href="<?php echo $this->createUrl('AttributeSet/create', array('category_id'=>$model->category_id)) ?>" title="Добавить пакет свойств">
                        <img src="/images/icons/add_paket_propety.png" alt="Добавить пакет свойств"/></a>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="<?php echo $this->createUrl('AttributeSet/update', array('id'=>$model->GetAttributeSet()->set_id)) ?>" title="Открыть пакет свойств">
                        <img src="/images/icons/show_paket_propety.png" alt="Открыть пакет свойств"/></a>
                    </li>
                <?php endif ?>
            </ol>
        </div>
        <div class="column goods_ct">
            <ul>
               <li>Товаров - <a href="#"><?php echo $model->productsCount; ?></a></li>
               <li>Брендов - <a href="#"><?php echo $model->brandsCount; ?></a></li>
           </ul>
        </div>
        <div class="column sell_ct">
            <ul>
                <li>
                    <ins>Оборот</ins>
                    - 23 256 789
                </li>
                <li>
                    <ins>Прибыль</ins>
                    - 8 363 123
                </li>
            </ul>
        </div>
        <div class="column ad_ct">
13
        </div>
    </div>
    <?php echo $this->getTreeItems($model->children()->findAll(array('order' => 'category_root, category_lft'))); ?>
</li>