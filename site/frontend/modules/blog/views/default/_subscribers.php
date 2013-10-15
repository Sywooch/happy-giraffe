<div class="readers2" id="subscription-info">
    <?php if (Yii::app()->user->id != $this->user->id):?>
        <!-- ko if: isSubscribed() -->
        <a href="" class="btn-green btn-medium" data-bind="click:toggleSubscription">Отписаться</a>
        <!-- /ko -->
        <!-- ko if: !isSubscribed() -->
        <a href="" class="btn-green btn-medium" data-bind="click:toggleSubscription">Подписаться</a>
        <!-- /ko -->
    <?php endif ?>

    <ul class="readers2_ul clearfix">
        <?php $subscribers = UserBlogSubscription::model()->getSubscribers($this->user->id, 6); ?>
        <?php foreach ($subscribers as $subscriber): ?>
            <li class="readers2_li clearfix">
                <?php $this->widget('Avatar', array('user' => $subscriber, 'size' => 24)); ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="clearfix">
        <div class="readers2_count">Все подписчики (<span data-bind="text:count"></span>)</div>
    </div>
</div>
<script type="text/javascript">
    var subscriptionData = <?=CJSON::encode(array(
            'subscribed'=>UserBlogSubscription::isSubscribed(Yii::app()->user->id, $this->user->id),
            'count'=>(int)UserBlogSubscription::model()->subscribersCount($this->user->id),
            'user_id'=>$this->user->id
        ))?>;
    var subscription = new BlogSubscription(subscriptionData);
    ko.applyBindings(subscription, document.getElementById('subscription-info'));
</script>