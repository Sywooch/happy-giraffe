<script type="text/javascript">
    var gender;
    $(function () {
        $('.gender-link a').click(function () {
            gender = $(this).attr('rel');
            if (gender == 1) {
                $('.names_bl').hide();
                $('#likes-man').show();

                $('.gender-link li').removeClass('current');
                $(this).parent('li').addClass('current');
                return false;
            }
            if (gender == 2) {
                $('.names_bl').hide();
                $('#likes-woman').show();
                $('.gender-link li').removeClass('current');
                $(this).parent('li').addClass('current');
                return false;
            }

            $('.names_bl').hide();
            $('#likes-all').show();
            $('.gender-link li').removeClass('current');
            $(this).parent('li').addClass('current');
            return false;
        });
    });
</script>
<div class="show_names">
    <span class="show_wh">Показывать:</span>
    <ul class="gender-link">
        <li class="all_names current">
            <a href="#" rel="">
                <img src="/images/all_names_icon.png" alt="" title=""/><br/>
                <span>Все имена</span>
            </a>
        </li>
        <li class="man_names">
            <a href="#" rel="1">
                <img src="/images/man_names_icon.png" alt="" title=""/><br/>
                <span>Мальчики</span>
            </a>
        </li>
        <li class="woman_names">
            <a href="#" rel="2">
                <img src="/images/women_names_icon.png" alt="" title=""/><br/>
                <span>Девочки</span>
            </a>
        </li>
    </ul>
    <div class="clear"></div>
    <!-- .clear -->
</div><!-- .show_names -->
<div class="clear"></div><!-- .clear -->

<div id="likes-all" class="names_bl">
    <?php foreach ($data as $name)
                   $this->renderPartial('__name', array(
                       'id' => $name['id'],
                       'name' => $name['name'],
                       'gender' => $name['gender'],
                       'translate' => $name['translate'],
                       'like_ids' => $like_ids,
                   )) ?>
</div>
<div id="likes-man" class="names_bl" style="display: none;">
    <?php foreach ($man as $name)
                   $this->renderPartial('__name', array(
                       'id' => $name['id'],
                       'name' => $name['name'],
                       'gender' => $name['gender'],
                       'translate' => $name['translate'],
                       'like_ids' => $like_ids,
                   )) ?>
</div>
<div id="likes-woman" class="names_bl" style="display: none;">
    <?php foreach ($woman as $name)
                   $this->renderPartial('__name', array(
                       'id' => $name['id'],
                       'name' => $name['name'],
                       'gender' => $name['gender'],
                       'translate' => $name['translate'],
                       'like_ids' => $like_ids,
                   )) ?>
</div>
