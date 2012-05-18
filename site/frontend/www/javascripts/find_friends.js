$(function(){

    $('#activity-photo').jcarousel({wrap: 'circular'});

    ffpactive = 0;

    ffwrapper = $('#find-friend-wrapper');
    ffslide = ffwrapper.find('.slide');

    ffpcount = ffslide.find('ul').size();

    ffslide.width(ffpcount*960);

    ffwrapper.height(ffslide.find('ul').eq(ffpactive).height());

})

var ffwrapper;
var ffslide;
var ffpcount;
var ffpactive;

function nextFriendsPage(){

    if (!ffslide.is(':animated')){

        ffpcount == ffpactive+1 ? ffpactive = 0 : ffpactive++;

        ffslide.animate({left: -(ffpactive*960)}, 600, 'linear')

        ffwrapper.height(ffslide.find('ul').eq(ffpactive).height());

    }

}