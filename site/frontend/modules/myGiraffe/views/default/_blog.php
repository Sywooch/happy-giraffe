<?php
/**
 * @var CommunityContent[] $posts
 * @var User[] $subscribers
 * @var User $user
 * @var int $subscribers_count
 */
$subscribers_count = UserBlogSubscription::model()->subscribersCount($user->id);
$subscribers = UserBlogSubscription::model()->getSubscribers($user->id, 5);
$posts = $user->getLastBlogRecords(2);
$params = array(
    'subscribed'=>UserBlogSubscription::isSubscribed(Yii::app()->user->id, $user->id),
    'count'=>(int)UserBlogSubscription::model()->subscribersCount($user->id),
    'user_id'=>$user->id
);
?>
<div id="js-blog-subs-<?=$user->id ?>" class="blog-preview"<?php
        if (!$params['subscribed']) echo ' data-bind="visible: !isSubscribed()"' ?>>
    <div class="blog-preview_ava-hold">
        <?php $this->widget('Avatar', array('user' => $user)); ?>
    </div>

    <div class="blog-preview_desc">
        <a href="<?=$user->url ?>" class="blog-preview_author textdec-onhover"><?=$user->getFullName() ?></a>
        <h2 class="blog-preview_t"><a href="<?=$user->getBlogUrl() ?>"><?=$user->blog_title ?></a></h2>

        <div class="readers2 readers2__blog-preview" data-bind="visible: count() > 0">
            <div class="clearfix">
                <div class="readers2_count">Все подписчики (<span data-bind="text:count"></span>)</div>
            </div>

            <ul class="readers2_ul clearfix">

                <?php foreach ($subscribers as $subscriber): ?>
                    <li class="readers2_li clearfix">
                        <?php $this->widget('Avatar', array('user' => $subscriber, 'size' => Avatar::SIZE_MICRO)) ?>
                    </li>
                <?php endforeach; ?>

                <li class="readers2_li margin-l10 clearfix" data-bind="visible: count() > 5">
                    <a href="javascript:;">
                        и еще <span data-bind="text:(count() - 5)"></span>
                    </a>
                </li>

            </ul>

        </div>

        <!-- ko if: isSubscribed() -->
        <a href="" class="btn-gray-light btn-medium" data-bind="click:toggleSubscription">Отписаться</a>
        <!-- /ko -->

        <!-- ko if: !isSubscribed() -->
        <a href="" class="btn-green btn-h46" data-bind="click:toggleSubscription">Подписаться</a>
        <!-- /ko -->

    </div>

    <div class="blog-preview_articles">

        <?php foreach ($posts as $model): ?>
            <div class="b-article-prev clearfix">
                <div class="float-l">
                    <div class="like-control like-control__smallest clearfix">
                        <?php $this->widget('application.modules.blog.widgets.LikeWidget', array('model' => $model)); ?>
                        <?php $this->widget('FavouriteWidget', array('model' => $model, 'right' => true)); ?>
                    </div>
                </div>
                <div class="b-article-prev_cont clearfix">
                    <div class="clearfix">
                        <div class="meta-gray">
                            <a href="<?=$model->getUrl() ?>" class="meta-gray_comment">
                                <span class="ico-comment ico-comment__gray"></span>
                                <span class="meta-gray_tx"><?=$model->getUnknownClassCommentsCount() ?></span>
                            </a>
                            <div class="meta-gray_view">
                                <span class="ico-view ico-view__gray"></span>
                                <span class="meta-gray_tx"><?=PageView::model()->viewsByPath($model->getUrl()) ?></span>
                            </div>
                        </div>
                        <div class="float-l">
                            <span class="font-smallest color-gray"><?=HDate::GetFormattedTime($model->created)?></span>
                        </div>
                    </div>
                    <div class="b-article-prev_t clearfix">
                        <?php if ($model->getPhoto() !== null):?>
                            <div class="b-article-prev_t-img">
                                <img alt="" src="<?=$model->getPhoto()->getPreviewUrl(60, 40, false, true) ?>">
                            </div>
                        <?php endif ?>
                        <a href="<?=$model->getUrl() ?>" class="b-article-prev_t-a"><?=$model->title ?></a>
                    </div>
                    <div class="b-article-prev_tx clearfix">
                        <p><?=$model->getContentText(150) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</div>
<script type="text/javascript">
    var subscriptionData = <?=CJSON::encode($params)?>;
    var subscription = new BlogSubscription(subscriptionData);
    ko.applyBindings(subscription, document.getElementById('js-blog-subs-<?=$user->id ?>'));
</script>