var Report = {
    url:null,
    form : null,
    forms:{},
    getForm:function (entity, entity_id, selector) {
        if($('.report-block').size() > 0)
            $('.report-block').remove();
        if (selector.find('.report-block').size() == 0) {
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
                    selector.prepend(response);
                }
            });
        }
        else {
            selector.find('.report-block').remove();
        }
    },
    closeForm : function(button)
    {
        $(button).parents('.report-block').remove();
        return false;
    },
    sendForm : function(form) {
        var report_block = $(form).parents('.report-block');
        var text = $(form).find('#Report_text').val();
        if(text == '') {
            $(form).find('.errorSummary').text('Опишите нарушение');
            return false;
        } else {
            $(form).find('.errorSummary').text('');
        }
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