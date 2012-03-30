var Family = {
    userId:null,
    partnerOf:null,
    partner_id:null,
    setStatusRadio:function (el, status_id) {
        $.ajax({
            url:'/ajax/setValue/',
            data:{
                entity:'User',
                entity_id:this.userId,
                attribute:'relationship_status',
                value:status_id
            },
            type:'POST',
            success:function (response) {
                if (response == '1') {
                    $(el).parents('.radiogroup').find('.radio-label').removeClass('checked');
                    $(el).addClass('checked').find('input').attr('checked', 'checked');

                    if (status_id == 2) {
                        $('#user-partner').hide();
                    } else {
                        $('#user-partner .d-text span').text(Family.partnerOf[status_id]);
                        $('#user-partner').show();
                    }
                }
            },
            context:el
        });
    },
    editPartnerName:function (el) {
        $(el).hide();
        var name = $(el).prev().prev().hide().text();
        $(el).prev().show();
        $(el).prev().find('input').val(name);
    },
    savePartnerName:function (el) {
        var name = $(el).prev().val();
        $.ajax({
            url:'/ajax/setValue/',
            data:{
                entity:'UserPartner',
                entity_id:this.partner_id,
                attribute:'name',
                value:name
            },
            type:'POST',
            success:function (response) {
                if (response == '1') {
                    $(el).parent().hide();
                    $(el).parent().prev().text(name).show();
                    $(el).parent().next().show();

                    $(el).parents('div.name').next().show();
                }
            },
            context:el
        });
    },
    editDate:function (el) {
        $(el).next().show();
    },
    saveDate:function (el) {
        var d = $(el).parent().find('select.date').val();
        var m = $(el).parent().find('select.month').val();
        var y = $(el).parent().find('select.year').val();
        $.ajax({
            url:'/ajax/setDate/',
            data:{
                entity:'UserPartner',
                entity_id:this.partner_id,
                attribute:'birthday',
                d:d,
                m:m,
                y:y
            },
            type:'POST',
            dataType:'JSON',
            success:function (response) {
                if (response.status) {
                    $(el).parent().hide();
                    $(el).parents('div.date').prev().text(response.age).show();
                }
            },
            context:el
        });
    },
    editPartnerNotice:function (el) {
        $('#user-partner div.comment').show();
        $('#user-partner div.comment div.text').hide();
        $('#user-partner div.comment div.input').show();
    },
    savePartnerNotice:function (el) {
        var notice = $(el).prev().val();
        $.ajax({
            url:'/ajax/setValue/',
            data:{
                entity:'UserPartner',
                entity_id:this.partner_id,
                attribute:'notice',
                value:notice
            },
            type:'POST',
            success:function (response) {
                if (response == '1') {
                    $(el).parent().hide();
                    $(el).parent().next().find('span.text').text(notice).show();
                    $(el).parent().next().show();
                }
            },
            context:el
        });
    }
}
