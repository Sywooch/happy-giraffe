var Report = {
    url:null,
    form : null,
    forms:{},
    getForm:function (entity, entity_id, selector) {
        if (selector.next().attr('class') != 'report-block') {
            $.ajax({
                type:'POST',
                data:{
                    source_data:{
                        model:entity,
                        object_id:entity_id
                    }
                },
                url:this.url,
                success:function (response) {
                    selector.after(response);
                }
            });
        }
        else {
            selector.next().remove();
        }
    },
    closeForm : function(button)
    {
        $(button).parents('.report-block').remove();
        return false;
    },
    sendForm : function(form) {
        var report_block = $(form).parents('.report-block');
        $.ajax({
            type: 'POST',
            data: $(form).serialize(),
            url: form.action,
            success: function(response) {
                report_block.remove();
            }
        });
        return false;
    }
}