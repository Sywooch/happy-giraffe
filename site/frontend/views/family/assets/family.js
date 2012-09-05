var Family = {
    userId:null,
    partnerOf:null,
    partner_id:null,
    baby_count:null,
    tmp:null,
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
                    $('#future-baby').hide();
                    $('#future-baby .baby-id').val('');
                    $('#future-baby a.gender').removeClass('active');
                }
            }, 'json');
        } else {
            $('#future-baby').show();
            var id = $('#future-baby input.baby-id').val();

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
        $(el).parents('.radiogroup').find('.radio-label').removeClass('checked');
        $(el).addClass('checked').find('input').attr('checked', 'checked');

        Family.future_baby_type = type;
        if (type == 1)
            $('#future-baby .member-title').html('<i class="icon-waiting"></i> Ждем еще');
        else
            $('#future-baby .member-title').html('Планируем еще');
    },
    setBaby:function (el, num) {
        if ($(el).hasClass('checked')) {
            if ($('#baby-1 input.baby-id').val() != '') {
                if (confirm("Вы действительно хотите удалить детей?")) {
                    $.post('/family/removeAllBabies/', function (response) {
                        if (response.status) {
                            $(el).removeClass('checked');
                            $(el).parents('.radiogroup').find('input').removeAttr('checked');
                            for (var i = num + 1; i <= 4; i++)
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
        $(el).parents('.radiogroup').find('.radio-label').removeClass('checked');
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
    removePhoto:function (el) {
        $.ajax({
            url:'/family/removePhoto/',
            data:{id:$(el).prev().val()},
            type:'POST',
            dataType:'JSON',
            success:function (response) {
                if (response.status) {
                    var count = $(el).parents('ul').find('li').length - 1;
                    count = count - 1;
                    $(el).parents('ul').find('li.add span ins').html(4 - count);
                    if (count == 3) {
                        $(el).parents('ul').find('li.add span span').html('фотографию');
                        $(el).parents('ul').find('li.add').show();
                    } else {
                        $(el).parents('ul').find('li.add span span').html('фотографии');
                    }
                    if (count == 4)
                        $(el).parents('ul').find('li.add span ins').hide();

                    $(el).parent().remove();
                }
            },
            context:el
        });
    },
    updateWidget:function () {
        $.post('/family/updateWidget/', function (response) {
            $('.user-cols .col-1').html(response);
        });
    },
    addPhotoClick:function (el) {
        var count = $(el).parents('div.family-member').find('.photos li').length - 1;
        if (count < 4) {
            $(el).parents('div.family-member').find('form input[type=file]').trigger('click');
        }
    },
    addPhoto:function (el, url, id) {
        var block = $(el).parents('div.family-member');
        block.find('ul li.add').before('<li><img src="' + url + '"><input type="hidden" value="' + id + '"><a href="" class="remove"></a></li>');
        var count = block.find('div.photos ul li').length - 1;
        block.find('ul li.add span ins').html(4 - count);
        if (count == 3)
            block.find('ul li.add span span').html('фотографию');
        if (count >= 4)
            block.find('li.add').hide();

        block.find('div.photos').show();
        Family.updateWidget();
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

    $('#addPhoto1, #partner_photo_upload2, #partner_photo_upload1').iframePostForm({
        json:true,
        complete:function (response) {
            if (response.status) {
                Family.addPhoto($('#user-partner .photos').get(), response.url, response.id);
            }
        }
    });

    $('.family .baby_photo_upload').iframePostForm({
        json:true,
        complete:function (response) {
            if (response.status) {
                Family.addPhoto(Family.tmp, response.url, response.id);
            }
        }
    });

    $('.family-member input[type=file]').click(function(){
        var count = $(this).parents('div.family-member').find('.photos li').length - 1;
        return count < 4;
    });

    $('#partner_photo_upload1 input, #partner_photo_upload2 input').change(function(){
        $(this).parents('form').submit();
        return false;
    });

    $('.baby_photo_upload input').change(function(){
        Family.tmp = this;
        $(this).parents('form').submit();
        return false;
    });

    /*$('body').delegate('.family input.partner-photo-file', 'change', function () {
        $(this).parents('form').submit();
    });

    $('body').delegate('.family .baby-photo-file', 'change', function () {
        Family.tmp = this;
        $(this).parents('form').submit();
    });*/

    $('body').delegate('.family a.remove', 'click', function (e) {
        e.preventDefault();
        Family.removePhoto(this);
    });

    /*$('body').delegate('.family a.photo', 'click', function (e) {
        e.preventDefault();
        Family.addPhotoClick(this);
    });

    $('body').delegate('.family li.add', 'click', function (e) {
        e.preventDefault();
        Family.addPhotoClick(this);
    });*/
});
