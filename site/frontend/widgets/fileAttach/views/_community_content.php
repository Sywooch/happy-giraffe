<div class="form">

    <div class="photo-upload clearfix">
        <div class="photo">
            <div class="in">
                <img src="<?=$photo;?>" width="170" alt="">
                <a href="javascript:;" onclick="$('#file_attach_menu li:first-child a').trigger('click');" class="remove tooltip" title="Удалить"></a>
            </div>
        </div>

        <div class="photo-title">
            <label>Название <span> (не более 70 знаков)</span></label>
            <input type="text" placeholder="Введите название" name="title" maxlength="70" value="<?=$title;?>"/>
            <br/><br/>
            <label>Комментарий к фото<br><span>(не обязательно, не более 200 знаков)</span></label>
            <br/>
            <textarea name="description"></textarea>
        </div>

    </div>

    <div class="form-bottom">
        <button class="btn btn-green-medium" onclick="<?php echo $widget_id; ?>.CommunityContentInsert('<?=$val;?>');">
            <span><span>Завершить</span></span>
        </button>
    </div>

</div>