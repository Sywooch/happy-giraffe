<div id="wysiwygAddLink" class="popup">

    <a href="javascript:void(0);" class="popup-close" onclick="$.fancybox.close();">закрыть</a>

    <div class="title">Вставить ссылку</div>

    <div class="row">
        <label>Адрес ссылки</label><br>
        <input class="link-address" type="text" placeholder="Вставьте ссылку">
    </div>

    <div class="row">
        <label>Название ссылки</label><br>
        <input class="link-name" type="text" placeholder="Введите название" value="<?=$text ?>">
    </div>
    <div class="bottom"><a href="" class="btn btn-green-medium" id="add-mylink" onclick="epic_func_mylink(this);return false;"><span><span>Ok</span></span></a></div>

</div>