<div class="content_block">
    <div class="view_name gender-link">
        <p>Показывать</p>
        <a class="all_names active" onclick="return NameModule.showAllLikes(this);" href="#">Все имена</a>
        <a class="boy_names" onclick="return NameModule.showBoysLikes(this);" href="#">Мальчики</a>
        <a class="girl_names" onclick="return NameModule.showGirlsLikes(this);" href="#">Девочки</a>
    </div>
    <p class="names_header like">Мне нравятся</p>

    <div class="clear"></div>

    <div class="list_names" id="likes-all">
        <div class="clearfix">
        <?php $i=1;
            foreach ($data as $name){
                       $this->renderPartial('__name', array(
                           'id' => $name['id'],
                           'name' => $name['name'],
                           'slug' => $name['slug'],
                           'gender' => $name['gender'],
                           'translate' => $name['translate'],
                           'like_ids' => $like_ids,
                           'num'=>$i
                       ));$i++; }?>
    </div>
    </div>

    <div class="list_names" id="likes-man" style="display: none;">
        <div class="clearfix">
        <?php $i=1;
        foreach ($man as $name){
                       $this->renderPartial('__name', array(
                           'id' => $name['id'],
                           'name' => $name['name'],
                           'slug' => $name['slug'],
                           'gender' => $name['gender'],
                           'translate' => $name['translate'],
                           'like_ids' => $like_ids,
                           'num'=>$i
                       ));$i++;} ?>
        </div>
    </div>

    <div class="list_names" id="likes-woman" style="display: none;">
        <div class="clearfix">
        <?php $i=1;
        foreach ($woman as $name){
                       $this->renderPartial('__name', array(
                           'id' => $name['id'],
                           'name' => $name['name'],
                           'slug' => $name['slug'],
                           'gender' => $name['gender'],
                           'translate' => $name['translate'],
                           'like_ids' => $like_ids,
                           'num'=>$i
                       ));$i++;} ?>
        </div>
    </div>
</div>