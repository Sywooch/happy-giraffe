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
        <span>
        <?php
        $this->widget('EditDeleteWidget', array(
            'deleteButton'=>false,
            'model' => $category,
            'attribute' => 'category_name',
            'options'=> array(
                'edit_selector'=>'a',
                'edit_link_class'=>'edit',
                'edit_link_text'=>$category->category_name,
            )
        ));?>
        </span>
    </td>
    <td class="active_ct">
        <ul>
            <?php if ($category->category_level < 3): ?>
                <li><span title="Создание подкатегории" class="add_child">
                    <img src="/images/icons/add_catg_icon.png" alt="Создание подкатегории"/></span></li>
            <?php endif; ?>
            <li><a href="#" title="Подробно о категории">
                <img src="/images/icons/info_catg_icon.png" alt="Подробно о категории"/></a></li>
            <li><a href="#" title="Посмотреть в магазине">
                <img src="/images/icons/view_shop_icon.png" alt="Посмотреть в магазине"/></a></li>
            <?php if (empty($category->attributeSets)):?>
                <li><a href="<?php echo $this->createUrl('AttributeSet/create', array('category_id'=>$category->category_id)) ?>" title="Добавить пакет свойств">
                    <img src="/images/icons/add_paket_propety.png" alt="Добавить пакет свойств"/></a></li>
                <?php else: ?>
                <li><a href="<?php echo $this->createUrl('AttributeSet/update', array('id'=>$category->GetAttributeSet()->set_id)) ?>" title="Открыть пакет свойств">
                    <img src="/images/icons/show_paket_propety.png" alt="Открыть пакет свойств"/></a></li>
                <?php endif ?>
        </ul>
    </td>
    <td class="goods_ct">
        <ul>
            <li>Товаров - <a href="<?php echo $this->createUrl('product/index', array('category_id'=>$category->category_id)) ?>"><?php echo $category->productsCount; ?></a></li>
            <li>Брендов - <a href="#"><?php echo $category->brandsCount; ?></a></li>
            <li><?php echo CHtml::link('Добавить товар',
                $this->createUrl('product/create', array('category_id'=>$category->category_id))) ?></li>
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