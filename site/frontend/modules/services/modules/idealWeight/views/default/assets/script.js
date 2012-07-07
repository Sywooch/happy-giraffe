var idealweight = {
    Calculate:function () {
        $.ajax({
            url:$("#ideal-weight-form").attr('action'),
            data:$("#ideal-weight-form").serialize(),
            type:"POST",
            dataType:'json',
            success:function (data) {
                $('#result').text('идеальны вес ' + data.result + ' кг, отклонение от нормы ' + data.deviation + '%');
            }
        });
        return false;
    }

}
