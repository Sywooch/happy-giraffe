var Flooring = {

    typeChanged:function (select) {
        var t = parseInt($('input[name="t"]').val());
        var val = parseInt(select.val());
        if (val > t)
            $('#FlooringForm_flooringLength').parent().fadeOut(200);
        else
            $('#FlooringForm_flooringLength').parent().fadeIn(200);

        return false;
    },

    Calculate:function () {
        $.ajax({
            url:$("#flooring-calculate-form").attr("action"),
            data:$("#flooring-calculate-form").serialize(),
            type:"POST",
            dataType:'json',
            success:function (data) {

                $("#repair-floor div.recommendation").fadeOut(100, function () {
                    $("#repair-floor div.recommendation div.left span").html(data.qty + ' ' + data.noun);
                    $("#repair-floor div.recommendation").fadeIn(100);
                });
                $('html,body').animate({scrollTop:$('#result').offset().top}, 'fast');
            }
        });
        return false;
    }
}