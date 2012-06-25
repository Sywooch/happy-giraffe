var Calories = {
    Calculate:function () {
        $.ajax({
            url:$("#calories-form").attr('action'),
            data:$("#calories-form").serialize(),
            type:"POST",
            dataType:'json',
            success:function (data) {
                $('#result').html(data.html);
            }
        });
        return false;
    }

}
