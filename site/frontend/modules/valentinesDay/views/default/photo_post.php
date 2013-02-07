<?php
/**
 * Author: alexk984
 * Date: 06.02.13
 *
 * @var $post CommunityContent
 */
?>
<div class="content-cols margin-t20 clearfix">
    <div class="col-1">
        <?php $this->renderPartial('menu'); ?>
    </div>
    <div class="col-12">
        <div class="valentine-spent">
            <h2 class="valentine-spent_t">Как провести <br>День святого Валентина</h2>
            <a href="javascript:;" class="valentine-spent_img" data-id="<?=$post->gallery->items[0]->photo->id?>">
                <img src="/images/valentine-day/valentine-spent_img-2.png" alt="">
                <?php
                $text = $post->post->purified->text;
                $text = str_replace('<!--gallery-->', '', $text);

                $this->widget('site.frontend.widgets.photoView.photoViewWidget', array(
                    'selector' => 'a.valentine-spent_img',
                    'entity' => get_class($post->gallery),
                    'entity_id' => (int)$post->gallery->primaryKey,
                ));
                if (isset($_GET['utm_source']) && $_GET['utm_source'] == 'email' || (isset($_GET['open']) && $_GET['open'] == 1)){
                    Yii::app()->clientScript->registerScript('open_pGallery','$("a.valentine-spent_img").trigger("click");', CClientScript::POS_READY);
                }
                ?>
            </a>
            <div class="valentine-spent_p"><?=$text ?></div>
        </div>

        <noindex>
            <?php $this->widget('site.frontend.widgets.socialLike.SocialLikeWidget', array(
            'title' => 'Вам понравилась статья? Отметьте!',
            'notice' => '<big>Рейтинг статьи</big><p>Он показывает, насколько нравится ваша статья другим пользователям. Если статья интересная, то пользователи её читают, комментируют, увеличивают лайки социальных сетей.</p>',
            'model' => $post,
            'type' => 'simple',
            'options' => array(
                'title' => $post->title,
                'image' => $post->getContentImage(),
                'description' => $post->getContent()->text,
            ),
        )); ?>
        </noindex>

        <?php $this->widget('application.widgets.commentWidget.CommentWidget', array('model' => $post)); ?>
    </div>
</div>