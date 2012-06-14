<div class="photo-category">

    <div class="row">
        <label>Тип блюда</label>
        <?php
        Yii::import('application.modules.cook.models.CookDecorationCategory');
        echo CHtml::dropDownList('category', '', CHtml::listData(CookDecorationCategory::model()->findAll(), 'id', 'title'), array('class' => 'chzn-select chzn'));
        ?>
    </div>

    <div class="row">
        <label>Название блюда или оформления</label>
        <input type="text" name="title" placeholder="Введите название" value="<?=$title;?>">
    </div>
    <div class="errorMessage"></div>

    <div style="" id="save_decor_button" class="form-bottom">
        <button onclick="<?php echo $widget_id; ?>.insertToCookDecoration();" class="btn btn-green-medium">
            <span><span>Завершить</span></span>
        </button>
    </div>

</div>
