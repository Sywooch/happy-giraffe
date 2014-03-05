<?php
/*
 * @var $data CommunityContent
 * @var $full boolean
 */
if (get_class($data) == 'CommunityContent' || get_class($data) == 'BlogContent') {
    $entity = $data->isFromBlog ? 'BlogContent' : 'CommunityContent';
} elseif (get_parent_class($data) == 'CookRecipe') {
    $entity = 'CookRecipe';
} else {
    $entity = get_class($data);
}
?>

<div class="entry_h clearfix">
    <h1 class="entry_h1"><?=CHtml::link($data->title, $data->url)?></h1>
    <div class="entry_meta">
        <?php if ($data->getUnknownClassCommentsCount() > 0): ?>
            <a href="<?=$this->createUrl('/site/comments', array('entity' => $entity, 'entity_id' => $data->id))?>" class="entry_comments"><i class="ico-comment-small"></i> <?=$data->getUnknownClassCommentsCount()?></a>
        <?php endif; ?>
        <div class="entry_views"><i class="ico-eye-small"></i> <?=($full) ? $this->getViews() : PageView::model()->viewsByPath($data->url)?></div>
    </div>
    <div class="entry_user clearfix">
        <div class="user-info">
            <?php $this->widget('AvatarWidget', array('user' => $data->author)); ?>
            <div class="user-info_details">
                <?=CHtml::link($data->author->fullName, array('user/index', 'user_id' => $data->author_id, 'show' => 'all'), array('class' => 'user-info_name textdec-onhover'))?>
                <div class="user-info_time"><?=HDate::GetFormattedTime($data->created, ', ')?></div>
            </div>
        </div>
    </div>
</div>

<?php if ($full): ?>
<div class="textalign-c" style="margin: 15px 0;">
    <div class="display-ib">
        <!-- ﬂÌ‰ÂÍÒ.ƒËÂÍÚ -->
        <div id="yandex_ad"></div>
        <script type="text/javascript">
            (function(w, d, n, s, t) {
                w[n] = w[n] || [];
                w[n].push(function() {
                    Ya.Direct.insertInto(87026, "yandex_ad", {
                        ad_format: "direct",
                        type: "300x300",
                        border_type: "block",
                        site_bg_color: "FFFFFF",
                        border_color: "FBE5C0",
                        title_color: "289FD7",
                        url_color: "006600",
                        text_color: "000000",
                        hover_color: "2289BA",
                        no_sitelinks: true
                    });
                });
                t = d.getElementsByTagName("script")[0];
                s = d.createElement("script");
                s.src = "//an.yandex.ru/system/context.js";
                s.type = "text/javascript";
                s.async = true;
                t.parentNode.insertBefore(s, t);
            })(window, document, "yandex_context_callbacks");
        </script>
    </div>
</div>
<?php endif; ?>