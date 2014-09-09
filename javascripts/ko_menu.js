(function() {
    function f($, ko, comet) {
        var MenuViewModel = function(data) {
            var self = this;
            self.newNotificationsCount = ko.observable(data.newNotificationsCount);
            self.newMessagesCount = ko.observable(data.newMessagesCount);
            self.newFriendsCount = ko.observable(data.newFriendsCount);
            self.newPostsCount = ko.observable(data.newPostsCount);
            self.newScoreCount = ko.observable(data.newScoreCount);
            self.activeModule = ko.observable(data.activeModule);
            self.menuExtended = ko.observable(false);

            $(function() {
                $("body").on("click", function(){
                    self.menuExtended(false);
                });

                $(window).on('scroll',function () {
                    if (self.activeModule() != 'messaging') {
                        var contanerScroll = $(window).scrollTop();
                        var header = $('.layout-header');
                        if (contanerScroll > header.height() + header.offset().top) {
                            $('.header-fix').fadeIn(400);
                        } else {
                            $('.header-fix').fadeOut(400);
                        }
                    }
                });

                Comet.prototype.incNewFriendsCount = function(result, id) {
                    self.newFriendsCount(self.newFriendsCount() + 1);
                };

                Comet.prototype.incNewMessagesCount = function(result, id) {
                    self.newMessagesCount(self.newMessagesCount() + 1);
                };

                Comet.prototype.incNewNotificationsCount = function(result, id) {
                    self.newNotificationsCount(Math.max(0, self.newNotificationsCount() + result.unreadCount));
                };

                Comet.prototype.incScoresCount = function(result, id) {
                    self.newScoreCount(self.newScoreCount() + 1);
                };

                comet.addEvent(100, 'incNewNotificationsCount');
                comet.addEvent(1001, 'incNewFriendsCount');
                comet.addEvent(2000, 'incNewMessagesCount');
                comet.addEvent(23, 'incScoresCount');
            });

        };
        
        return MenuViewModel;
    };
    if (typeof define === 'function' && define['amd']) {
        define('ko_menu', ['jquery', 'knockout', 'comet'], f);
    } else {
        window.MenuViewModel = f(window.$, window.ko, window.comet);
    }
})(window);