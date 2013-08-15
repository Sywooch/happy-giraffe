<div class="readers2" id="subscription-info" data-bind="visible: count > 0">
    <?php if (Yii::app()->user->id != $this->user->id):?>
        <!-- ko if: isSubscribed() -->
        <a href="" class="btn-green btn-medium" data-bind="click:toggleSubscription">Отписаться</a>
        <!-- /ko -->
        <!-- ko if: !isSubscribed() -->
        <a href="" class="btn-green btn-medium" data-bind="click:toggleSubscription">Подписаться</a>
        <!-- /ko -->
    <?php endif ?>

    <ul class="readers2_ul clearfix">
        <?php $subscribers = UserBlogSubscription::model()->getSubscribers($this->user->id); ?>
        <?php foreach ($subscribers as $subscriber): ?>
            <li class="readers2_li clearfix">
                <?php $this->widget('UserAvatarWidget', array('user' => $subscriber, 'size' => 24)); ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="clearfix">
        <div class="readers2_count">Все подписчики (<span data-bind="text:count"></span>)</div>
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