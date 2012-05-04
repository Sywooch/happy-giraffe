$(function () {
    $('.item-box').draggable({
        handle:'.drag',
        revert:true
    });

    $('.items-storage, .item-storage').droppable({

        drop:function (event, ui) {
            $.ajax({
                dataType:'JSON',
                type:'POST',
                url:$('#items-storage').attr('data-putin'),
                data:{
                    id:ui.draggable.find('input[name=\"id\"]').val()
                },
                success:function (response) {
                    if (response.success) {
                        ui.draggable.remove();
                        $('span.count').text(response.count);
                    }
                }
            });
        }
    });

    $('#addOffer').delegate('button.cancel', 'click', function (e) {
        e.preventDefault();
        $('#BagItem_description').val('');
    });

});
