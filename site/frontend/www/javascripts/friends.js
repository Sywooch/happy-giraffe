var Friends = {
    friendsCarousel: null,
    friendsCarouselHold: false
}

Friends.open = function() {
    $.get('/userPopup/friends/', function(data) {
        Popup.load('Friends');
        $('body').append(data);
        $('#user-nav-friends').addClass('active');

        Friends.friendsCarousel = $('#user-friends .jcarousel').jcarousel({
            scroll: 4,
            wrap:'circular'
        });

        var ul = $('#user-friends .news ul');
        console.log(ul);
        var i = 6;
        int = setInterval(function() {
            i--;
            ul.find('li:eq(' + i + ')').fadeIn();
            if (i < 3) ul.find('li:eq(' + (i + 3) + ')').fadeOut();
            if (i == 0)
                clearInterval(int);
        }, 400);
    });
}

Friends.close = function() {
    $('#user-friends').remove();
    Popup.unload();
    $('#user-nav-friends').removeClass('active');
}

Friends.toggle = function() {
    (this.isActive()) ? this.close() : this.open();
}

Friends.isActive = function() {
    return $('#user-friends:visible').length > 0;
}

Friends.updateCounter = function(diff) {
    var counter = $('#user-nav-friends .count');
    var newVal = parseInt(counter.text()) + diff;
    counter.text(newVal);
    counter.toggle(newVal != 0);

    if (Friends.isActive()) {
        $('#user-friends .friends-count span').text(newVal);
        $('#user-friends .friends-count .more').toggle(newVal > 4)
    }
}

Friends.request = function(request_id, action, el) {
    $.get('/friendRequests/update/', {request_id: request_id, action: action}, function (data, textStatus, jqXHR) {
        if (jqXHR.status == 200) {
            Friends.updateCounter(-1);

            if (Friends.isActive())
                (action == 'accepted') ? Friends.moveFriend(el) : $.fn.yiiListView.update('friendRequestList');
        }
    })
}

Friends.moveFriend = function moveFriend(el) {

    if (!Friends.friendsCarouselHold){

        Friends.friendsCarouselHold = true;

        var count = Friends.friendsCarousel.find('li').size();

        var li = $(el).parents('li');
        $('body').append('<div id="moveFriend"></div>')

        li.addClass('hide');

        $('#moveFriend').html(li.html());

        var moveItemT = li.offset().top;
        var moveItemL = li.offset().left;

        var moveAreaT = $('#moveFriendArea').offset().top;
        var moveAreaL = $('#moveFriendArea').offset().left;

        $('#moveFriend').css({left: moveItemL, top: moveItemT}).animate({left: moveAreaL, top: moveAreaT, opacity:0.4}, 500, function(){

            $('#moveFriendArea').html($('#moveFriend').html());

            $('#moveFriendArea').find('.user-fast-buttons .accept, .user-fast-buttons .remove').remove();
            $('#moveFriendArea').find('.user-fast-buttons').prepend('<span class="friend">друг</span>');

            $('#moveFriend').remove();

            $('.recent-friend .date').text('Только что');
            $('#friendsCount').html(parseInt($('#friendsCount').html())+1);

            if (count>1) {

                li.animate({width: 0, padding: 0}, 200, function(){
                    $(this).remove();
                    Friends.friendsCarousel.jcarousel('reload');
                    Friends.friendsCarouselHold = false;
                })

            } else {
                Friends.friendsCarousel.jcarousel('reload');
                $('#user-friends .invitation').remove();
            }



        });

    }
}

$(function() {
    Comet.prototype.receiveRequest = function(result, id) {
        Friends.updateCounter(1);
        if (Friends.isActive())
            $.fn.yiiListView.update('friendRequestList');
    }

    comet.addEvent(1001, 'receiveRequest');
});