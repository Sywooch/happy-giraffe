$(function(){
    mas();

    $('#user-activity').on('click', '.more-btn', function() {
        var btn = $(this);
        $.get($(this).attr('href'), function(response) {
            var newPage = $(response).find('#user-activity').html();
            btn.remove();
            $('#user-activity').append(newPage);
            mas();
        });
        return false;
    });

})

function mas()
{
    $('.activity-list').each(function(){
        $(this).imagesLoaded(function(){
            $(this).masonry({
                itemSelector : $(this).find('.list-item'),
                columnWidth: 360
            });
        })
    })
}