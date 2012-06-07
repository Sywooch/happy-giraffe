<div class="photo-title">
    <label>Название блюда или оформления</label>
    <input type="text" name="title" placeholder="Введите название ">
    <label>Категория</label>
    <?php
    Yii::import('application.modules.cook.models.CookDecorationCategory');
    echo CHtml::dropDownList('category', '', CHtml::listData(CookDecorationCategory::model()->findAll(), 'id', 'title'));
    ?>
</div>