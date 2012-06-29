<?php
/* @var $this CommunityController
 * @var $data CommunityContent
 */
?>
<?php
    if (Yii::app()->request->getParam('Comment_page', 1) != 1) {
        Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
    }

var_dump(trim(Str::truncate(strip_tags($data->content->text), 90));
    Yii::app()->clientScript->registerMetaTag(trim(Str::truncate(strip_tags($data->content->text), 90)), 'description');
    Yii::app()->clientScript->registerMetaTag('', 'keywords');
?>

<div class="entry<?php if ($full): ?> entry-full<?php endif; ?>">

    <div class="entry-header">
        <?php if ($full): ?>
            <h1><?php echo CHtml::encode($data->title); ?></h1>
        <?php else: ?>
            <?php echo CHtml::link(CHtml::encode($data->title), $data->url, array('class' => 'entry-title')); ?>
        <?php endif; ?>

        <noindex>
            <?php if (! $data->by_happy_giraffe): ?>
                <div class="user">
                    <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $data->contentAuthor, 'friendButton' => true, 'location' => false)); ?>
                </div>
            <?php endif; ?>
            <?php $this->widget('site.frontend.widgets.favoritesWidget.FavouritesWidget', array('model' => $data)); ?>

            <div class="meta">

                <div class="time"><?php echo Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $data->created); ?></div>

                <div class="seen">Просмотров:&nbsp;<span id="page_views"><?php
                    if ($full)
                        echo $views = $this->getViews();
                    else
                        echo $views = PageView::model()->viewsByPath(str_replace('http://www.happy-giraffe.ru', '', $data->url), true);
                    ?></span></div>
                <br/>
                <a href="#comment_list">Комментариев: <?php echo $data->commentsCount; ?></a>
                <?php if($full) { Rating::model()->saveByEntity($data, 'vw', floor($views / 100)); } ?>
            </div>
        </noindex>
        <div class="clear"></div>
    </div>

    <?php if (! $full): ?>
        <div class="entry-content wysiwyg-content">
            <?php
                switch ($data->type->slug)
                {
                    case 'video':
                        $video = new Video($data->video->link);
                        echo $data->preview . '<div style="text-align: center; margin-bottom: 10px;">' . $video->code . '</div>';
                        break;
                    default:
                        echo $data->preview;
                }
            ?>
            <div class="clear"></div>
        </div>
    <?php else: ?>
        <div class="entry-content">
            <div class="wysiwyg-content">
                <?
                switch ($data->type->slug)
                {
                    case 'post':
                        echo $data->post->text;
                        $data_text = $data->post->text;
                        preg_match('!<img.*?src="(.*?)"!', $data_text, $matches);
                        if (count($matches) > 0)
                            $data_image = $matches[1];
                        else
                            $data_image = false;
                        break;
                    case 'video':
                        $video = new Video($data->video->link);
                        echo '<noindex><div style="text-align: center; margin-bottom: 10px;">' . $video->code . '</div></noindex>';
                        echo $data->video->text;
                        $data_text = $data->video->text;
                        $data_image = $video->preview;
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
            <div class="gallery-box">
                <a class="img" data-id="<?=$data->gallery->items[0]->photo->id?>">
                    <?php echo CHtml::image($photo->photo->getPreviewUrl(480, 360, Image::WIDTH)) ?>
                    <div class="title">
                        <i class="icon-play"></i>
                        <div class="title-in">
                            <span><?=CHtml::encode($data->gallery->title)?></span>
                            <?php if(count($data->gallery->items) > 1): ?>
                            еще <?=count($data->gallery->items) - 1?> фотографий
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
            </div>
            <?php
            $this->widget('site.frontend.widgets.photoView.photoViewWidget', array(
                'selector' => '.gallery-box a',
                'entity' => get_class($data->gallery),
                'entity_id' => (int)$data->gallery->primaryKey,
            ));
            ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="entry-footer">
        <?php if(!Yii::app()->user->isGuest): ?>
        <?php
        $report = $this->beginWidget('site.frontend.widgets.reportWidget.ReportWidget', array('model' => $data));
        $report->button("$('.report-container')");
        $this->endWidget();
        ?>
        <?php endif; ?>
        <?php $this->renderPartial('//community/admin_actions',array(
        'c'=>$data,
        'communities'=>Community::model()->findAll(),
    )); ?>
        <?php $this->renderPartial('//community/parts/move_post_popup',array('c'=>$data)); ?>
        <?php if (isset($this->community) && ! $data->isFromBlog && $this->community->id == 22 && Yii::app()->authManager->checkAccess('importCookRecipes', Yii::app()->user->id)): ?>
            <?=CHtml::link('Перенести в рецепты', array('/cook/recipe/import', 'content_id' => $data->id))?>
        <?php endif; ?>

        <?php if ($data->by_happy_giraffe): ?>
            <div class="source">Источник:&nbsp;
                Весёлый Жираф
            </div>
        <?php endif; ?>

        <div class="clear"></div>
    </div>
    <div class="report-container"></div>
</div>

<?php if ($full): ?>
    <?php
        switch ($data->type->slug) {
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
                'title' => CHtml::encode($data->title),
                'image' => isset($data_image) ? $data_image : false,
                'description' => $data_text,
            ),
        )); ?>
    </noindex>
<div>
    <?php if (Yii::app()->user->isGuest) echo SeoHelper::getLinkBock(); ?>
</div>
<?php endif; ?>