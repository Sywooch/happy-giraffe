<?php
/**
 * Author: alexk984
 * Date: 06.02.13
 *
 * @var $post CommunityContent
 */
?>

<div class="valentine-spent">
    <h2 class="valentine-spent_t">Как провести <br>День святого Валентина</h2>
    <a href="" class="valentine-spent_img">
    <?php
    $photo = $post->gallery->items[0];

    $this->widget('site.frontend.widgets.photoView.photoViewWidget', array(
        'selector' => '.gallery-box a',
        'entity' => get_class($post->gallery),
        'entity_id' => (int)$post->gallery->primaryKey,
    ));
    if (isset($_GET['utm_source']) && $_GET['utm_source'] == 'email'){
        Yii::app()->clientScript->registerScript('open_pGallery','$("i.icon-play").trigger("click");', CClientScript::POS_READY);
    }
    ?>
    </a>
    <div class="valentine-spent_p"><?=$post->getContent()->text ?></div>
</div>