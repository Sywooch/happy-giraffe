$(function(){
    $('a.remove-area').live('click', function(event){
        $.post($(this).attr('href'), function(data){
            $("#emptyareas").fadeOut(100,function(){$("#emptyareas").html(data);$("#emptyareas").fadeIn(100);});
        })
        event.preventDefault();
    })
})

function StartCalc(){
    $.ajax({
        url: "/repear/wallpapers/calculate/",
        data: $("#wallpapers-calculate-form").serialize(),
        type: "POST",
        success: function(data) {
        $("#result").fadeOut(100,function(){$("#result").html(data);$("#result").fadeIn(100);});
    }
});
return false;
}

function AddEmptyArea(){
    $.ajax({
        url: "/repear/wallpapers/addemptyarea/",
        data: $("#empty-area-form").serialize(),
        type: "POST",
        success: function(data) {
        $("#emptyareas").fadeOut(100,function(){$("#emptyareas").html(data);$("#emptyareas").fadeIn(100);});
    }
});
return false;
}