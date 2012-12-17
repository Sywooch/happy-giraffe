<?php
/* @var $this CommunityController
 * @var $data CommunityContent
 */

    if (Yii::app()->request->getParam('Comment_page', 1) != 1) {
        Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
    }

    if ($full) {
        if (empty($this->meta_description)){
            if (!empty($data->meta_description))
                $this->meta_description = $data->meta_description;
            else
                $this->meta_description = Str::getDescription($data->getContent()->text);
        }
    }
?>
<div class="entry<?php if ($full): ?> entry-full<?php endif; ?>">

    <div class="entry-header">
        <?php if ($full): ?>
            <h1><?= $data->title ?></h1>
        <?php else: ?>
            <?= CHtml::link($data->title, $data->url, array('class' => 'entry-title')); ?>
        <?php endif; ?>

        <noindex>
            <?php if ($data->isFromBlog || $data->rubric->community_id != Community::COMMUNITY_NEWS): ?>
                <div class="user">
                    <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $data->contentAuthor, 'friendButton' => true, 'location' => false)); ?>
                </div>
            <?php endif; ?>
            <?php $this->widget('site.frontend.widgets.favoritesWidget.FavouritesWidget', array('model' => $data)); ?>

            <div class="meta">
                <div class="time"><?=Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $data->created)?></div>
                <div class="views"><span href="#" class="icon"></span> <span><?=($full) ? $this->getViews() : PageView::model()->viewsByPath(str_replace('http://www.happy-giraffe.ru', '', $data->url), true)?></span></div>
                <div class="comments">
                    <a href="#" class="icon"></a>
                    <?php if ($data->getArticleCommentsCount() > 0): ?>
                        <?php $lastComments = $data->lastCommentators; foreach ($lastComments as $lc): ?>
                            <?php
                                $class = 'ava small';
                                if ($lc->author->gender !== null) $class .= ' ' . (($lc->author->gender) ? 'male' : 'female');
                            ?>
                            <?=HHtml::link(CHtml::image($lc->author->getAva('small')), ($lc->author->deleted)?'#':$lc->author->url, array('class' => $class), true)?>
                        <?php endforeach; ?>
                        <?php if ($data->getArticleCommentsCount() > count($lastComments)): ?>
                            <?=CHtml::link('и еще ' . ($data->getArticleCommentsCount() - count($lastComments)), $data->getUrl(true))?>
                        <?php endif; ?>
                    <?php else: ?>
                        <?=CHtml::link('Добавить комментарий', $data->getUrl(true))?>
                    <?php endif; ?>
                </div>
            </div>
        </noindex>
        <div class="clear"></div>
    </div>

    <?php if (! $full): ?>
        <?php if ($data->type_id == 5): ?>
            <div class="entry-content user-status">
                <?=CHtml::link($data->status->status->text, $data->url)?>
            </div>
        <?php else: ?>
            <div class="entry-content wysiwyg-content">
                <?php
                    switch ($data->type->slug)
                    {
                        case 'video':
                            echo $data->purified->preview . '<div style="text-align: center; margin-bottom: 10px;">' . $data->video->getEmbed() . '</div>';
                            break;
                        default:
                            echo $data->purified->preview;
                    }
                ?>
                <?php if ($data->type_id != 5 && ($data->isFromBlog || $data->rubric->community_id == Community::COMMUNITY_NEWS)): ?>
                    <?=CHtml::link('Читать всю запись<i class="icon"></i>', $data->url, array('class' => 'read-more'))?>
                <?php endif; ?>
                <div class="clear"></div>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <?php if ($data->type_id == 5): ?>
            <div class="entry-content user-status">
                <?=$data->status->status->text?>
            </div>
        <?php else: ?>
            <div class="entry-content">
                <div class="wysiwyg-content">
                    <?
                    switch ($data->type->slug)
                    {
                        case 'status':
                            echo $data->status->status->text;
                            break;
                        case 'post':
                            $text = $data->post->purified->text;
                            if ($data->gallery !== null && count($data->gallery->items) > 0) {
                                $gallery = Yii::app()->controller->renderPartial('/community/_gallery', array('data' => $data), true);
                                if (strpos($text, '<!--gallery-->') === false) {
                                    $text = $text . $gallery;
                                } else {
                                    $text = str_replace('<!--gallery-->', $gallery, $text);
                                }
                            }
                            echo $text;
                            break;
                        case 'video':
                            echo '<noindex><div style="text-align: center; margin-bottom: 10px;">' . $data->video->getEmbed() . '</div></noindex>';
                            echo $data->video->purified->text;
                            break;
                        case 'travel':
                            if ($data->travel->waypoints) {
                                $icon = new EGMapMarkerImage('/images/map_marker.png');
                                $icon->setSize(20, 32);

                                $gMap = new EGMap();
                                $gMap->width = '100%';
                                $gMap->height = '325';
                                $gMap->zoom = (count($data->travel->waypoints) == 1) ? 5 : 2;
                                $incLat = 0;
                                $incLng = 0;
                                foreach ($data->travel->waypoints as $w)
                                {
                                    $address = $w->country->name . ', ' . $w->city->name;
                                    $geocoded_address = new EGMapGeocodedAddress($address);
                                    $geocoded_address->geocode($gMap->getGMapClient());
                                    $gMap->addMarker(
                                        new EGMapMarker($geocoded_address->getLat(), $geocoded_address->getLng(), array('title' => 'a', 'icon' => $icon))
                                    );
                                    $incLat += $geocoded_address->getLat();
                                    $incLng += $geocoded_address->getLng();
                                }
                                $dataenterLat = $incLat / count($data->travel->waypoints);
                                $dataenterLng = $incLng / count($data->travel->waypoints);
                                $gMap->setCenter($dataenterLat, $dataenterLng);

                                $gMap->renderMap();
                                ?>
                                <ul class="tr_map">
                                    <li>
                                        <ins>Посетили:</ins>
                                    </li>
                                    <li>
                                        <ul>
                                            <?php $i = 0; foreach ($data->travel->waypoints as $w): ?>
                                            <li><?php echo $w->country_name; ?> -
                                                <span><?php echo ++$i; ?></span> <?php echo $w->city_name; ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </li>
                                </ul>
                                <?php
                            }
                            ?>
                                <div class="clear"></div>

                                <?php
                                $data_text = $data->travel->text;
                            echo $data->travel->text;
                            ?>
                                <div class="clear"></div>
                                <div class="travel_photo">
                                    <ul class="photo-list">
                                        <?php foreach ($data->travel->images as $i): ?>
                                        <li>
                                            <div class="img-box">
                                                <?php echo CHtml::link(CHtml::image($i->getUrl('thumb')), $i->getUrl('original'), array(
                                                'class' => 'lol',
                                                'rel' => 'group',
                                            )); ?>
                                            </div>
                                        </li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <div class="clear"></div>
                                    <!-- .clear -->
                                </div><!-- .travel_photo -->
                                <?php
                            break;
                    }
                    ?>

                    <div class="clear"></div>
                </div>

                <?php if($data->gallery !== null && count($data->gallery->items) > 0): ?>
                    <?php $photo = $data->gallery->items[0]; ?>
                    <?php
                    $this->widget('site.frontend.widgets.photoView.photoViewWidget', array(
                        'selector' => '.gallery-box a',
                        'entity' => get_class($data->gallery),
                        'entity_id' => (int)$data->gallery->primaryKey,
                    ));
                    if (isset($_GET['utm_source']) && $_GET['utm_source'] == 'email'){
                        Yii::app()->clientScript->registerScript('open_pGallery','$("i.icon-play").trigger("click");', CClientScript::POS_READY);
                    }

                ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($data->type_id != 5): ?>
        <div class="entry-footer">
            <?php if(!Yii::app()->user->isGuest && $full){
                $report = $this->beginWidget('site.frontend.widgets.reportWidget.ReportWidget', array('model' => $data));
                $report->button("$('.report-container')");
                $this->endWidget();
            }

            $this->renderPartial('//community/admin_actions',array(
                'c'=>$data,
            ));

            $this->renderPartial('//community/parts/move_post_popup',array('c'=>$data));

            if (isset($this->community) && ! $data->isFromBlog && $this->community->id == 22 && Yii::app()->authManager->checkAccess('importCookRecipes', Yii::app()->user->id))
                echo CHtml::link('Перенести в рецепты', array('/cook/recipe/import', 'content_id' => $data->id));

            ?>

            <div class="clear"></div>
        </div>
    <?php endif; ?>
    <div class="report-container"></div>
</div>

<?php if ($full): ?>
    <?php
        switch ($data->type->slug) {
            case 'status':
                $like_title = 'Вам понравился статус? Отметьте!';
                $like_notice = '<big>Рейтинг статуса</big><p>Он показывает, насколько нравится ваш статус другим пользователям. Если статус интересный, то пользователи его читают, комментируют, увеличивают лайки социальных сетей.</p>';
            case 'post':
                $like_title = 'Вам понравилась статья? Отметьте!';
                $like_notice = '<big>Рейтинг статьи</big><p>Он показывает, насколько нравится ваша статья другим пользователям. Если статья интересная, то пользователи её читают, комментируют, увеличивают лайки социальных сетей.</p>';
                break;
            case 'video':
                $like_title = 'Вам полезно видео? Отметьте!';
                $like_notice = '<big>Рейтинг видео</big><p>Он показывает, насколько нравится ваше видео другим пользователям. Если видео интересное, то пользователи его смотрят, комментируют, увеличивают лайки социальных сетей.</p>';
                break;
            case 'travel':
                $like_title = 'Вам полезен рассказ?';
                $like_notice = '<big>Рейтинг путешествия</big><p>Он показывает, насколько нравится ваш рассказ другим пользователям. Если рассказ интересен, то пользователи его читают, комментируют, увеличивают лайки социальных сетей.</p>';
                break;
        }
    ?>
    <noindex>
        <?php $this->widget('site.frontend.widgets.socialLike.SocialLikeWidget', array(
            'title' => $like_title,
            'notice' => $like_notice,
            'model' => $data,
            'type' => 'simple',
            'options' => array(
                'title' => $data->title,
                'image' => $data->getContentImage(),
                'description' => $data->getContent()->text,
            ),
        )); ?>
    </noindex>
<div>
    <?php //if (Yii::app()->user->isGuest) echo SeoHelper::getLinkBock(); ?>
</div>
<?php endif; ?>