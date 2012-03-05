<div class="entry<?php if ($full): ?> entry-full<?php endif; ?>">

    <div class="entry-header">
        <?php echo CHtml::link($data->name, $data->url, array('class' => 'entry-title')); ?>
        <?php if (! $data->by_happy_giraffe): ?>
            <div class="user">
                <?php $this->widget('AvatarWidget', array('user' => $data->contentAuthor)); ?>
                <a class="username" href="<?php echo $data->contentAuthor->profileUrl; ?>"><span class="icon-status status-online"></span><?php echo $data->contentAuthor->fullName; ?></a>
            </div>
        <?php endif; ?>

        <div class="meta">

            <div class="time"><?php echo Yii::app()->dateFormatter->format("dd MMMM yyyy, HH:mm", $data->created); ?></div>
            <div class="seen">Просмотров:&nbsp;<span id="page_views"><?php echo PageView::model()->viewsByPath($this->url, true); ?></span></div>
            <?php if (! $full): ?><div class="rate"><?php echo Rating::model()->countByEntity($data); ?></div>
            рейтинг<?php endif; ?>
        </div>
        <div class="clear"></div>
    </div>

    <?php if (! $full): ?>
        <div class="entry-content">
            <?php
            switch ($data->type->slug)
            {
                case 'post':
                    if ($data->post === null)
                        $data->post = new CommunityPost();
                    $pos = strpos($data->post->text, '<!--more-->');
                    echo '<noindex>';
                    echo $pos === false ? $data->post->text : substr($data->post->text, 0, $pos);
                    echo '</noindex>';
                    break;
                case 'travel':
                    $pos = strpos($data->travel->text, '<!--more-->');
                    echo '<noindex>';
                    echo $pos === false ? $data->travel->text : substr($data->travel->text, 0, $pos);
                    echo '</noindex>';
                    break;
                case 'video':
                    $video = new Video($data->video->link);
                    echo '<noindex><div style="text-align: center; margin-bottom: 10px;">' . $video->code . '</div></noindex>';
                    echo $data->video->text;
                    break;
            }
            ?>
            <div class="clear"></div>
        </div>
    <?php else: ?>
        <div class="entry-content">
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
    <?php endif; ?>

    <div class="entry-footer">
        <span class="comm">Комментариев: <span><?php echo $data->commentsCount; ?></span></span>

        <?php $this->renderPartial('admin_actions',array(
        'c'=>$data,
        'communities'=>Community::model()->findAll(),
    )); ?>
        <?php $this->renderPartial('parts/move_post_popup',array('c'=>$data)); ?>

        <?php if (($data->type->slug == 'post' AND in_array($data->post->source_type, array('book', 'internet'))) OR $data->by_happy_giraffe): ?>
            <div class="source">Источник:&nbsp;
                <?php if ($data->by_happy_giraffe): ?>
                    Весёлый Жираф
                    <?php else: ?>
                    <?php switch($data->post->source_type):
                        case 'book': ?>
                            <?php echo $data->post->book_author?>&nbsp;<?=$data->post->book_name; ?>
                            <?php break; ?>
                            <?php case 'internet': ?>
                            <?php echo CHtml::image(Yii::app()->request->baseUrl . '/upload/favicons/' . $data->post->internet_favicon, $data->post->internet_title); ?>&nbsp;<?php echo CHtml::link($data->post->internet_title, $data->post->internet_link, array('class' => 'link')); ?>
                            <?php break; ?>
                            <?php endswitch; ?>
                    <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="clear"></div>
    </div>
</div>

<?php if ($full): ?>
    <?php
        switch ($data->type->slug) {
            case 'travel':
                $like_title = 'Интересное путешествие?';
                break;
            case 'post':
                $like_title = 'Вам понравилась статья? Отметьте!';
                break;
            case 'video':
                $like_title = 'Вам понравилось видео? Отметьте!';
                break;
        }
    ?>
<?php $this->widget('site.frontend.widgets.socialLike.SocialLikeWidget', array(
    'title' => $like_title,
    'model' => $data,
    'options' => array(
        'title' => $data->name,
        'image' => $data_image,
        'description' => $data_text,
    ),
)); ?>
<?php endif; ?>