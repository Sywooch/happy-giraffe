var bodyFat = {
    Calculate:function () {
        $.ajax({
            url:$("#body-fat-form").attr('action'),
            data:$("#body-fat-form").serialize(),
            type:"POST",
            dataType:'json',
            success:function (data) {
                $('#result').html(data.html);
            }
        });
        return false;
    }

}
