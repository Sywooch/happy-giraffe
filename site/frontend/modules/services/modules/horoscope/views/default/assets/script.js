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
        $(elem).parents('div.sign').find('.img img').attr('src', '/images/widget/horoscope/big/' + $(elem).val() + '.png')
    }
}