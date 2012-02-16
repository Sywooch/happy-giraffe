var Attach = {
    entity : null,
    entity_id : null,
    base_url : null,
    init : function() {
        $('#fancybox-content').find('a').click(function() {
            if($(this).hasClass('image')) {
                Attach.push(this);
                return false;
            }
            $('#fancybox-content').load(this.href, function() {
                Attach.init();
            });
            return false;
        });
    },
    push : function(link) {
        var photo_id = link.id.split('_')[2];
        $.post(this.base_url, {
            photo_id : photo_id,
            entity : this.entity,
            entity_id : this.entity_id,
            return_html : true
        }, function(data) {
            $('#entity_attaches').find('ul').replaceWith($(data));
            $.fancybox.close();
        }, 'html');
    }
}
