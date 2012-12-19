<div class="form">

    <div class="photo-upload clearfix">
        <div class="photo">
            <div class="in">
                <img src="<?=$photo;?>" width="170" alt="">
                <a href="javascript:;" onclick="$('#file_attach_menu li:first-child a').trigger('click');" class="remove tooltip" title="Удалить"></a>
            </div>
        </div>

        <div class="photo-title">
            <label>Название блюда или оформления<br/><span> (не более 70 знаков)</span></label>
            <input type="text" placeholder="Введите название" name="title" maxlength="70" value="<?=$title;?>"/>
            <br/><br/>
            <label>Комментарий к фото<br><span>(не обязательно, не более 200 знаков)</span></label>
            <br/>
            <textarea name="description"></textarea>
            <br/><br/>
            <label>Укажите тип блюда</label><br/>
            <span class="chzn-drop-short">
                <?php
                Yii::import('application.modules.cook.models.CookDecorationCategory');
                echo CHtml::dropDownList('category', '', CHtml::listData(CookDecorationCategory::model()->findAll(), 'id', 'title'), array('class' => 'chzn-select chzn'));
                ?>
            </span>
            <div class="errorMessage"></div>
        </div>

    </div>

    <div class="form-bottom">
        <button class="btn btn-green-medium" onclick="<?php echo $widget_id; ?>.insertToCookDecoration('<?=$val;?>');">
            <span><span>Завершить</span></span>
        </button>
    </div>

</div>