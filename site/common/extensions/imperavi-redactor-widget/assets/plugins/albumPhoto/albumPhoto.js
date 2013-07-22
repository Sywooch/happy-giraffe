if (!RedactorPlugins) var RedactorPlugins = {};

RedactorPlugins.albumPhoto = {

    init: function()
    {
        this.buttonAdd('albumPhoto', 'AlbumPhoto', function()
        {
            redactorjs = this;
            $.ajax({
                type : 'GET',
                url: $('.upload-btn a.btn').attr('href'),
                success : function(data) {
                    $.fancybox.open(data);
                },
                async : false
            });
        });
    }

}

