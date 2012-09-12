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

        $('#friendRequestList .friends').jcarousel();
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