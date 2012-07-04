var weightloss = {
    Calculate:function () {
        $.ajax({
            url:$("#weight-loss-form").attr('action'),
            data:$("#weight-loss-form").serialize(),
            type:"POST",
            dataType:'json',
            success:function (data) {
                /*var text = 'Для того, чтобы Вам сбросить 1 кг. веса необходимо сократить Ваш рацион на ' + data.dailyCalories + ' кал.(ежедневно).';
                if (data.days > 0) {
                    text = text + data.dailyCalories + ' кал/день может вызвать слишком большой дефицитом. Рекомендуется сократить рацион на 1000 кал в течении ' + data.days + ' дней';
                }*/
                $('#result').html(data.html);
            }
        });
        return false;
    }

}
