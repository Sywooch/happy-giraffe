var Family = {
    userId:null,
    partnerOf:null,
    partner_id:null,
    baby_count:null,
    future_baby_type:null,
    relationshipStatus: null,

    changeStatus: function() {
        $('.relationship-choice').show();
        $('.relationship-status').hide();
    },

    changeBabies: function() {
        $('.baby-choice').show();
        $('.baby-status').hide();
        $('.baby-notice').show();
    },

    setStatusRadio:function (el, status_id) {
        $.ajax({
            url:'/ajax/setValue/',
            data:{
                entity:'User',
                entity_id:this.userId,
                attribute:'relationship_status',
                value:status_id
            },
            type:'POST',
            success:function (response) {
                Family.relationshipStatus = status_id;
                if (response == '1') {
                    $(el).parents('.radiogroup').find('.radio-label').removeClass('checked');
                    $(el).addClass('checked').find('input').attr('checked', 'checked');

                    $('.relationship-choice').hide();
                    $('.relationship-status .title').text($(el).text());
                    $('.relationship-status').show();

                    if (status_id == 2) {
                        $('#user-partner').hide();
                    } else {
                        $('#user-partner .d-text:eq(0) span').text(Family.partnerOf[status_id][0]);
                        $('#user-partner .d-text:eq(1) span').text(Family.partnerOf[status_id][1]);
                        $('#user-partner .d-text:eq(2) span').text(Family.partnerOf[status_id][0]);
                        $('#user-partner span.partner-title').text(Family.partnerOf[status_id][4]);
                        $('#user-partner').show();
                    }

                    Family.masonryInit();
                    Family.updateWidget();
                }
            },
            context:el
        });
    },
    editPartnerName:function (el) {
        $(el).hide();
        var name = $(el).prev().prev().hide().text();
        $(el).prev().show();
        $(el).prev().find('input').val(name);
    },
    savePartnerName:function (el) {
        var name = $(el).prev().val();
        $.ajax({
            url:'/ajax/setValue/',
            data:{
                entity:'UserPartner',
                entity_id:this.partner_id,
                attribute:'name',
                value:name
            },
            type:'POST',
            success:function (response) {
                if (response == '1') {
                    $(el).parent().hide();
                    $(el).parent().prev().text(name).show();
                    $(el).parent().next().show();
                    $(el).parents('div.name').next().show();
                    Family.updateWidget();
                }
            },
            context:el
        });
    },
    editDate:function (el) {
        $('.datepicker').show();
        $('.dateshower').hide();
    },
    editPartnerNotice:function (el) {
        $('#user-partner div.comment div.text').hide();
        $('#user-partner div.comment div.input').show();
    },
    delPartnerNotice: function (el) {
        $.ajax({
            url:'/ajax/setValue/',
            data:{
                entity:'UserPartner',
                entity_id:this.partner_id,
                attribute:'notice',
                value:''
            },
            type:'POST',
            success:function (response) {
                $('#user-partner div.comment div.input textarea').val('');
                $('#user-partner div.comment div.text').hide();
                $('#user-partner div.comment div.input').show();
                Family.updateWidget();
            },
            context:el
        });
    },
    savePartnerNotice:function (el) {
        var notice = $(el).prev().val();
        $.ajax({
            url:'/ajax/setValue/',
            data:{
                entity:'UserPartner',
                entity_id:this.partner_id,
                attribute:'notice',
                value:notice
            },
            type:'POST',
            success:function (response) {
                if (response == '1') {
                    $(el).parent().hide();
                    $(el).parent().next().find('span.text').text(notice).show();
                    $(el).parent().next().show();
                    Family.updateWidget();
                }
            },
            context:el
        });
    },
    setFutureBaby:function (el, type) {
        if ($(el).hasClass('checked')) {
            $.post('/family/removeFutureBaby/', function (response) {
                if (response.status) {
                    $(el).removeClass('checked');
                    $(el).parents('.radiogroup').find('input').removeAttr('checked');
                    $('#future-baby-1').hide();
                    $('#future-baby-1 .baby-id').val('');
                    $('#future-baby-1 a.gender').removeClass('active');
                    $('#future-baby-2').hide();
                    $('#future-baby-2 .baby-id').val('');
                    $('#future-baby-2 a.gender').removeClass('active');

                    Family.updateWidget();
                }
            }, 'json');
        } else {
            $('#future-baby-1').show();
            var id = $('#future-baby-1 input.baby-id').val();

            if (id != '') {
                $.ajax({
                    url:'/ajax/setValue/',
                    data:{
                        entity:'Baby',
                        entity_id:id,
                        attribute:'type',
                        value:type
                    },
                    type:'POST',
                    success:function (response) {
                        if (response == '1') {
                            Family.showTypeTitle(el, type);

                            Family.updateWidget();
                        }
                    },
                    context:el
                });
            }
            else {
                this.showTypeTitle(el, type);
            }
        }
    },
    showTypeTitle:function (el, type) {
        $(el).parents('.radiogroup').find('.radio-label:has(input[name="radio-2"])').removeClass('checked');
        $(el).addClass('checked').find('input').attr('checked', 'checked');

        Family.future_baby_type = type;
        if (type == 1) {
            $('.futbab div.data:has(.date)').show();
            $('#future-baby-1 .member-title').html((Family.baby_count == 0) ? '<i class="icon-waiting"></i> Ждём' : '<i class="icon-waiting"></i> Ждем ещё');
        }
        else {
            $('.futbab div.data:has(.date)').hide();
            $('#future-baby-1 .member-title').html((Family.baby_count == 0) ? 'Планируем' : 'Планируем ещё');
        }
    },
    setBaby:function (el, num) {
        if ($(el).hasClass('checked')) {
            if ($('#baby-1 input.baby-id').val() != '') {
                if (confirm("Вы действительно хотите удалить детей?")) {
                    $.post('/family/removeAllBabies/', function (response) {
                        if (response.status) {
                            $(el).removeClass('checked');
                            $(el).parents('.radiogroup').find('input').removeAttr('checked');
                            for (var i = 1; i <= 8; i++)
                                Family.clearBaby(i);

                            Family.baby_count = 0;
                            Family.updateWidget();
                        }
                    }, 'json');
                }
            } else {
                $(el).removeClass('checked');
                $(el).parents('.radiogroup').find('input').removeAttr('checked');

                for (var i = 1; i <= 4; i++) {
                    $('#baby-' + i).hide();
                }
                Family.baby_count = 0;
            }
        } else {
            if (this.baby_count > num) {
                if ($('#baby-' + (num + 1) + ' input.baby-id').val() != '') {
                    var Ids = new Array();
                    for (var i = num + 1; i <= 4; i++) {
                        Ids.push($('#baby-' + i + ' input.baby-id').val());
                    }

                    if (confirm("Вы действительно хотите удалить детей?")) {
                        $.ajax({
                            url:'/family/removeBaby/',
                            data:{ids:Ids},
                            type:'POST',
                            dataType:'JSON',
                            success:function (response) {
                                if (response.status) {
                                    for (var i = num + 1; i <= 4; i++)
                                        Family.clearBaby(i);
                                    Family.refreshBabyRadio(el);
                                    Family.updateWidget();
                                }
                            },
                            context:el
                        });
                    }
                } else {
                    for (var i = num + 1; i <= 4; i++) {
                        $('#baby-' + i).hide();
                    }
                    this.refreshBabyRadio(el);
                }
            }
            if (this.baby_count < num) {
                for (var i = 1; i <= num; i++) {
                    $('#baby-' + i).show();
                }
                this.refreshBabyRadio(el);
            }

            this.baby_count = num;
        }
    },
    clearBaby:function (i) {
        $('#baby-' + i).hide();

        $('#baby-' + i + ' .baby-id').val('');
        $('#baby-' + i + ' div.comment').hide();
        $('#baby-' + i + ' div.comment textarea').val('');
        $('#baby-' + i + ' .photos').hide();
        $('#baby-' + i + ' .photos li').each(function (index, Element) {
            if (!$(this).hasClass('add'))
                $(this).remove();
        });
        $('#baby-' + i + ' .name .text').html('').hide();
        $('#baby-' + i + ' .name .edit').hide();
        $('#baby-' + i + ' .name .input').show();
        $('#baby-' + i + ' .name .input input').val('');
        $('#baby-' + i + ' .hide-on-start').hide();
        $('#baby-' + i + ' .age').html('');
        $('#baby-' + i + ' .gender').removeClass('active');
    },
    refreshBabyRadio:function (el) {
        $(el).parents('.radiogroup').find('.radio-label:has(input[name="radio-3"])').removeClass('checked');
        $(el).addClass('checked').find('input').attr('checked', 'checked');
    },
    editBabyName:function (el) {
        $(el).hide();
        var name = $(el).prev().prev().hide().text();
        $(el).prev().show();
        $(el).prev().find('input').val(name);
    },
    saveBabyName:function (el) {
        var name = $(el).prev().val();

        if (this.getBabyId(el) == '') {
            this.addBaby(el, name);
        } else
            $.ajax({
                url:'/ajax/setValue/',
                data:{
                    entity:'Baby',
                    entity_id:this.getBabyId(el),
                    attribute:'name',
                    value:name
                },
                type:'POST',
                success:function (response) {
                    if (response == '1') {
                        $(el).parent().hide();
                        $(el).parent().prev().html(name).show();
                        $(el).parent().next().show();

                        $(el).parents('div.name').next().show();

                        Family.updateWidget();
                    }
                },
                context:el
            });
    },
    saveBabyDate:function (el, date) {
        date = (typeof date === "undefined") ? false : date;

        var d = $(el).parent().find('select.date').val();
        var m = $(el).parent().find('select.month').val();
        var y = $(el).parent().find('select.year').val();
        $.ajax({
            url:'/ajax/setDate/',
            data:{
                entity:'Baby',
                entity_id:this.getBabyId(el),
                attribute:'birthday',
                d:d,
                m:m,
                y:y
            },
            type:'POST',
            dataType:'JSON',
            success:function (response) {
                if (response.status) {
                    $('.datepicker').hide();
                    $('.dateshower').show();
                    $('.dateshower span.age').text(date ? response.birthday : response.age);

                    Family.updateWidget();
                }
            },
            context:el
        });
    },
    editBabyNotice:function (el) {
        var bl = $(el).parents('div.family-member');
        bl.find('div.comment').show();
        bl.find('div.comment div.text').hide();
        bl.find('div.comment div.input').show();
    },
    delBabyNotice:function (el) {
        $.ajax({
            url:'/ajax/setValue/',
            data:{
                entity:'Baby',
                entity_id:this.getBabyId(el),
                attribute:'notice',
                value:''
            },
            type:'POST',
            success:function (response) {
                if (response == '1') {
                    var bl = $(el).parents('div.family-member');
                    bl.find('div.comment div.input textarea').val('');
                    bl.find('div.comment div.text').hide();
                    bl.find('div.comment div.input').show();

                    Family.updateWidget();
                }
            },
            context:el
        });
    },
    saveBabyNotice:function (el) {
        var notice = $(el).prev().val();
        $.ajax({
            url:'/ajax/setValue/',
            data:{
                entity:'Baby',
                entity_id:this.getBabyId(el),
                attribute:'notice',
                value:notice
            },
            type:'POST',
            success:function (response) {
                if (response == '1') {
                    $(el).parent().hide();
                    $(el).parent().next().find('span.text').text(notice).show();
                    $(el).parent().next().show();

                    Family.updateWidget();
                }
            },
            context:el
        });
    },
    getBabyId:function (el) {
        return $(el).parents('.family-member').find('input.baby-id').val();
    },
    saveBabyGender:function (el, gender) {
        if (this.getBabyId(el) == '') {
            $.ajax({
                url:'/family/addBaby/',
                data:{name:'', sex:gender, type:Family.future_baby_type},
                type:'POST',
                dataType:'JSON',
                success:function (response) {
                    if (response.status) {
                        $(el).parent().children('a').removeClass('active');
                        $(el).addClass('active');
                        $(el).parent('div').children('div').show();
                        $(el).parents('div.family-member').find('input.baby-id').val(response.id);

                        Family.updateWidget();
                    }
                },
                context:el
            });
        }
        else
            $.ajax({
                url:'/ajax/setValue/',
                data:{
                    entity:'Baby',
                    entity_id:this.getBabyId(el),
                    attribute:'sex',
                    value:gender
                },
                type:'POST',
                success:function (response) {
                    if (response == '1') {
                        $(el).parent().children('a').removeClass('active');
                        $(el).addClass('active');
                        $(el).parent('div').children('div').show();

                        Family.updateWidget();
                    }
                },
                context:el
            });
    },
    addBabyRadio:function(el) {
        var n = $(el).siblings().length - 1;
        $(el).before($('#babyRadioTmpl').tmpl({n: n}));
    },
    addBaby:function (el, name) {
        $.ajax({
            url:'/family/addBaby/',
            data:{name:name},
            type:'POST',
            dataType:'JSON',
            success:function (response) {
                if (response.status) {
                    $(el).parent().hide();
                    $(el).parent().prev().html(name).show();
                    $(el).parent().next().show();

                    $(el).parents('div.name').next().show();
                    $(el).parents('div.family-member').find('input.baby-id').val(response.id);
                    $(el).parents('div.family-member').find('input.baby_id_2').val(response.id);

                    window.location.reload();
                }
            },
            context:el
        });
    },
    updateWidget:function () {
        $.post('/family/updateWidget/', function (response) {
            $('#family-widget-container').html(response);
        });
    },
    masonryInit:function () {
        var $container = $('.gallery-photos-new ul');

        $container.imagesLoaded( function(){

            $container.masonry({
                itemSelector : 'li',
                columnWidth: 240,
                isAnimated: false,
                animationOptions: { queue: false, duration: 500 }
            });

        });
    }
}

$(function () {
    Family.masonryInit();
});
