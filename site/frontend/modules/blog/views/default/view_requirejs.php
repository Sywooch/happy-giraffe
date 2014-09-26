<?php
/**
 * @var $this DefaultController
 * @var $data BlogContent
 * @var $full bool
 */

Yii::app()->clientScript->useAMD = true;

if (empty($data->source_id))
    $source = $data;
else
    $source = $data->source;

if ($full) {
    if (empty($this->meta_description)){
        if (empty($data->meta_description))
            $this->meta_description = $data->meta_description_auto;
        else
            $this->meta_description = $data->meta_description;
    }
}

switch ($data->type_id) {
    case CommunityContentType::TYPE_STATUS:
        $cssClass = 'b-article__user-status';
        break;
    case CommunityContentType::TYPE_PHOTO:
        $cssClass = $data->contestWork === null ? 'b-article__photopost' : null;
        break;
    case CommunityContentType::TYPE_QUESTION:
        $cssClass = 'b-article__question';
        break;
    default:
        $cssClass = null;
}

if (! isset($showComments))
    $showComments = true;

$gplus = array(
    'https://plus.google.com/102229503737913861260' => array(
        172277,
        169922,
    ),
);

$gplus2 = array(
    'https://plus.google.com/102115350805461891146' => array(
        157262,
    ),
    'https://plus.google.com/115860092477751560643' => array(
        166387,
    ),
);

if ($full) {
    foreach ($gplus as $account => $ids) {
        if (in_array($data->id, $ids)) {
            Yii::app()->clientScript->registerLinkTag('author', null, $account);
        }
    }
}
?>
<div class="b-article clearfix<?php if ($cssClass !== null): ?> <?=$cssClass?><?php endif; ?>" id="blog_settings_<?=$data->id ?>">
    <?php if ($data->source_id) $this->renderPartial('blog.views.default._repost', array('data' => $data)); ?>
    <div class="float-l">
        <?php $this->renderPartial('blog.views.default._post_controls', array('model' => $data->getSourceContent(), 'data' => $data, 'isRepost' => !empty($data->source_id), 'full' => $full)); ?>
    </div>

    <div class="b-article_cont clearfix">
        <div class="b-article_cont-tale"></div>

        <div class="b-article_removed" style="display: none;" data-bind="visible: removed()">
            <div class="b-article_removed-hold">
                <div class="b-article_removed-tx">Ваша запись удалена!</div>
                <a class="b-article_removed-a" data-bind="click: restore">Восстановить</a>
            </div>
        </div>

        <?php $this->renderPartial('blog.views.default._post_header', array('model' => $source, 'full' => $full)); ?>

        <!-- ko stopBinding: true -->

        <?php $this->renderPartial('blog.views.default.types/type_' . $source->type_id, array('data' => $source, 'full' => $full, 'showTitle' => empty($data->source_id) ? true : false, 'show_new' => isset($show_new) ? true : false)); ?>

        <?php
            if ($full) {
                foreach ($gplus2 as $account => $ids) {
                    if (in_array($data->id, $ids)) {
                        echo '<p style="margin-left: 20px;">Автор: ' . CHtml::link($data->author->fullName, $account . '?rel=author', array('target' => '_blank')) . '</p>';
                    }
                }
            }
        ?>

        <?php if ($full && $data->contestWork === null) $this->renderPartial('blog.views.default._likes', array('data' => $source)); ?>

        <?php if ($full): ?>
            <?php $this->beginWidget('AdsWidget'); ?>
            <?php $this->renderPartial('//banners/_post_footer', compact('data')); ?>
            <?php $this->endWidget(); ?>
        <?php endif; ?>

        <?php if ($full && $data->contestWork !== null): ?>
            <?php $this->renderPartial('application.modules.blog.views.default._contest', compact('data')); ?>
        <?php endif; ?>

        <?php if ($full && ! $data->getIsFromBlog()): ?>
            <?php $this->beginWidget('SeoContentWidget'); ?>
                <?php $this->widget('CommunityGalleryWidget', array('content' => $data)); ?>
            <?php $this->endWidget(); ?>
        <?php endif; ?>

        <?php
        /*if (!$full && $showComments)
        {
            $this->widget('site\frontend\modules\comments\widgets\CommentWidget', array('model' => $data));
            //$this->widget('application.widgets.newCommentWidget.NewCommentWidget', array('model' => $data, 'full' => $full));
        }*/
        ?>
        <!-- /ko -->
    </div>
</div>

<?php if ($full): ?>
    <?php $this->widget('blog.widgets.PrevNextWidget', array('post' => $data)); ?>
<?php endif; ?>

<?php if ($full && $data->contestWork !== null): ?>
    <?php $this->renderPartial('application.modules.blog.views.default._contest_bottom', compact('data')); ?>
<?php endif; ?>

<?php if ($full): ?>
    <?php $this->beginWidget('AdsWidget'); ?>
    <?php $this->renderPartial('//banners/_article_banner', compact('data')); ?>
    <?php $this->endWidget(); ?>
<?php endif; ?>

<?php
if ($full)
{
    $this->widget('site\frontend\modules\comments\widgets\CommentWidget', array('model' => $data));
    //$this->widget('application.widgets.newCommentWidget.NewCommentWidget', array('model' => $data, 'full' => $full));
}
?>

<?php if ($full && ! $data->getIsFromBlog()): ?>
    <?php $this->widget('CommunityQuestionWidget', array('forumId' => $this->forum->id)); ?>
<?php endif; ?>

<?php if ($full): ?>
    <?php $this->widget('blog.widgets.PostUsersWidget', array('post' => $data)); ?>
<?php endif; ?>

<?php if (false && $full && ! $data->getIsFromBlog() && $data->rubric->community_id != Community::COMMUNITY_NEWS): ?>
    <?php $this->widget('CommunityMoreWidget', array('content' => $data)); ?>
<?php endif; ?>

<?php $this->widget('application.widgets.seo.SeoLinksWidget'); ?>

<?php
if ($full) {
    $cs = Yii::app()->clientScript;
    $js = "likeControlFixedInBlock('.js-like-control', '.b-article', 80)";
    if($cs->useAMD)
        $cs->registerAMD('likeControlFixedInBlock', array('ko_post'), $js);
    else
        $cs->registerScript('likeControlFixedInBlock', $js, ClientScript::POS_LOAD);
}
?>

<?php if ($ad = $data->isAd()): ?>
<?=$ad['pix']?>
<?php endif; ?>

<?php if ($this->route == 'myGiraffe/default/index' && $index == 2 && ! isset($_GET['page'])): ?>
    <div style="margin: 40px 20px;">
        <script type="text/javascript">
            <!--
            if (typeof(pr) == 'undefined') { var pr = Math.floor(Math.random() * 1000000); }
            if (typeof(document.referrer) != 'undefined') {
                if (typeof(afReferrer) == 'undefined') {
                    afReferrer = escape(document.referrer);
                }
            } else {
                afReferrer = '';
            }
            var addate = new Date();


            var dl = escape(document.location);
            var pr1 = Math.floor(Math.random() * 1000000);

            document.write('<div id="AdFox_banner_'+pr1+'"><\/div>');
            document.write('<div style="visibility:hidden; position:absolute;"><iframe id="AdFox_iframe_'+pr1+'" width=1 height=1 marginwidth=0 marginheight=0 scrolling=no frameborder=0><\/iframe><\/div>');

            AdFox_getCodeScript(1,pr1,'http://ads.adfox.ru/211012/prepareCode?pp=i&amp;ps=bkqy&amp;p2=evor&amp;pct=a&amp;plp=a&amp;pli=a&amp;pop=a&amp;pr=' + pr +'&amp;pt=b&amp;pd=' + addate.getDate() + '&amp;pw=' + addate.getDay() + '&amp;pv=' + addate.getHours() + '&amp;prr=' + afReferrer + '&amp;dl='+dl+'&amp;pr1='+pr1);
            // -->
        </script>
    </div>
<?php endif; ?>