var WantToChat = {

}

WantToChat.send = function(el) {
    $.post(
        '/ajax/wantToChat/',
        function (response) {
            if (response) {
                $(el).remove();
            }
        }
    )
}