<?php $this->beginContent('//layouts/main'); ?>

<?php
$cs = Yii::app()->clientScript;
$cs
    ->registerCssFile('/stylesheets/user.css')
;
?>
    <div id="user">

        <div class="user-cols clearfix">

            <div class="col-1">

                <div class="clearfix user-info-big">
                    <?php
                    $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                        'user' => $this->user,
                        'location' => false,
                        'friendButton' => true,
                        'nav' => true,
                    ));
                    ?>
                </div>

                <div style="margin-bottom: 40px;">
                    <?php $this->renderPartial('//banners/adfox'); ?>
                </div>

                <?php if (Yii::app()->user->id == $this->user->id): ?>
                    <div class="add-post-btn">
                        <?=CHtml::link(CHtml::image('/images/btn_add_post.png'), $this->getUrl(array('content_type_slug' => null), 'blog/add'))?>
                    </div>
                <?php endif; ?>


                <div class="club-topics-list-new">

                    <div class="block-title">О чем мой блог</div>

                    <?php
                    $items = array();
                    foreach ($this->user->blog_rubrics as $rubric) {
                        $items[] = array(
                            'label' => $rubric->title,
                            'url' => $this->getUrl(array('rubric_id' => $rubric->id)),
                            'template' => '<span>{menu}</span>',
                            'active' => $rubric->id == $this->rubric_id,
                        );
                    }

                    $this->widget('zii.widgets.CMenu', array(
                        'items' => $items,
                    ));
                    ?>

                </div>


                <?php if($this->beginCache('blog-popular', array(
                    'duration' => 600,
                    'varyByParam' => array('user_id'),
                ))): ?>

                    <?php if ($this->user->blogPopular): ?>
                        <div class="fast-articles">

                            <div class="block-title">
                                <i class="icon-popular"></i> Самое популярное
                            </div>

                            <ul>
                                <?php foreach ($this->user->blogPopular as $b): ?>
                                    <li>
                                        <div class="item-title"><?=CHtml::link($b->title, $b->url)?></div>
                                        <div class="meta">
                                            <div class="rating"><?=$b->rate?></div>
                                            <span class="views">Просмотров:&nbsp;&nbsp;<?=PageView::model()->viewsByPath($b->url)?></span><br/>
                                            <span class="comments"><?=CHtml::link('Комментариев:&nbsp;&nbsp;' . $b->commentsCount, $b->getUrl(true))?></span>
                                        </div>
                                    </li>
                                <?php endforeach; ?>

                            </ul>

                        </div>
                    <?php endif; ?>

                    <?php $this->endCache(); endif;  ?>

                <div class="readers" id="subscription-info">

                    <div class="block-title"><i class="icon-readers"></i>Постоянные читатели (<span data-bind="text:count"></span>)</div>

                    <!-- ko if: isSubscribed() -->
                    <a href="" data-bind="click:toggleSubscription">Отписаться</a>
                    <!-- /ko -->
                    <!-- ko if: !isSubscribed() -->
                    <a href="" data-bind="click:toggleSubscription">Подписаться</a>
                    <!-- /ko -->

                    <ul class="clearfix">
                        <?php
                        $subscribers = UserBlogSubscription::model()->getSubscribers($this->user->id);
                        ?>
                        <?php foreach ($subscribers as $subscriber): ?>
                            <?php
                            $class = 'ava small';
                            if ($subscriber->gender !== null) $class .= ' ' . (($subscriber->gender) ? 'male' : 'female');
                            ?>
                            <li><?=CHtml::link(CHtml::image($subscriber->getAva('small')), $subscriber->url, array('class' => $class))?></li>
                        <?php endforeach; ?>

                    </ul>
                </div>

                <?php if (false): ?>
                    <div class="banner-box">
                        <a href="<?=$this->createUrl('/contest/default/view', array('id' => 9)) ?>"><img
                                src="/images/contest/banner-w240-9-<?=mt_rand(1, 3)?>.jpg"></a>
                        <?//=$this->renderPartial('//_banner')?>
                    </div>
                <?php endif; ?>

            </div>

            <div class="col-23 clearfix">

                <div class="blog-title"><?=$this->user->getBlogTitle()?><?php if ($this->user->id == Yii::app()->user->id):?> <a href="#blogSettings" class="settings fancy tooltip" title="Настройка блога"></a><?php endif; ?></div>

                <?=$content?>
            </div>

        </div>
    </div>

    <script type="text/javascript">
        function BlogSubscription(subscriptionData){
            var self = this;

            self.subscribed = ko.observable(subscriptionData['subscribed']);
            self.count = ko.observable(subscriptionData['count']);
            self.user_id = ko.observable(subscriptionData['user_id']);

            self.toggleSubscription = function () {
                $.post('/newblog/subscribeToggle/', {user_id: self.user_id()}, function (response) {
                    if (response.status) {
                        if (self.subscribed()){
                            self.subscribed(false);
                            self.count(self.count() - 1);
                        }else{
                            self.subscribed(true);
                            self.count(self.count() + 1);
                        }
                    }
                }, 'json');
            };
            self.isSubscribed = ko.computed(function () {
                return self.subscribed();
            });
        }
        var subscriptionData = <?=CJSON::encode(array(
            'subscribed'=>UserBlogSubscription::isSubscribed(Yii::app()->user->id, $this->user->id),
            'count'=>(int)UserBlogSubscription::model()->subscribersCount($this->user->id),
            'user_id'=>$this->user->id
        ))?>;
        var subscription = new BlogSubscription(subscriptionData);
        ko.applyBindings(subscription, document.getElementById('subscription-info'));
    </script>

<?php $this->endContent(); ?>