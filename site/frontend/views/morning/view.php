<?php
/* @var $this Controller
 * @var $article CommunityContent
 */
?>
<div class="entry">

    <div class="entry-header clearfix">

        <h1><?=$article->title ?></h1>

        <?php if (!empty($article->photoPost->location_image)):?>
            <div class="where">
                <span>Где:</span>

                <div class="map-box"><a target="_blank" href="<?=$article->photoPost->mapUrl ?>"><img src="<?=$article->photoPost->getImageUrl() ?>"></a></div>
            </div>
        <?php endif ?>

        <div class="meta">

            <div
                class="time"><?php echo Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $article->created); ?></div>
            <div class="seen">Просмотров:&nbsp;<span
                id="page_views"><?= $views = PageView::model()->viewsByPath(str_replace('http://www.happy-giraffe.ru', '', $article->url), true); ?></span>
                <?php Rating::model()->saveByEntity($article, 'vw', floor($views / 100)); ?>
            </div>
            <br>
            <a href="#comment_list">Комментариев: <?php echo $article->commentsCount; ?></a>

        </div>

    </div>

    <div class="entry-content">

        <div class="wysiwyg-content">

            <?=Str::strToParagraph($article->preview) ?>

            <?php foreach ($article->photoPost->photos as $photo): ?>
            <p><img src="<?=$photo->url ?>" alt=""></p>
            <?=Str::strToParagraph($photo->text) ?>
            <br>
            <?php endforeach; ?>

        </div>

        <div class="entry-footer">

            <div class="admin-actions">

                <?php if (Yii::app()->user->checkAccess('editMorning')): ?>
                    <?php $edit_url = $this->createUrl('morning/edit', array('id' => $article->id)) ?>
                    <?php echo CHtml::link('<i class="icon"></i>', $edit_url, array('class' => 'edit')); ?>

                <?php $this->widget('site.frontend.widgets.removeWidget.RemoveWidget', array(
                    'model' => $article,
                    'callback' => 'NewsRemove',
                    'author' => Yii::app()->user->id == $article->author_id
                ));
                    $delete_redirect_url = $this->createUrl('/morning/index');

                Yii::app()->clientScript->registerScript('register_after_removeContent', '
                function NewsRemove() {
                    window.location = "' . $delete_redirect_url . '";}', CClientScript::POS_HEAD);
                ?>
                <?php endif; ?>

            </div>

        </div>

    </div>

</div>

<div class="main">
    <div class="main-in">
        <div class="clearfix">

            <?php
            Yii::app()->clientScript
                ->registerScriptFile('http://userapi.com/js/api/openapi.js?49')
                ->registerScript('vk-init', "VK.init({apiId: ".Yii::app()->params['social']['vk']['api_id'].", onlyWidgets: true});", CClientScript::POS_HEAD)
                ->registerCssFile('http://stg.odnoklassniki.ru/share/odkl_share.css')
                ->registerScriptFile('http://stg.odnoklassniki.ru/share/odkl_share.js');

            ?>


            <div id="fb-root"></div>
            <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>

            <script type="text/javascript">
                window.___gcfg = {lang: 'ru'};
                (function() {
                    ODKL.init();
                    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                    po.src = 'https://apis.google.com/js/plusone.js';
                    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                })();
            </script>

            <table width="100%">
                <tr>
                    <td style="vertical-align:top;width:20%">
                        <div id="vk_like"></div>
                        <script type="text/javascript">
                            VK.Widgets.Like("vk_like", {type: "button", height: 20});
                        </script>
                    </td>
                    <td style="vertical-align:top;width:20%">
                        <div class="fb-like" data-send="false" data-layout="button_count" data-width="150" data-show-faces="false" data-action="recommend"></div>
                    </td>
                    <td style="vertical-align:top;width:20%">
                        <a class="odkl-klass-stat" href="http://<?= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"] ?>" onclick="ODKL.Share(this);return false;" ><span>0</span></a>
                    </td>
                    <td style="vertical-align:top;width:20%">
                        <a href="https://twitter.com/share" class="twitter-share-button" data-lang="ru">Твитнуть</a>
                        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                    </td>
                    <td style="vertical-align:top;width:20%">
                        <g:plusone size="medium" annotation="inline" width="120"></g:plusone>
                    </td>
                </tr>
            </table>
        </div>
        <br><br>
        <?php $this->widget('application.widgets.commentWidget.CommentWidget', array(
        'model' => $article,
        )); ?>
        <?php
        $remove_tmpl = $this->beginWidget('site.frontend.widgets.removeWidget.RemoveWidget');
        $remove_tmpl->registerTemplates();
        $this->endWidget();
        ?>

    </div>
</div>
<?php Yii::app()->clientScript->registerScript('scrolled_content', 'initScrolledContent();'); ?>