/**
 * Author: alexk984
 * Date: 25.04.12
 */

var Horoscope = {
    history:null,
    zodiac_list:['aries', 'taurus', 'gemini', 'cancer', 'leo', 'virgo', 'libra', 'scorpio', 'sagittarius', 'capricorn', 'aquarius', 'pisces'],
    calc:function () {
        var url = '/horoscope/compatibility/'+Horoscope.zodiac_list[$('#HoroscopeCompatibility_zodiac1').val()-1]+'/'+Horoscope.zodiac_list[$('#HoroscopeCompatibility_zodiac2').val()-1]+'/';
        $.get(url, function(data) {
            Horoscope.history.changeBrowserUrl(url);
            $('#result').html(data);
        });
    },
    ZodiacChange:function (elem) {
        $(elem).parents('div.sign').find('.img img').attr('src', '/images/widget/horoscope/big/' + $(elem).val() + '.png')
    }
}

$(function() {
    Horoscope.history = new AjaxHistory('horoscope');
});