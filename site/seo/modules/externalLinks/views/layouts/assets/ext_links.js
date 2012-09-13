/**
 * Author: alexk984
 * Date: 12.09.12
 */

var ExtLinks = {
    CheckSite:function () {
        var url = $('#site_url').val();
        $.post('/externalLinks/sites/checkSite/', {url:url}, function (response) {
            switch (response.type) {
                case 1:
                    $('#site_status_1').show();
                    break;
                case 2:
                    $('#site_status_2').show();
                    $('.url-list').html(response.links).show();
                    break;
                case 3:
                    $('#site_status_3').show();
                    break;
            }
        }, 'json');
    },
    CancelSite:function () {
        ExtLinks.ClearFrom();
    },
    AddSite:function(){
        $.post('/externalLinks/sites/addSite/', {url:$('#site_url').val()}, function (response) {
            if (response.status) {
                $('#ELLink_site_id').val(response.id);
                $('div.form').show();
            } else
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:'Ошибка, обратитесь к разработчикам'
                });
        }, 'json');
    },
    AddToBL:function () {
        $.post('/externalLinks/sites/addToBlacklist/', {url:$('#site_url').val()}, function (response) {
            if (response.status) {
                ExtLinks.ClearFrom();
            } else
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:response.error
                });
        }, 'json');
    },
    CheckLinkType:function(el, type){
        $('#ELLink_link_type').val(type);
        $('.link-types .icon-link').removeClass('active');
        $(el).addClass('active')
    },
    ClearFrom:function(){
        $('div.form').hide();
        $('.url-actions').hide();
        $('#site_url').val('');

        $('#ELLink_url').val('');
        $('#ELLink_site_id').val('');
        $('#ELLink_our_link').val('');
        $('.anchors input').val('');
        $('.anchors input:last').hide();
        $('.url-list').hide().html('');

        $('input [name="paid_link"]').attr('checked', false);
        $('#ELLink_link_cost').val('');
    }
}