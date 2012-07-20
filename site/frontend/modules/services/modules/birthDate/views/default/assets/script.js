var birthDate = {
    Calculate:function () {
        $.ajax({
            url:$("#birth-date-form").attr('action'),
            data:$("#birth-date-form").serialize(),
            type:"POST",
            dataType:'json',
            success:function (data) {
                $('#result').html(data.html);
            }
        });
        return false;
    }

}
