<?php
//Yii::app()->clientScript->registerPackage('ko_friends');
?><div id="friendsList" class="friends-list friends-list__family margin-t20">
    <!-- ko template: { name : 'request-template', foreach : users } -->

    <!-- /ko -->

    <div id="infscr-loading" data-bind="visible: loading"><img src="/images/ico/ajax-loader.gif" alt="Loading..."><div>Загрузка</div></div>
</div>
<script type="text/javascript">
    require(['knockout', 'ko_friends'], function(ko) {
        var FriendsViewModel = function(){
            var self = this;

            self.loading = ko.observable(false);
            self.loaded = ko.observable(false);
            self.currentPage = ko.observable(0);
            self.users = ko.observableArray([]);

            self.pageCount = ko.observable(null);
            self.perPage = ko.observable(15);
            self.continueLoading = ko.observable(true);

            self.load = function() {
                var data = {page: self.currentPage()};

                self.loading(true);
                $.get('/user/<?=$this->user->id ?>/friends/', data, function(response) {
                    var mData = self.users;
                    // Оригинальный способ
                    //                self.users.push.apply(self.users, ko.utils.arrayMap(response.users, function(user) {
                    //                    return new OutgoingFriendRequest(user, self);
                    //                }));
                    // Альтернативный способ обновления observableArray через mutated
                    ko.utils.arrayForEach(response.users, function(user) {
                        mData.push(new OutgoingFriendRequest(user, self));
                    });
                    self.users.valueHasMutated();

                    self.currentPage(self.currentPage()+1);
                    self.continueLoading(response.users.length>0 && response.users.length<=self.perPage());
                    self.loading(false);
                    self.loaded(true);
                }, 'json');

            };
            self.load();

            $(window).scroll(function() {
                if (
                    self.continueLoading() === true
                    && self.loading() === false
                    && self.users().length > 0
                    && self.currentPage() != self.pageCount()
                    && (
                        ($('.layout-container').scrollTop() + $('.layout-container').height()) > ($('.layout-container').prop('scrollHeight') - 500)
                    )
                ) {
                    self.load();
                }
            });
        }

        $(function() {
            vm = new FriendsViewModel();
            ko.applyBindings(vm);
        });
    });
</script>

<?php $this->renderPartial('application.modules.friends.views._requestTemplate'); ?>