<?php
/* @var $this Controller
 * @var $model Product
 * @var int $category_id
 * @var AttributeSetMap[] $attributeMap
 */
Yii::app()->clientScript->registerCoreScript('jquery');
?>
<script type="text/javascript">
    var model_id = <?php echo ($model->isNewRecord)?'null':$model->product_id ?>;
    var category_id = <?php echo $category_id ?>;

    $(function () {
        $('form.editProduct > div.name input[type=button]').click(function () {
            var title = $(this).prev().val();
            if (title != '')
                $.ajax({
                    url:'<?php echo Yii::app()->createUrl("product/create") ?>',
                    data:{title:title, category:category_id},
                    type:'GET',
                    dataType:'JSON',
                    success:function (data) {
                        if (data.success) {
                            $('form.editProduct > div').show();
                            model_id = data.id;
                        }
                    },
                    context:$(this)
                });
        });

        $('.description h2.edit').click(function(){
            $(this).next().show();
            $(this).next().next().hide();

            return false;
        });

        $('#descr-update').click(function () {
            var text = $(this).prev().prev().val();
            $.ajax({
                url:'<?php echo Yii::app()->createUrl("ajax/SetValue") ?>',
                data:{
                    modelPk:model_id,
                    attribute:'product_text',
                    modelName:'Product',
                    value:text
                },
                type:'POST',
                success:function (data) {
                    if (data) {
                        $(this).parent().hide();
                        $(this).parent().parent().find('div.pd-text').text(text);
                        $(this).parent().parent().find('div.pd-text').show();
                    }
                },
                context:$(this)
            });
        });

        $('#descr-cancel').click(function(){
            var block = $(this).parent().parent();
            block.find('textarea').val(block.find('.pd-text').text());
        });
    });
</script>
<div class="bodyr">
    <div class="right">
        <a href="#" class="all_products">Список товаров</a>
    </div>
    <div class="center">
        <form action="#" class="editProduct">
            <div class="name">
                <input type="text" class="h1" value="<?php echo $model->product_title ?>"/>
                <input type="button" class="greenGradient" value="Ok"/>

                <div class="clear"></div>
            </div>

            <div<?php if ($model->isNewRecord) echo ' style="display: none;"' ?>>
                <div class="one_product">
                    <div class="big_foto">
                        <a href="#" class="add addValue" title="Загрузить фото">
                                    <span>
                                        Загрузите <ins>фото</ins> товара
                                    </span>
                        </a>
                    </div>
                    <ul id="mycarousel" class="small_foto">
                        <li>
                            <a href="#" class="add addValue" title="Добавить фото"></a>
                        </li>
                        <li>
                            <a href="#" class="add addValue" title="Добавить фото"></a>
                        </li>
                        <li>
                            <a href="#" class="add addValue" title="Добавить фото"></a>
                        </li>
                        <li>
                            <a href="#" class="add addValue" title="Добавить фото"></a>
                        </li>
                        <li>
                            <a href="#" class="add addValue" title="Добавить фото"></a>
                        </li>
                        <li>
                            <a href="#" class="add addValue" title="Добавить фото"></a>
                        </li>
                    </ul>
                    <p class="total">Всего фото: 3</p>
                </div>

                <div class="brand add">
                    <span>Brand</span>
                    <a href="#" class="addValue" title="Выбрать бренд"></a>
                </div>

                <div class="description">
                    <h2 class="edit">Описание товара</h2>
                    <div class="pd-form" "<?php if (!empty($model->product_text)) echo ' style="display:none;" ' ?>>
                        <textarea rows="20" cols="10"><?php echo $model->product_text ?></textarea>
                        <input type="button" class="greyGradient" id="descr-cancel" value="Отменить"/>
                        <input type="button" class="greenGradient" id="descr-update" value="Ok"/>
                    </div>
                    <div class="pd-text"<?php if (empty($model->product_text)) echo ' style="display:none;"' ?>><?php
                        echo $model->product_text ?></div>
                </div>

                <div class="clear"></div>

                <div class="quantity">
                    <div class="left_quantity">
                        <p>Количество на складе</p>

                        <p class="number"><span>0</span> шт.</p>
                        <a href="#addQuantity" class="greenGradient fancy">Добавить на склад</a>
                    </div>
                    <div class="right_quantity">
                    </div>
                    <div class="clear"></div>
                </div>

                <p class="text_header">Технические характеристики</p>

                <table class="characteristic">
                    <?php $this->renderPartial('_attributes', array(
                    'attributeMap' => $attributeMap,
                    'model' => $model
                )); ?>
                </table>

                <p class="text_header">Видео о товаре</p>

                <div class="video">
                    <a href="#" class="delete"></a>
                    <img src="images/content/video.png" alt=""/>
                </div>

                <div class="video add">
                    <a href="#" class="add addValue" title="Добавить видео"></a>
                </div>

                <div class="clear"></div>
            </div>
        </form>
    </div>
</div>

<!-- .search_ct -->
<div class="clear"></div>
<!-- .clear -->
