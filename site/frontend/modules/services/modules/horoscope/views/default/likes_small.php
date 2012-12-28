<?php
/**
 * @var $model Horoscope
 */
?>
<?php $url = $model->getUrl(true); ?>
<div class="custom-likes-small">
    <a class="custom-like-small" href="http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl=<?= $url?>"
       onclick="return openPopup(this);">
        <span class="custom-like-small_icon odkl"></span>
        <span class="custom-like-small_value" id="likes-count-ok"><?=Rating::getShareCountByUrl('ok', $url) ?></span>
    </a>

    <a class="custom-like-small" href="http://connect.mail.ru/share?url=<?= $url?>"
       onclick="return openPopup(this);">
        <span class="custom-like-small_icon mailru"></span>
        <span class="custom-like-small_value" id="likes-count-mr"><?=Rating::getShareCountByUrl('mr', $url) ?></span>
    </a>

    <a class="custom-like-small" href="http://vkontakte.ru/share.php?url=<?= $url ?>"
       onclick="return openPopup(this)">
        <span class="custom-like-small_icon vk"></span>
        <span class="custom-like-small_value" id="likes-count-vk">0</span>
    </a>

    <a class="custom-like-small" href="http://www.facebook.com/sharer/sharer.php?u=<?= urlencode($url)?>"
       onclick="return openPopup(this);">
        <span class="custom-like-small_icon fb"></span>
        <span class="custom-like-small_value" id="likes-count-fb">0</span>
    </a>
</div>
<script type="text/javascript">
    $.getJSON("http://graph.facebook.com", { id:"<?=$url ?>" }, function (json) {
        $('#likes-count-fb').html(json.shares || '0');
    });

    VK = {};
    VK.Share = {};
    VK.Share.count = function(index, count){
        $('#likes-count-vk').text(count);
    };
    $.getJSON('http://vkontakte.ru/share.php?act=count&index=1&url=<?= urlencode($url)?>&format=json&callback=?');

    ODKL = {};
    ODKL.updateCountOC = function(index, count){
        $('#likes-count-ok').text(count);
    };
</script>