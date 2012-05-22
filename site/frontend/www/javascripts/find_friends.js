$(function(){

    ffpactive = 0;
    ffpcount = $('#find-friend-wrapper').find('ul').size();

})

var ffpcount;
var ffpactive;


function nextFriendsPage(){

    if (!$('#find-friend-wrapper').find('ul').is(':animated')){

        ffpcount == ffpactive+1 ? ffpactive = 0 : ffpactive++;

        $('#find-friend-wrapper').find('ul').eq(ffpactive).fadeIn();
        $('#find-friend-wrapper').find('ul').not(':eq('+ffpactive+')').hide();

    }

}