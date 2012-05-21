<?php
/**
 * @var $product Product
 */
?>
<tr>
    <td><?php echo $product->product_title; ?></td>
    <td><a href="javascript:;" class="show_items">Посмотреть товары</a></td>
</tr>
<tr class="product_items">
    <td colspan="3">
        <table>
            <tbody>
            <?php if(count($product->items) > 0): ?>
            <?php foreach($product->items as $item): ?>
                <tr>
                    <td>
                        <?php foreach($item->params as $key => $param): ?>
                            <?php echo ($key != 0 ? ', ' : '') . CHtml::tag('strong', array(), $param['attribute']->attribute_title) . ': ' . $param['value']; ?>
                        <?php endforeach; ?>
                    </td>
                    <td><?php echo $item->price; ?> руб.</td>
                    <td><a href="javascript:;">Использовать</a></td>
                </tr>
            <?php endforeach; ?>
            <?php else: ?>
                <tr><td>Нет доступных товаров</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </td>
</tr>