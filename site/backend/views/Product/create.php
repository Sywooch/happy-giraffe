<?php
/* @var $this Controller
 * @var $model Product
 * @var int $category_id
 * @var AttributeSetMap[] $attributeMap
 */
Yii::app()->clientScript->registerCoreScript('jquery');
?>
<script type="text/javascript">
    var model_id = <?php echo $model->product_id ?>;
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

                    }
                },
                context:$(this)
            });
        });

        $('.characteristic a.edit').click(function(){
            var block = $(this).parent();
            block.find('a').hide();
            block.find('p').show();

            return false;
        });

        $('.characteristic input.set-value').click(function () {
            var block = $(this).parent().parent();
            var value = block.find('input[type=text]').val();
            var id = block.find('input[type=hidden]').val();
            SetAttributeValue(id, value, value, block);
        });

        $('.characteristic input.set-text').click(function () {
            var block = $(this).parent().parent();
            var value = block.find('input[type=text]').val();
            var id = block.find('input[type=hidden]').val();

            $.ajax({
                url:'<?php echo Yii::app()->createUrl("product/SetAttributeTextValue") ?>',
                data:{
                    value:value,
                    attr_id:id,
                    product_id:model_id
                },
                type:'POST',
                success:function (data) {
                    block.find('a').text(value).show();
                    block.find('p').hide();
                },
                context:block
            });
        });

        $('.characteristic input.set-yes').click(function () {
            var block = $(this).parent().parent();
            var id = block.find('input[type=hidden]').val();
            SetAttributeValue(id, 1, 'Да', block);
        });

        $('.characteristic input.set-no').click(function () {
            var block = $(this).parent().parent();
            var id = block.find('input[type=hidden]').val();
            SetAttributeValue(id, 0, 'Нет', block);
        });

        $('.characteristic input.set-enum').click(function () {
            var block = $(this).parent().parent();
            var id = block.find('input[type=hidden]').val();
            var value = block.find('select').val();
            var text = block.find("select option[value='"+value+"']").text()
            SetAttributeValue(id, value, text, block);
        });

    });

    function SetAttributeValue(attr_id, value, set_test, block) {
        $.ajax({
            url:'<?php echo Yii::app()->createUrl("product/SetAttributeValue") ?>',
            data:{
                value:value,
                attr_id:attr_id,
                product_id:model_id
            },
            type:'POST',
            success:function (data) {
                block.find('a').text(set_test).show();
                block.find('p').hide();
            },
            context:block
        });
    }
</script>
<div class="centered">
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
                        <textarea rows="20" cols="10"><?php echo $model->product_text ?></textarea>
                        <input type="button" class="greyGradient" value="Отменить"/>
                        <input type="button" class="greenGradient" id="descr-update" value="Ok"/>

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
</div>
<!-- .centered -->