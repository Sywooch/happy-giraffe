var Friends = {
    friendsCarousel: null,
    friendsCarouselHold: false
}

Friends.open = function() {
    $.get('/userPopup/friends', function(data) {
        $('body').append(data);
        $('body').css('overflow', 'hidden');
        $('body').append('<div id="body-overlay"></div>');
        $('body').addClass('nav-fixed');
        $('#user-nav-friends').addClass('active');

        Friends.friendsCarousel = $('#user-friends .jcarousel').jcarousel({
            scroll: 4,
            wrap:'circular'
        });
    });
}

Friends.close = function() {
    $('#user-friends').remove();
    $('body').css('overflow', '');
    $('#body-overlay').remove();
    $('body').removeClass('nav-fixed');
    $('#user-nav-friends').removeClass('active');
}

Friends.toggle = function() {
    (this.isActive()) ? this.close() : this.open();
}

Friends.isActive = function() {
    return $('#user-friends:visible').length > 0;
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