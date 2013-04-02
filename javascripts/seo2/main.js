jQuery(document).ready(function(){
	
	/* fancybox */
	$(".fancybox").fancybox({
		padding: 0,
		closeBtn: false
	});

	/* fancybox */
	$(".task-tb_count").fancybox({
		padding: 0,
		wrapCSS: 'popup-commentator-task'
	});


});

/* tabs */
function setTab(el, num) {
    var tabs = $(el).parents('.tabs');
    var li = $(el).parent();
    if (!li.hasClass('active')) {
        tabs.find('li').removeClass('active');
        li.addClass('active');
        tabs.find('.tab-box-' + num).fadeIn();
        initSelects(tabs.find('.tab-box-' + num));
        tabs.find('.tab-box').not('.tab-box-' + num).hide();

    }
}
function initSelects(block) {
    block.find('.chzn-done').next().remove();
    var chzns = block.find('.chzn-done');
    if (chzns.size() > 0) {
        chzns.each(function () {
            var s = $(this);
            s.removeClass('chzn-done').chosen({
                allow_single_deselect:s.hasClass('chzn-deselect')
            });
        });
    }
}
/* /tabs */


function refreshOdd(selecor, odd_class ){
    $(selecor).removeClass(odd_class);
    $(selecor+':even').addClass(odd_class);
}