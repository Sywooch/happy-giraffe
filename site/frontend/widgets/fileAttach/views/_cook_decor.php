<div class="photo-title">

    <div class="row">
    <label>Тип блюда</label>
    <?php
    Yii::import('application.modules.cook.models.CookDecorationCategory');
    echo CHtml::dropDownList('category', '', CHtml::listData(CookDecorationCategory::model()->findAll(), 'id', 'title'), array('class'=>'chzn-select'));
    ?>
    </div>

    <div class="row">
    <label>Название блюда или оформления</label>
    <input type="text" name="title" placeholder="Введите название ">
    </div>

</div>