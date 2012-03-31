var Family = {
    userId:null,
    partnerOf:null,
    partner_id:null,
    baby_count:null,
    tmp:null,
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
                if (response == '1') {
                    $(el).parents('.radiogroup').find('.radio-label').removeClass('checked');
                    $(el).addClass('checked').find('input').attr('checked', 'checked');

                    if (status_id == 2) {
                        $('#user-partner').hide();
                    } else {
                        $('#user-partner .d-text span').text(Family.partnerOf[status_id]);
                        $('#user-partner').show();
                    }
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
                }
            },
            context:el
        });
    },
    editDate:function (el) {
        $(el).next().show();
    },
    saveDate:function (el) {
        var d = $(el).parent().find('select.date').val();
        var m = $(el).parent().find('select.month').val();
        var y = $(el).parent().find('select.year').val();
        $.ajax({
            url:'/ajax/setDate/',
            data:{
                entity:'UserPartner',
                entity_id:this.partner_id,
                attribute:'birthday',
                d:d,
                m:m,
                y:y
            },
            type:'POST',
            dataType:'JSON',
            success:function (response) {
                if (response.status) {
                    $(el).parent().hide();
                    $(el).parents('div.date').prev().html(response.age).show();
                }
            },
            context:el
        });
    },
    editPartnerNotice:function (el) {
        $('#user-partner div.comment').show();
        $('#user-partner div.comment div.text').hide();
        $('#user-partner div.comment div.input').show();
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
                }
            },
            context:el
        });
    },
    setFutureBaby:function (el, type) {
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
        else
            this.showTypeTitle(el, type);

    },
    showTypeTitle:function (el, type) {
        $(el).parents('.radiogroup').find('.radio-label').removeClass('checked');
        $(el).addClass('checked').find('input').attr('checked', 'checked');

        if (type == 1)
            $('#future-baby div.d-text').html('Кого ждем:');
        else
            $('#future-baby div.d-text').html('Кого планируем:');
    },
    setBaby:function (el, num) {
        if (this.baby_count > num) {
            if ($('#baby-' + (num + 1) + ' input.baby-id').val() != '') {
                var Ids = new Array();
                for (var i = num + 1; i <= 3; i++) {
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
                                for (var i = num + 1; i <= 3; i++) {
                                    $('#baby-' + i).hide();

                                    $('#baby-' + i + ' .baby-id').val('');
                                    $('#baby-' + i + ' div.comment').hide();
                                    $('#baby-' + i + ' div.comment textarea').val('');
                                    $('#baby-' + i + ' .photos').hide();
                                    $('#baby-' + i + ' .name .text').html('').hide();
                                    $('#baby-' + i + ' .name .edit').hide();
                                    $('#baby-' + i + ' .name .input').show();
                                    $('#baby-' + i + ' .name .input input').val('');
                                    $('#baby-' + i + ' .hide-on-start').hide();
                                    $('#baby-' + i + ' .age').html('');
                                    $('#baby-' + i + ' .gender').removeClass('active');
                                }
                                Family.refreshBabyRadio(el);
                            }
                        },
                        context:el
                    });
                }
            } else {
                for (var i = num + 1; i <= 3; i++) {
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
                    }
                },
                context:el
            });
    },
    saveBabyDate:function (el) {
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
                    $(el).parent().hide();
                    $(el).parents('div.date').prev().html(response.age).show();
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
                data:{name:'', sex:gender},
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
                    $(el).parents('div.family-member').find('li.add input[name=baby_id]').val(response.id);
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
                    console.log(count);
                    $(el).parents('ul').find('li.add span ins').html(4 - count);
                    if (count == 3) {
                        $(el).parents('ul').find('li.add span span').html('фотографию');
                        $(el).parents('ul').find('li.add').show();
                    }
                    if (count == 4)
                        $(el).parents('ul').find('li.add span ins').hide();

                    $(el).parent().remove();
                }
            },
            context:el
        });
    }
}

$(function () {
    $('#partner_photo_upload').iframePostForm({
        json:true,
        complete:function (response) {
            if (response.status) {
                $('#user-partner .photos ul li.add').before('<li><img src="' + response.url + '"><input type="hidden" value="' + response.id + '"><a href="" class="remove"></a></li>');
                var count = $('#user-partner .photos li').length - 1;
                $('#user-partner .photos ul li.add span ins').html(4 - count);
                if (count == 3)
                    $('#user-partner .photos ul li.add span span').html('фотографию');
                if (count == 4)
                    $('#user-partner .photos ul li.add').hide();
            }
        }
    });

    $('#baby_photo_upload').iframePostForm({
        json:true,
        complete:function (response) {
            if (response.status) {
                var block = $(Family.tmp).parents('div.family-member');
                block.find('ul li.add').before('<li><img src="' + response.url + '"><input type="hidden" value="' + response.id + '"><a href="" class="remove"></a></li>');
                var count = block.find(' li').length - 1;
                block.find('ul li.add span ins').html(4 - count);
                if (count == 3)
                    block.find('ul li.add span span').html('фотографию');
                if (count >= 4)
                    block.find('li.add').hide();
            }
        }
    });

    $('body').delegate('#partner-photo', 'change', function () {
        $(this).parents('form').submit();
    });

    $('body').delegate('#baby-photo', 'change', function () {
        Family.tmp = this;
        $(this).parents('form').submit();
    });

    $('body').delegate('a.remove', 'click', function (e) {
        e.preventDefault();
        Family.removePhoto(this);
    });

    $('body').delegate('a.photo', 'click', function (e) {
        e.preventDefault();

        var count = $(this).parents('div.family-member').find('.photos li').length - 1;
        if (count < 4) {
            $(this).parents('div.family-member').find('li.add form input[type=file]').trigger('click');
        }
    });

    $('body').delegate('li.add i.icon', 'click', function (e) {
        e.preventDefault();
        var count = $(this).parents('div.family-member').find('.photos li').length - 1;
        if (count < 4) {
            $(this).parents('div.family-member').find('li.add form input[type=file]').trigger('click');
        }
    });
});
