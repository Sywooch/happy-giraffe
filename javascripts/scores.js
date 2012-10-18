var Scores = {
    entity:null,
    entity_id:null
}

Scores.open = function (tab) {
    tab = (typeof tab === "undefined") ? 0 : tab;

    $.get('/scores/', function (data) {
        Popup.load('Scores');
        $('#popup-preloader').hide();
        $('.popup-container').append(data);

        $('.user-nav-2 .item-career').addClass('active');
        Scores.openTab(tab);
    });
}

Scores.close = function () {
    Popup.unload();
    $('#user-career').remove();
    $('body').removeClass('nav-fixed');
    $('.user-nav-2 .item-career').removeClass('active');
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

    $('#achievements-list').hide();
    $('#awards-list').hide();
}

Scores.help = function () {
    this.block().find('.scores-in:visible').hide();
    this.block().find('.header').hide();
    this.block().find('#achievement-help').show();

    this.block().find('#achievement-help .back').html(Scores.BackTitle());
}

Scores.BackTitle = function(){
    var index = $("#user-career div.nav li").index($('#user-career div.nav li.active'));

    if (index == 0)
        return 'Вернуться к уровню';
    if (index == 1)
        return 'Вернуться к достижениям';
    if (index == 2)
        return 'Вернуться к трофеям';

    return 'Вернуться';
}

Scores.back = function (selector) {
    var index = $("#user-career-in div.nav li").index($('#user-career-in div.nav li.active'));
    this.block().find(selector).hide();
    this.block().find('.scores-in:eq(' + index + ')').show();
    this.block().find('.header').show();
}

Scores.openTrophy = function (index) {
    $('#awards-list .back').html(Scores.BackTitle());
    this.block().find('.scores-in:visible').hide();
    $('#awards-list').show();

    Scores.initCarousel('#awards');
    var carousel = jQuery('#awards').data('jcarousel');
    carousel.scroll($('#carousel-award-' + index), false);
}

Scores.openAchieve = function (index) {
    $('#achievements-list .back').html(Scores.BackTitle());
    this.block().find('.scores-in:visible').hide();
    $('#achievements-list').show();

    Scores.initCarousel('#achievements');
    var carousel = jQuery('#achievements').data('jcarousel');
    carousel.scroll($('#carousel-achieve-' + index), false);
}

Scores.initCarousel = function(selector){
    var carousel = $(selector).jcarousel({list:'>ul',items:'>li'});

    $(selector+' > .prev').jcarouselControl({target:'-=1', carousel:carousel});
    $(selector+' > .next').jcarouselControl({target:'+=1', carousel:carousel});
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