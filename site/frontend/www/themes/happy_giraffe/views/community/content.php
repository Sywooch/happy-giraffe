<?php
$cs = Yii::app()->clientScript;

$js = "
    $(document).ready(function() {
        $('.lol').fancybox();
    });";

$cs
    ->registerCssFile('/stylesheets/wym.css')
    ->registerScriptFile('/fancybox/lib/jquery.mousewheel-3.0.6.pack.js')
    ->registerCssFile('/fancybox/source/jquery.fancybox.css?v=2.0.4')
    ->registerScriptFile('/fancybox/source/jquery.fancybox.pack.js?v=2.0.4')
    ->registerCssFile('/fancybox/source/helpers/jquery.fancybox-buttons.css?v=2.0.4')
    ->registerScriptFile('/fancybox/source/helpers/jquery.fancybox-buttons.js?v=2.0.4')
    ->registerCssFile('/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=2.0.4')
    ->registerScriptFile('/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=2.0.4')
    ->registerScript('travel_images', $js);
?>

<?php $this->breadcrumbs = array(
    'Сообщества' => array('community/index'),
    $c->rubric->community->name => array('community/list', 'community_id' => $c->rubric->community->id),
    $c->rubric->name => array('community/list', 'community_id' => $c->rubric->community->id, 'rubric_id' => $c->rubric->id),
    $c->name => array('community/view', 'content_id' => $c->id),
); ?>

<?php $this->renderPartial('parts/left', array(
    'community' => $c->rubric->community,
    'content_type' => $c->type,
    'content_types' => $content_types,
    'current_rubric' => $c->rubric->id,
)); ?>

<div class="right-inner">
<div class="entry entry-full" id="CommunityContent_<?php echo $c->id; ?>">

    <div class="entry-header">
        <h1><?php echo $c->name; ?></h1>
        <?php if (!$c->by_happy_giraffe): ?>
        <div class="user">
            <?php $this->widget('AvatarWidget', array('user' => $c->contentAuthor)); ?>
            <a class="username"><?php echo $c->contentAuthor->first_name; ?></a>
        </div>
        <?php endif; ?>

        <div class="meta">
            <div
                class="time"><?php echo Yii::app()->dateFormatter->format("dd MMMM yyyy, HH:mm", strtotime($c->created)); ?></div>
            <div class="seen">Просмотров:&nbsp;<span id="page_views"><?php echo $this->views; ?></span></div>
            <?php Rating::model()->saveByEntity($c, 'rt', floor($this->views / 100)); ?>

        </div>
        <div class="clear"></div>
    </div>

    <div class="entry-content">
        <?
        switch ($c->type->slug)
        {
            case 'post':
                echo $c->post->text;
                $c_text = $c->post->text;
                preg_match('!<img.*?src="(.*?)"!', $c_text, $matches);
                if (count($matches) > 0)
                    $c_image = $matches[1];
                else
                    $c_image = false;
                break;
            case 'video':
                $video = new Video($c->video->link);
                echo '<noindex><div style="text-align: center; margin-bottom: 10px;">' . $video->code . '</div></noindex>';
                echo $c->video->text;
                $c_text = $c->video->text;
                $c_image = $video->preview;
                break;
            case 'travel':
                if ($c->travel->waypoints) {
                    $icon = new EGMapMarkerImage('/images/map_marker.png');
                    $icon->setSize(20, 32);

                    $gMap = new EGMap();
                    $gMap->width = '100%';
                    $gMap->height = '325';
                    $gMap->zoom = (count($c->travel->waypoints) == 1) ? 5 : 2;
                    $incLat = 0;
                    $incLng = 0;
                    foreach ($c->travel->waypoints as $w)
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
                    $centerLat = $incLat / count($c->travel->waypoints);
                    $centerLng = $incLng / count($c->travel->waypoints);
                    $gMap->setCenter($centerLat, $centerLng);

                    $gMap->renderMap();
                    ?>
                    <ul class="tr_map">
                        <li>
                            <ins>Посетили:</ins>
                        </li>
                        <li>
                            <ul>
                                <?php $i = 0; foreach ($c->travel->waypoints as $w): ?>
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
                echo $c->travel->text;
                ?>
                    <div class="clear"></div>
                    <div class="travel_photo">
                        <ul class="photo-list">
                            <?php foreach ($c->travel->images as $i): ?>
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

        <?php if (Yii::app()->user->checkAccess('editCommunityContent', array('community_id'=>$c->rubric->community->id,'user_id'=>$c->contentAuthor->id))): ?>
        <?php echo CHtml::link('редактировать', ($c->type->slug == 'travel') ? $this->createUrl('community/editTravel', array('id' => $c->id)) : $this->createUrl('community/edit', array('content_id' => $c->id))); ?>
        <?php endif; ?>
        <?php if (Yii::app()->user->checkAccess('removeCommunityContent', array('community_id'=>$c->rubric->community->id,'user_id'=>$c->contentAuthor->id))): ?>
        <?php echo CHtml::link('удалить', $this->createUrl('#', array('id' => $c->id)), array('id' => 'CommunityContent_delete_' . $c->id, 'submit' => array('community/delete', 'id' => $c->id), 'confirm' => 'Вы точно хотите удалить тему?')); ?>
        <?php endif; ?>
        <div class="clear"></div>
    </div>

    <div class="entry-footer">
        <?php if (($c->type->slug == 'post' AND in_array($c->post->source_type, array('book', 'internet'))) OR $c->by_happy_giraffe): ?>
        <div class="source">Источник:&nbsp;
            <?php if ($c->by_happy_giraffe): ?>
                Весёлый Жираф
                <?php else: ?>
                <?php switch ($c->post->source_type):
                    case 'book':
                        ?>
                            <?php echo $c->post->book_author ?>&nbsp;<?= $c->post->book_name
                        ; ?>
                            <?php break; ?>
                            <?php
                    case 'internet': ?>
                        <?php echo CHtml::image(Yii::app()->request->baseUrl . '/upload/favicons/' . $c->post->internet_favicon, $c->post->internet_title); ?>
                        &nbsp;<?php echo CHtml::link($c->post->internet_title, $c->post->internet_link, array('class' => 'link')); ?>
                        <?php break; ?>
                        <?php endswitch; ?>
                <?php endif; ?>
        </div>
        <?php endif; ?>
        <span class="comm">Комментариев: <span><?php echo $c->commentsCount; ?></span></span>

        <div class="spam">
            <?php $report = $this->beginWidget('site.frontend.widgets.reportWidget.ReportWidget', array('model' => $c));
            $report->button("$(this).parents('.entry')");
            $this->endWidget(); ?>
        </div>
        <div class="clear"></div>
    </div>
</div>
<?php
switch ($c->type->slug) {
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
    'model' => $c,
    'options' => array(
        'title' => $c->name,
        'image' => $c_image,
        'description' => $c_text,
    ),
)); ?>

<?php /*$this->widget('site.frontend.widgets.fileAttach.FileAttachWidget', array(
    'model' => $c,
));*/ ?>

<?php if ($related): ?>
<div class="more">
    <big class="title">
        Ещё на эту тему
        <a href="<?php echo $this->createUrl('community/list', array('community_id' => $c->rubric->community->id, 'rubric_id' => $c->rubric->id)); ?>"
           class="btn btn-blue-small"><span><span>Показать все</span></span></a>
    </big>
    <?php
    foreach ($related as $rc)
    {
        $content = '';
        switch ($rc->type->slug)
        {
            case 'post':
                if (preg_match('/src="([^"]+)"/', $rc->post->text, $matches)) {
                    $content = '<img src="' . $matches[1] . '" alt="' . $rc->name . '" width="150" />';
                }
                else
                {
                    if (preg_match('/<p>(.+)<\/p>/Uis', $rc->post->text, $matches2)) {
                        $content = strip_tags($matches2[1]);
                    }
                }
                break;
            case 'travel':
                if (preg_match('/src="([^"]+)"/', $rc->travel->text, $matches)) {
                    $content = '<img src="' . $matches[1] . '" alt="' . $rc->name . '" width="150" />';
                }
                else
                {
                    if (preg_match('/<p>(.+)<\/p>/Uis', $rc->travel->text, $matches2)) {
                        $content = strip_tags($matches2[1]);
                    }
                }
                break;
            case 'video':
                $video = new Video($rc->video->link);
                $content = '<img src="' . $video->preview . '" alt="' . $video->title . '" />';
                break;
        }

        ?>
        <div class="block">
            <b><?php echo CHtml::link($rc->name, $this->createUrl('community/view', array('community_id' => $c->rubric->community->id, 'content_type_slug' => $rc->type->slug, 'content_id' => $rc->id))); ?></b>

            <p><?php echo $content; ?></p>
        </div>
        <?php
    }
    ?>
    <div class="clear"></div>
</div>
    <?php endif; ?>

<?php $this->widget('application.widgets.commentWidget.CommentWidget', array(
    'model' => $c,
)); ?>
</div>
<?php $remove_tmpl = $this->beginWidget('site.frontend.widgets.removeWidget.RemoveWidget');
    $remove_tmpl->registerTemplates();
$this->endWidget();
?>