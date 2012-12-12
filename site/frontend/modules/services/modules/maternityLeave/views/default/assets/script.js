var MaternityLeave = {

    Calculate:function () {
        var m_names = new Array("Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря");

        var birth = new Date($('#year').val(), $('#month').val(), $('#day').val());
        var offset = (parseInt($('input:radio[name="mult-pregnancy"]:checked').val()) > 0) ? 84 : 70;
        var vacation = (isNaN(parseInt($('#vacation').val()))) ? 0 : parseInt($('#vacation').val());

        var result = new Date(birth.getTime() - (86400000 * (offset + vacation)));
        //$('div#decree-time div.recommendation div.left span').text(result.toLocaleDateString());

        $('div#decree-time div.recommendation div').fadeOut(200, function(){
            $('div#decree-time div.recommendation div.left span').text(result.getDate() + ' ' + m_names[result.getMonth()]);
            $('div#decree-time div.recommendation div').fadeIn(200);
        })

        service_user(10);
    }

}
