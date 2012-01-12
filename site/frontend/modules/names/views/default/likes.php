<script type="text/javascript">
    var gender;
    $(function () {
        $('.gender-link a').click(function () {
            gender = $(this).attr('rel');
            if (gender == 1) {
                $('.list_names').hide();
                $('#likes-man').show();

                $('.gender-link a').removeClass('active');
                $(this).addClass('active');
                return false;
            }
            if (gender == 2) {
                $('.list_names').hide();
                $('#likes-woman').show();
                $('.gender-link a').removeClass('active');
                $(this).addClass('active');
                return false;
            }

            $('.list_names').hide();
            $('#likes-all').show();
            $('.gender-link a').removeClass('active');
            $(this).addClass('active');
            return false;
        });
    });
</script>

<div class="content_block">
    <?php $this->renderPartial('_gender'); ?>
    <p class="names_header like">Мне нравятся</p>

    <div class="clear"></div>

    <div class="list_names" id="likes-all">
        <?php $i=1;
            foreach ($data as $name){
                       $this->renderPartial('__name', array(
                           'id' => $name['id'],
                           'name' => $name['name'],
                           'gender' => $name['gender'],
                           'translate' => $name['translate'],
                           'like_ids' => $like_ids,
                           'num'=>$i
                       ));$i++; }?>
        <div class="clear"></div>
    </div>

    <div class="list_names" id="likes-man" style="display: none;">
        <?php $i=1;
        foreach ($man as $name){
                       $this->renderPartial('__name', array(
                           'id' => $name['id'],
                           'name' => $name['name'],
                           'gender' => $name['gender'],
                           'translate' => $name['translate'],
                           'like_ids' => $like_ids,
                           'num'=>$i
                       ));$i++;} ?>
        <div class="clear"></div>
    </div>

    <div class="list_names" id="likes-woman" style="display: none;">
        <?php $i=1;
        foreach ($woman as $name){
                       $this->renderPartial('__name', array(
                           'id' => $name['id'],
                           'name' => $name['name'],
                           'gender' => $name['gender'],
                           'translate' => $name['translate'],
                           'like_ids' => $like_ids,
                           'num'=>$i
                       ));$i++;} ?>
        <div class="clear"></div>
    </div>
</div>