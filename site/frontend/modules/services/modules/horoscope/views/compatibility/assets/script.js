/**
 * Author: alexk984
 * Date: 25.04.12
 */

var Horoscope = {
    zodiac_list:['aries', 'taurus', 'gemini', 'cancer', 'leo', 'virgo', 'libra', 'scorpio', 'sagittarius', 'capricorn', 'aquarius', 'pisces'],
    calc:function () {
        document.location.href = '/horoscope/compatibility/'+Horoscope.zodiac_list[$('#HoroscopeCompatibility_zodiac1').val()-1]+'/'+Horoscope.zodiac_list[$('#HoroscopeCompatibility_zodiac2').val()-1]+'/';
    },
    ZodiacChange:function (elem) {
        var val = $(elem).val();
        if (val == '')
            val = 0;
        $(elem).parents('div.sign').find('.img img').attr('src', '/images/widget/horoscope/big/' + val + '.png')
    },
    showSelect:function(el){
        $(el).parents('div.sign').removeClass("zodiac-empty");
        $(el).next().show();
        $(el).parents('div.sign').find('.chzn-drop').css({
            "left" : "0"
        });
    }
}