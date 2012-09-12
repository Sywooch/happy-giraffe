/**
 * Author: alexk984
 * Date: 12.09.12
 */

var ExtLinks = {
    CheckSite:function () {
        $.post('/externalLinks/sites/checkSite/', {url:$('#site_url').val()}, function (response) {
            switch (response.type) {
                case 1:
                    $('#site_status_1').show();
                    break;
                case 2:
                    $('#site_status_2').show();
                    break;
                case 3:
                    $('#site_status_3').show();
                    break;
            }
        }, 'json');
    },
    CancelSite:function () {
        $('.url-actions').hide();
        $('.check-url input').val('');
        $('div.form').hide();
    },
    AddToBL:function () {
        $.post('/externalLinks/sites/addToBlacklist/', {url:$('#site_url').val()}, function (response) {
            if (response.status) {
                ExtLinks.CancelSite();
            }
        }, 'json');
    }
}