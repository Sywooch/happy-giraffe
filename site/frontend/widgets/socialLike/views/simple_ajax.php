<?php
if(isset($this->model) && method_exists($this->model, 'isValentinePost') && $this->model->isValentinePost()){
    //костыль для валентина 2
   $url = $this->model->getUrl(false, true);
} elseif (!empty($this->url)){
    $url = $this->url;
}else
    $url = 'http://' . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
?>
<script type="text/javascript">
    $('.vk_share_button').html(VK.Share.button('<?= $url?>',{type: 'round', text: 'Мне нравится'}));
</script>
<div class="like-block fast-like-block">
    <div class="box-2">
        <?php
        $this->render('_yh_min', array(
            'options' => $this->providers['yh'],
        ));
        ?>
    </div>

    <div class="box-1">

        <div class="share_button">
            <div class="fb-custom-like">
                <?=HHtml::link('<i class="icon-fb"></i>Мне нравится',
                    'http://www.facebook.com/sharer/sharer.php?u='.urlencode($url),
                    array('class'=>'fb-custom-text', 'onclick'=>'return Social.showFacebookPopup(this);'), true) ?>
                <div class="fb-custom-share-count ajax-el">0</div>
                <script type="text/javascript">
                    $.getJSON("http://graph.facebook.com", { id:"<?=$url ?>" }, function (json) {
                        $('.fb-custom-share-count.ajax-el').html(json.shares || '0');
                    });
                </script>
            </div>
        </div>

        <div class="share_button">
            <div class="vk_share_button"></div>
        </div>

        <div class="share_button">
            <a class="odkl-klass-oc" href="<?=$url?>"
               onclick="Social.updateLikesCount('ok'); ODKL.Share(this);return false;"><span>0</span></a>
        </div>

        <div class="share_button">
            <div class="tw_share_button">
                <a href="https://twitter.com/share" class="twitter-share-button" data-lang="ru" data-url="<?=$url?>">Твитнуть</a>
                <script type="text/javascript">
                    twttr.widgets.load();
                </script>
            </div>
        </div>
    </div>

    <div class="box-3">
        <div class="rating"><span><?= Rating::model()->countByEntity($this->model, false) ?></span></div>
        <?php if ($this->notice != ''): ?>
        <div class="icon-info">
            <div class="tip">
                <?= $this->notice; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

</div>