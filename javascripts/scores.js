var Scores = {
    entity:null,
    entity_id:null,
    back_item:0
}

Scores.open = function (tab) {
    tab = (typeof tab === "undefined") ? 0 : tab;

    $.get('/scores/', function (data) {
        Popup.load('Scores');
        $('#popup-preloader').hide();
        $('body').append(data);
        $('#user-nav-scores').addClass('active');
        Scores.openTab(tab);
    });
}

Scores.close = function () {
    Popup.unload();
    $('#user-career').remove();
    $('body').removeClass('nav-fixed');
    $('#user-nav-scores').removeClass('active');
}

Scores.toggle = function () {
    (this.isActive()) ? this.close() : this.open();
}

Scores.isActive = function () {
    return $('#user-career:visible').length > 0;
}

Scores.block = function () {
    return $("#user-career");
}

Scores.openTab = function (index) {
    this.block().find(".nav ul li.active").removeClass('active');
    this.block().find('.nav ul li:eq(' + index + ')').addClass('active');

    this.block().find('.scores-in:visible').hide();
    this.block().find('.scores-in:eq(' + index + ')').show();
}

Scores.help = function (index) {
    this.back_item = index;
    this.block().find('.scores-in:visible').hide();
    this.block().find('.header').hide();
    this.block().find('.how.stripes').show();

    if (index == 0)
        this.block().find('.how.stripes .back').html('Вернуться к уровню');
    if (index == 1)
        this.block().find('.how.stripes .back').html('Вернуться к достижениям');
    if (index == 2)
        this.block().find('.how.stripes .back').html('Вернуться к трофеям');
}

Scores.back = function () {
    this.block().find('.how.stripes').hide();
    this.block().find('.scores-in:eq(' + Scores.back_item + ')').show();
    this.block().find('.header').show();
}

Scores.openTrophy = function (index) {
    $('.achievements-list.trophies').hide();
    $('#awards-list').show();

    var carousel = $('#achievements').jcarousel({
        list:'>ul',
        items:'>li'
    });

    $('#achievements > .prev').jcarouselControl({target:'-=1', carousel:carousel});
    $('#achievements > .next').jcarouselControl({target:'+=1', carousel:carousel});

    $('#achievements').jcarousel('scroll', $('#carousel-award-' + index));
}
Scores.openTrophyList = function () {
    $('#achievements').hide();
    $('.achievements-list.trophies').show();
}

Scores.openAchieve = function (index) {
    $('.achievements-list.trophies').hide();
    $('#awards-list').show();

    var carousel = $('#achievements').jcarousel({
        list:'>ul',
        items:'>li'
    });

    $('#achievements > .prev').jcarouselControl({target:'-=1', carousel:carousel});
    $('#achievements > .next').jcarouselControl({target:'+=1', carousel:carousel});

    $('#achievements').jcarousel('scroll', $('#carousel-award-' + index));
}

Scores.whoElse = function (el, type, id) {
    $.post('/scores/whoElse/', {type:type, id:id}, function (response) {
        $(el).next().html(response);
    });
}

Scores.checkPack = function (id) {
    $.post('/scores/getPack/', {id:id}, function (response) {
        $('#user-career').replaceWith(response);
    });
}