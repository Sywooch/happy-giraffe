/**
 * Author: alexk984
 * Date: 25.04.12
 */

var pregnancyWeight = {
    calc:function () {
        $.ajax({
            url:$('#pregnant-params-form').attr('action'),
            data:$('#pregnant-params-form').serialize(),
            type:'POST',
            success:function (data) {
                $('.intro-text').hide();
                $('#result').html(data);
                $('html,body').animate({scrollTop:$('#result').offset().top}, 'fast');
            }
        });
        return false;
    },
    toWeight:function () {
        $('#recommend').hide();
        $('#weight-table').show();
        return false;
    },
    toRecommend:function () {
        $('#recommend').show();
        $('#weight-table').hide();
        return false;
    }
}