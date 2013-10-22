var im = {};

/* Прокручивание в конец сообщений, для показа последнего сообщения
 * Зпускать при загрузке сообщений беседы
 */
im.scrollBottom = function () {
    im.container.scrollTop(im.wrapper.height());
}

/* Высота блока с сообщениями
 * Запускать при начальной загрузке страницы и изменении высоты окна браузера
 */
im.messagesHeight = function () {
    // 17 - отступы в блоках, 
    // 130 высота .im-center_top
    var h = im.windowHeight - im.headerHeight - 130 - im.bottom.height() - 17; 
    im.container.height(h);
}

/* Высота блока списка диалогов
 * Запускать при начальной загрузке страницы и изменении высоты окна браузера
 */
im.sidebarHeight = function () {

    var h = im.windowHeight - im.headerHeight - im.bottom.height() - im.contactHideA.outerHeight() - 147; // 147 - отступы в блоках
    im.userListHeight = im.userListHold.height();
    if (im.userListHeight > h ) {
        im.userList.height(h);
    } else {
        im.userList.height(im.userListHeight);
    }
}

/* Пересчет sidebar после скрытия элементов в списке контактов
 * Запускается после скрытия элементов списка
 */
im.hideContacts = function () {
    im.sidebarHeight();
}

$(window).load(function() {

    im.windowHeight = $(window).height(); 
    im.imBlock = $(".im");

    im.userList = $('.im-user-list');
    im.userListHold = $('.im-user-list_hold');
    im.userListHeight = im.userListHold.height();
    im.container = $('.im-center_middle-hold');
    im.wrapper = $('.im-center_middle-w');
    im.bottom = $('.im-center_bottom');

    im.headerHeight = $('.layout-header').height();
    im.contactHideA = $('.im-sidebar_hide-a');


    im.messagesHeight();
    im.sidebarHeight();
    im.scrollBottom();


    $(window).resize(function() {
        im.windowHeight = $(window).height();
        im.messagesHeight();
        im.sidebarHeight();
    });
});