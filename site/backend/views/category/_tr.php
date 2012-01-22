<?php
    $cs = Yii::app()->clientScript;

    $js = "
        treeInfo[" . $category->primaryKey . "] = new Array;
        treeInfo[" . $category->primaryKey . "]['descendants'] = new Array;
        treeInfo[" . $category->primaryKey . "]['children'] = new Array;
        treeInfo[" . $category->primaryKey . "]['ancestors'] = new Array;
        treeInfo[" . $category->primaryKey . "]['parent'] = '" . $category->parentIds . "';
    ";

    foreach ($category->descendatsIds as $id)
    {
        $js .= "
            treeInfo[" . $category->primaryKey . "]['descendants'].push('" . $id . "');
        ";
    }

    foreach ($category->childrenIds as $id)
    {
        $js .= "
            treeInfo[" . $category->primaryKey . "]['children'].push('" . $id . "');
        ";
    }

    foreach ($category->ancestorsIds as $id)
    {
        $js .= "
            treeInfo[" . $category->primaryKey . "]['ancestors'].push('" . $id . "');
        ";
    }

    $cs->registerScript('node_' . $category->primaryKey, $js);
?>

<tr class="sett_lvl<?php echo $category->category_level; ?>" id="node_<?php echo $category->primaryKey; ?>">
    <td class="name_ct">
        <a href="#" class="move_lvl" title="Переместить">&nbsp;</a>
        <a href="#" class="nm_catg turn_icon" title="Развернуть">&nbsp;</a>
        <a href="#" class="edit"><?php echo $category->category_name; ?></a>
    </td>
    <td class="active_ct">
        <ul>
            <?php if ($category->category_level < 3): ?>
                <li><span title="Создание подкатегории" class="add_child">
                    <img src="images/icons/add_catg_icon.png" alt="Создание подкатегории"/></span></li>
            <?php endif; ?>
            <li><a href="#" title="Подробно о категории">
                <img src="images/icons/info_catg_icon.png" alt="Подробно о категории"/></a></li>
            <li><a href="#" title="Посмотреть в магазине">
                <img src="images/icons/view_shop_icon.png" alt="Посмотреть в магазине"/></a></li>
        </ul>
    </td>
    <td class="goods_ct">
        <ul>
            <li>Товаров - <a href="#"><?php echo $category->productsCount; ?></a></li>
            <li>Брендов - <a href="#"><?php echo $category->brandsCount; ?></a></li>
        </ul>
    </td>
    <td class="sell_ct">
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
    </td>
    <td class="ad_ct">
        <ul>
            <li><?php $this->widget('OnOffWidget', array('model' => $category)); ?></li>
            <li><?php $this->widget('DeleteWidget', array('model' => $category)); ?></li>
        </ul>
    </td>
</tr>