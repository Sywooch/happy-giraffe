/**
 * User: alexk984
 * Date: 25.04.12
 */

var NameModule = {
    like:function(el){
        var id = $(el).attr('rel');
        $.ajax({
            url:'/names/like/',
            data:{
                id:id
            },
            type:'POST',
            dataType: 'JSON',
            success:function (response) {
                if (response.success){
                    $('a.heart[rel='+id+']').toggleClass('empty_heart');
                    $('li.like ins ins').html(response.count);
                    $(el).prev().prev('.heart_like').html(response.likes);
                    $('.name_info_right p.heart_like').html(response.likes);
                }
            },
            context:el
        });
        return false;
    },
    showBoysLikes:function(el){
        $('.list_names').hide();
        $('#likes-man').show();

        $('.gender-link a').removeClass('active');
        $(el).addClass('active');
        return false;
    },
    showGirlsLikes:function(el){
        $('.list_names').hide();
        $('#likes-woman').show();
        $('.gender-link a').removeClass('active');
        $(el).addClass('active');
        return false;
    },
    showAllLikes:function(el){
        $('.list_names').hide();
        $('#likes-all').show();
        $('.gender-link a').removeClass('active');
        $(el).addClass('active');
        return false;
    },
    showAllSaints:function(el){
        $('ul.calendar li').show();
        $(el).parent().hide();
        $('#calendar-link2').show();
    },
    showFirstSaints:function(el){
        //$('ul.calendar li a.calendar-link').show();
        $('#calendar-link2').hide();

        $('ul.calendar li').each(function(index, elem){
            if (index > 5)
                $(this).hide();
            else
                $(this).show();
        });
    }
}