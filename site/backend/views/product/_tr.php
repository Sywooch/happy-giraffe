<tr>
    <td class="name_ct">
        <?php
        $this->widget('EditDeleteWidget', array(
            'deleteButton'=>false,
            'model' => $good,
            'attribute' => 'product_title',
            'options'=> array(
                'edit_selector'=>'a',
                'edit_link_class'=>'no_child',
                'edit_link_text'=>$good->product_title,
            )
        ));?>
    </td>
    <td class="active_ct">
        <ul>
            <li><a href="<?php echo $this->createUrl('update', array('product_id'=>$good->product_id)) ?>"
                   title="Подробно о товаре" target="_blank">
                <img src="/images/icons/info_catg_icon.png" alt="Подробно о товаре"/></a></li>
            <li><a href="<?php echo Yii::app()->params['main_site'].'product/'.$good->product_id ?>"
                   title="Посмотреть в магазине" target="_blank">
                <img src="/images/icons/view_shop_icon.png" alt="Посмотреть в магазине"/></a></li>
        </ul>
    </td>
    <td class="sell_ct">
        <ul>
            <li>
                <ins>Оборот</ins>
                - 0
            </li>
            <li>
                <ins>Прибыль</ins>
                - 0
            </li>
        </ul>
    </td>
    <td class="ad_ct">
        <ul>
            <li><?php $this->widget('DeleteWidget', array('model' => $good)); ?></li>
        </ul>
    </td>
</tr>