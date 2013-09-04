<div class="entry-header">
    <?php if (!$full): ?>
        <div class="entry-title_hold">
            <a class="entry-title" href="<?=$model->url ?>"><?=$model->title ?></a>
            <?php $this->widget('site.frontend.widgets.favoritesWidget.FavouritesWidget', array('model' => $model)); ?>
        </div>
    <?php else: ?>
        <h1><?= $model->title ?><?php $this->widget('site.frontend.widgets.favoritesWidget.FavouritesWidget', array('model' => $model)); ?></h1>
    <?php endif; ?>

    <noindex>
        <?php if ($show_user): ?>
        <div class="user">
            <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $model->author, 'friendButton' => true, 'location' => false)); ?>
        </div>
        <?php endif; ?>

        <?php $this->widget('FavouriteWidget', compact('model')); ?>

        <div class="meta">
            <div class="time"><?=Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $model->created)?></div>
            <div class="views"><span class="icon"></span> <span><?=($full) ? $this->getViews() : PageView::model()->viewsByPath($model->url)?></span></div>
            <div class="comments">
                <a href="#" class="icon"></a>
                <?php if ($model->commentsCount > 0): ?>
                <?php $lastComments = $model->lastCommentators;
                    foreach ($lastComments as $lc): ?>
                    <?php
                    $class = 'ava small';
                    if ($lc->author->gender !== null) $class .= ' ' . (($lc->author->gender) ? 'male' : 'female');
                    ?>
                    <?=HHtml::link(CHtml::image($lc->author->getAvatarUrl(Avatar::SIZE_MICRO)), ($lc->author->deleted)?'#':$lc->author->url, array('class' => $class), true)?>
                    <?php endforeach; ?>
                <?php if ($model->commentsCount > count($lastComments)): ?>
                    <?=CHtml::link('и еще ' . ($model->commentsCount - count($lastComments)), $model->getUrl(true))?>
                    <?php endif; ?>
                <?php else: ?>
                <?=CHtml::link('Добавить комментарий', $model->getUrl(true))?>
                <?php endif; ?>
            </div>
        </div>
    </noindex>
    <div class="clear"></div>
</div>

<?php if (Yii::app()->controller->route == 'community/view' && false): ?>
    <div class="margin-t20">
        <!-- Яндекс.Директ -->
        <div id="yandex_ad_1"></div>
        <script type="text/javascript">
            (function(w, d, n, s, t) {
                w[n] = w[n] || [];
                w[n].push(function() {
                    Ya.Direct.insertInto(87026, "yandex_ad_1", {
                        site_charset: "utf-8",
                        ad_format: "direct",
                        font_size: 1,
                        type: "horizontal",
                        limit: 1,
                        title_font_size: 3,
                        site_bg_color: "FFFFFF",
                        title_color: "0000CC",
                        url_color: "006600",
                        text_color: "000000",
                        hover_color: "0066FF",
                        favicon: true
                    });
                });
                t = d.getElementsByTagName('head')[0];
                s = d.createElement("script");
                s.type = "text/javascript";
                s.src = "http://an.yandex.ru/system/context.js";
                s.setAttribute("async", "true");
                t.insertBefore(s, t.firstChild);
            })(window, document, "yandex_context_callbacks");
        </script>
    </div>
<?php endif; ?>