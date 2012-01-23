<?php
    $model = new Product;

    $cs = Yii::app()->clientScript;

    $js= "
            $('body').delegate('span.add_main_ct', 'click', function() {
                $('table.common_sett').append($('#new_good_form').tmpl());
            });

            $('body').delegate('input[type=button].b_new_catg', 'click', function() {
                $(this).parents('form').submit();
            });

            $('select').selectBox();
    ";

    $cs->registerScript('product_index', $js);
?>

<script id="new_good_form" type="text/x-jquery-tmpl">
    <tr>
        <td class='name_ct'>
            <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'action' => 'brand/add',
                ));
            ?>
                <?php echo $form->textField($model, 'product_title', array('class' => 't_new_catg')); ?>
                <?php echo CHtml::button('Ok', array('class' => 'b_new_catg')); ?>
            <?php $this->endWidget(); ?>
        </td>
        <td class='logo_ct'>
            <a href='#' class='add_logo' title='Загрузить логотип'>+</a>
        </td>
        <td class='logo_ct' colspan='3'>

        </td>
    </tr>
</script>

<div class="centered">
    <h1>Товары</h1>

    <div class="search_ct">
        <?php echo CHtml::beginForm('index', 'get'); ?>
            <p>
                <label>Поиск по категории</label>
                <?php echo CHtml::dropDownList('category_id', $category_id,
                    CHtml::listData(Category::model()->findAll(), 'category_id', 'category_name'), array('empty'=>' ')); ?>
            </p><p>
                <label>Поиск по брэнду</label>
                <?php echo CHtml::dropDownList('brand_id', $brand_id,
                CHtml::listData(ProductBrand::model()->findAll(), 'brand_id', 'brand_title'), array('empty'=>' ')); ?>
            </p><p>
                <input type="button" class="search_subm" value="Найти" onclick="submit();"/>
            </p>
        <?php echo CHtml::endForm(); ?>
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
                <span>Название товара</span>
            <?php if (!empty($category_id)):?>
                    <span class="add_main_ct" title="Добавить товар">+</span>
            <?php endif ?>
            </th>
            <th class="logo_ct">Фото</th>
            <th class="active_ct">Действие</th>
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
            <th></th>
        </tr>
        <?php foreach($goods as $good): ?>
            <?php $this->renderPartial('_tr', array('good' => $good)); ?>
        <?php endforeach; ?>
    </table>
</div>
<!-- .sett_block -->

<?php if ($pages->pageCount > 1): ?>
<div class="pagination pagination-center clearfix">
			<span class="text">
				Показано: <?php echo $pages->currentPage * $pages->pageSize + 1; ?>-<?php echo ($pages->currentPage + 1) * $pages->pageSize; ?> из <?php echo $pages->itemCount; ?>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				Страницы:
			</span>
    <?php $this->widget('LinkPager', array(
    'pages' => $pages,
)); ?>
</div>
<?php endif; ?>