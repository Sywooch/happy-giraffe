<tr>
    <td class="name_ct">
        <a href="#" class="no_child edit"><?php echo $brand->brand_title; ?></a>
    </td>
    <td class="logo_ct">
        <?php echo CHtml::image($brand->brand_image->getUrl('display')); ?>
    </td>
    <td class="active_ct">
        <ul>
            <li><a href="#" title="Подробно о бренде">
                <img src="/images/icons/info_catg_icon.png" alt="Подробно о бренде"/></a></li>
            <li><a href="#" title="Посмотреть в магазине">
                <img src="/images/icons/view_shop_icon.png" alt="Посмотреть в магазине"/></a></li>
        </ul>
    </td>
    <td class="goods_ct">
        <ul>
            <li>Товаров - <a href="#"><?php echo $brand->productsCount; ?></a></li>
            <li>Категорий - <a href="#">256</a></li>
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
            <li><?php $this->widget('OnOffWidget', array('model' => $brand)); ?></li>
            <li><?php $this->widget('DeleteWidget', array('model' => $brand)); ?></li>
        </ul>
    </td>
</tr>