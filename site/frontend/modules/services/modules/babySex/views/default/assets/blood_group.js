var father_group = null;
var mother_group = null;
var current_gender = null;

$(function () {
    $('.child_sex_blood_banner input[type=button]').click(function () {
        if (father_group !== null && mother_group !== null) {
            var sum = father_group + mother_group;
            var prev = current_gender;
            if (sum % 2 == 0)
                current_gender = 1;
            else
                current_gender = 2;

            if (prev == 1)
                $('.wh_son').fadeOut(100, ShowGender);
            else
                $('.wh_daughter').fadeOut(100, ShowGender);

            service_used(23);
        } else{
            if (father_group == null)
                $('#man_bl_em_').show();
            if (mother_group == null)
                $('#woman_bl_em_').show();
            return false;
        }
        return false;
    });

    $('.man_bl ul li a').click(function () {
        $('.man_bl ul li a').removeClass('active');
        $(this).addClass('active');
        $('#man_bl_em_').hide();
        father_group = $('.man_bl ul li a').index($(this)) + 1;
        CheckButtonEnable();
        return false;
    });

    $('.woman_bl ul li a').click(function () {
        $('.woman_bl ul li a').removeClass('active');
        $(this).addClass('active');
        $('#woman_bl_em_').hide();
        mother_group = $('.woman_bl ul li a').index($(this)) + 1;
        CheckButtonEnable();
        return false;
    });
});

function CheckButtonEnable() {
    if (father_group !== null && mother_group !== null) {
        $('.child_sex_blood_banner input[type=button]').removeClass('calc_grey').addClass('calc_grey_active');
    }
}

function ShowGender() {
    if (current_gender == 2) {
        $('.wh_son').hide();
        $('.wh_daughter').fadeIn(100);
    } else {
        $('.wh_daughter').hide();
        $('.wh_son').fadeIn(100);
    }
}