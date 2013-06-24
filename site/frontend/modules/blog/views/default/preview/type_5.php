<?php
/**
 * @var $this DefaultController
 * @var $data BlogContent
 * @var $full bool
 */

$status = $data->getStatus();
?><div class="b-article b-article__user-status clearfix">
    <div class="float-l">
        <?php $this->renderPartial('preview/_post_controls', array('model' => $data)); ?>
    </div>
    <div class="b-article_cont clearfix">
        <div class="b-article_cont-tale"></div>

        <?php $this->renderPartial('_post_header', array('model' => $data)); ?>

        <div class="b-article_in clearfix">
            <div class="b-article_user-status clearfix">
                <a href="<?=$data->getUrl() ?>" class="b-article_user-status-a"><?=strip_tags($data->status->status->text) ?></a>
            </div>
        </div>

        <?php $this->widget('application.widgets.newCommentWidget.NewCommentWidget', array('model' => $data, 'full' => $full)); ?>

    </div>
</div>