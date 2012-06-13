<div class="form">

    <div class="photo-upload clearfix">
        <div class="photo">
            <div class="in">
                <img src="<?=$photo;?>" width="170" alt="">
                <a href="" class="remove tooltip" title="Удалить"></a>
            </div>
        </div>

        <div class="photo-title">
            <label>Название блюда или оформления</label>
            <input type="text" placeholder="Введите название" name="title" value="<?=$title;?>"/>
            <br/><br/>
            <label>Укажите тип блюда</label><br/>
						<span>
                            <?php
                            Yii::import('application.modules.cook.models.CookDecorationCategory');
                            echo CHtml::dropDownList('category', '', CHtml::listData(CookDecorationCategory::model()->findAll(), 'id', 'title'), array('class' => 'chzn-select chzn'));
                            ?>
						</span>
        </div>

    </div>

    <div class="form-bottom">
        <button class="btn btn-green-medium" onclick="<?php echo $widget_id; ?>.insertToCookDecoration('<?=$val;?>');">
            <span><span>Завершить</span></span>
        </button>
    </div>

</div>