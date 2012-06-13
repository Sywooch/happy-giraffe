$(function () {

    $('#photo_upload').iframePostForm({
        json:true,
        complete:function (response) {
            if (response.status) {
                $('#photo-upload-block img').attr('src', response.image);
            }
        }
    });

    $('#photo_upload input').change(function(){
        $(this).parents('form').submit();
        return false;
    });

})