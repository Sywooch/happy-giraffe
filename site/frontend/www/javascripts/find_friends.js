var page = 1;


function nextFriendsPage(){
    page++;
    $.get(
        '/activity/friendsNext/',
        {page: page},
        function (response) {
            $('#find-friend-wrapper').fadeOut().html(response).fadeIn();
            if ($('#find-friend-wrapper ul li').length < 12) {
                page = 0;
            }
        }
    )
}