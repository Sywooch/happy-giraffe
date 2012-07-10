var Wallpapers = {
    StartCalc:function () {
        $.ajax({
            url:$("#wallpapers-calculate-form").attr('action'),
            data:$("#wallpapers-calculate-form").serialize(),
            type:"POST",
            dataType:'json',
            success:function (data) {
                $("#repair-wallpapers div.recommendation").fadeOut(100, function () {
                    $("#repair-wallpapers div.recommendation div.left span").text(data.qty + ' ' + data.noun);
                    $("#repair-wallpapers div.recommendation div.right span").text(data.qty + ' ' + data.noun2);
                    $("#repair-wallpapers div.recommendation").fadeIn(100);
                });
                $('html,body').animate({scrollTop:$('#result').offset().top}, 'fast');
            }
        });
        return false;
    },
    AreaCreate:function () {
        $.ajax({
            url:$("#empty-area-form").attr("action"),
            data:$("#empty-area-form").serialize(),
            type:"POST",
            success:function (data) {
                $("#emptyareas").fadeOut(100, function () {
                    $("#emptyareas").html(data);
                    $("#emptyareas").fadeIn(100);
                    bindTooltips();
                });
                $('#empty-area-form').hide();
            }
        });
        return false;
    },
    AreaDelete:function (url) {
        $.post(url, function (data) {
            $("#emptyareas").fadeOut(100, function () {
                $("#emptyareas").html(data);
                $("#emptyareas").fadeIn(100);
                return false;
            });
        });
        return false;
    }
}