define("commentScroll", function () {
	"use strict";

	var commentLinkClass = '.icons-meta_comment',
		commentId = '#commentsList';

	$(commentLinkClass).on('click', function (e) {
		
		e.preventDefault();
		$.scrollTo($(commentId), 500);

	});

})