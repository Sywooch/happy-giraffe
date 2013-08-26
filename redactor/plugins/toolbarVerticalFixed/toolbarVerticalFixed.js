if (!RedactorPlugins) var RedactorPlugins = {};

RedactorPlugins.toolbarVerticalFixed = {
	init: function()
	{
		this.toolbarVerticalFixed = false;

		$(this.opts.toolbarFixedTarget).on('scroll', $.proxy(this.toolbarObserveScroll1, this));
	},
	toolbarObserveScroll1: function()
	{

		var toolbarHolder = $('.wysiwyg-toolbar');
		var scrollTop = $(this.opts.toolbarFixedTarget).scrollTop();
		var boxTop = this.$box.offset().top;
		var left = 'auto';

		var end = boxTop + this.$box.height() - toolbarHolder.height();
		if (scrollTop > boxTop)
		{
			var width = 'auto';
			if (this.opts.toolbarFixedBox)
			{
				left = this.$box.offset().left;
				width = this.$box.innerWidth();
				toolbarHolder.addClass('toolbar_fixed_box');
			}

			this.toolbarFixed = true;
			toolbarHolder.css({
				position: 'fixed',
				width: width,
				zIndex: 1005,
				top: this.opts.toolbarFixedTopOffset + 'px',
				left: left
			});

			if (scrollTop < end) { 
				toolbarHolder.css({
					position: 'fixed',
					width: width,
					'bottom' : 'auto',
					zIndex: 1005,
					top: this.opts.toolbarFixedTopOffset + 'px',
					left: left
				});
			}
			else toolbarHolder.css({'position' : 'absolute', 'bottom' : '0', 'top' : 'auto'});
		}
		else
		{
			this.toolbarFixed = false;
			toolbarHolder.css({
				position: 'relative',
				width: 'auto',
				top: 0,
				left: left
			});

			if (this.opts.toolbarFixedBox) toolbarHolder.removeClass('toolbar_fixed_box');
		}
	}
};