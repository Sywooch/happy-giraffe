<?php
/* @var $this Controller
 * @var $form CActiveForm
 * @var int $category_id
 */
Yii::app()->clientScript->registerCoreScript('jquery');
?>
<script type="text/javascript">
    var model_id = null;
    var category_id = <?php echo $category_id ?>;

    $(function() {
        $('form.editProduct > div.name input[type=button]').click(function(){
            var title = $(this).prev().val();
            if (title != '')
                $.ajax({
                    url: '<?php echo Yii::app()->createUrl("product/create") ?>',
                    data: {title:title,category:category_id},
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(data) {
                        if (data.success){
                            $('form.editProduct > div').show();
                            model_id = data.id;
                        }
                    },
                    context: $(this)
                });
            return false;
        });

        $('#descr-update').click(function(){
            var text = $(this).prev().prev().val();
            $.ajax({
                url: '<?php echo Yii::app()->createUrl("ajax/SetValue") ?>',
                data: {
                    modelPk:model_id,
                    attribute:'product_text',
                    modelName:'Product',
                    value:text
                },
                type: 'POST',
                success: function(data) {
                    if (data){

                    }
                },
                context: $(this)
            });
            return false;
        });
    });
</script>
<div class="centered">
    <div class="bodyr">
        <div class="right">
            <a href="#" class="all_products">Список товаров</a>
        </div>
        <div class="center">
            <form action="#" class="editProduct">
                <div class="name">
                    <input type="text" class="h1" value=""/>
                    <input type="button" class="greenGradient" value="Ok"/>

                    <div class="clear"></div>
                </div>

                <div style="display: none;">
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
                        <textarea rows="20" cols="10">Напишите описание товара не более 400 символов</textarea>
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

                    <div class="characteristic">
                        <p>
                            <span class="name">Упаковка</span>
                            <select id="select1">
                                <option selected="selected">Тип</option>
                                <option>Рубль</option>
                                <option>Доллар</option>
                            </select>
                            <input type="button" class="smallGreen" value="Ok"/>
                        </p>
                        <p>
                            <span class="name">Содержание сахара</span>
                            <input type="button" class="smallGrey" value="Да"/>
                            <input type="button" class="smallRed" value="Нет"/>
                        </p>

                        <p>
                            <span class="name">Вид пюре</span>
                            <select id="select2">
                                <option selected="selected">Фруктовое пюре</option>
                                <option>Овощное пюре</option>
                                <option>Мясное пюре</option>
                            </select>
                        </p>
                    </div>

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