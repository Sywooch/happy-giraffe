$(document).on('show', '.im-user-list_i', function(event) {
	if(event.target == this) {
		//console.log('show', event.target);
	}
}).on('hide', '.im-user-list_i', function(event) {
	if(event.target == this) {
		//console.log('hide', event.target);
	}
});

$(function() {

	function addBaron(el) {
		$(el).each(function() {
			if (this.baron) {
				this.baron.update();
			} else {
				this.baron = $(this).baron({
					scroller: '.scroll_scroller',
					barOnCls: 'scroll__on',
					container: '.scroll_cont',
					track: '.scroll_bar-hold',
					bar: '.scroll_bar'
				});
				// Т.к. по спецификации у события onScroll нет bubbling'а,
				// то обработчик надо вешать на каждый конкретный элемент
				$('.scroll_scroller', this).scroll(function(e) {
					// стриггерим jquery событие, у которого есть bubbling,
					// но, что бы не уйти в цикл, проверим флаг.
					if(!e.fake) {
						e.fake = true;
						$(this).trigger(e);
					}
				});
			}
		});
	}

	$(document).on('koUpdate', function(event, elements) {
		var self = event.target;
		addBaron('.scroll');
		//console.log($('.powertip, .redactor_toolbar li a', self).attr('title'));
		$('.powertip, .redactor_toolbar li a, [data-tooltip]', self).tooltipster({
			trigger: 'hover',
			offsetY: -6,
			delay: 200,
			maxWidth: 200,
			arrowColor: '#5C4B86',
			onlyOne: false,
			touchDevices: true,
			theme: '.tooltipster-default',
			functionReady: function(origin, continueTooltip) {},
			functionInit: function(origin, content) {
				return origin.data('tooltip');
			}
		});
		$('.tooltip-click-b', self).tooltipster({
			trigger: 'click',
			delay: 0,
			onlyOne: false,
			touchDevices: true,
			interactive: true,
			interactiveAutoClose: false,
			theme: '.tooltipster-white',
			position: 'bottom',
			functionBefore: function(origin, continueTooltip) {
				$('.tooltip-click-b').tooltipster('hide');
				var d = $(origin.context).find(' .tooltip-drop').html();
				origin.tooltipster('update', d);
				continueTooltip(d);
			}
		});
		
	});
	$(document).on('koElementAdded', function(event) {
		event.target;
	});
	
	    // tooltip
/*    $('.no-touch .powertip, .no-touch .redactor_toolbar li a, .mfp-close').tooltipster({
        trigger: 'hover',
        offsetY: -6,
        delay: 200,
        maxWidth: 200,
        arrowColor: '#5C4B86',
        onlyOne: false,
        touchDevices: true,
        theme: '.tooltipster-default',
        functionReady: function(origin, continueTooltip) {}
    });*/

    // tooltip
    // попап у иконки
    /*$('.tooltip-click-b').tooltipster({
        trigger: 'click',
        delay: 0,
        onlyOne: false,
        touchDevices: true,
        interactive: true,
        interactiveAutoClose: false,
        theme: '.tooltipster-white',
        position: 'bottom',
        functionBefore: function(origin, continueTooltip) {
            $('.tooltip-click-b').tooltipster('hide');
            var d = $(origin.context).find(' .tooltip-drop').html();
            console.log(origin.context.className);
            origin.tooltipster('update', d);
            continueTooltip(d);
        }
    });*/

    $('.popup-a').magnificPopup({
        type: 'inline',
        overflowY: 'auto',
        tClose: 'Закрыть',
        fixedBgPos: true,
        
        // When elemened is focused, some mobile browsers in some cases zoom in
        // It looks not nice, so we disable it:
        callbacks: {
            open: function() {
                $('html').addClass('mfp-html');
            },
            close: function() {
                $('html').removeClass('mfp-html');
            }
        }
    });

    $.fn.wysiwygHG = function() {
        new HgWysiwyg(this);
    };
});

HgWysiwyg.prototype = {
    loaded : false,
    load : function() {
        var self = this;
        if (! HgWysiwyg.prototype.loaded) {
            $.get('/ajax/redactorNew/', function(response) {
                $('body').append(response);
//                    ko.applyBindings(self.popupsViewModel, document.getElementById('wysiwyg-related'));
//                    //ko.applyBindings(new WysiwygVideo(), document.getElementById('redactor-popup_b-video'));
//                    $('.redactor-popup_smiles a').on('click', function() {
//                        var pic = $(this).find('img').attr('src');
//                        self.obj.insertHtml('<img class="smile" src="' + pic + '" />');
//                        $('.redactor-popup_b-smile').addClass('display-n');
//                        return false;
//                    });
            });
        }
    }
}

function HgWysiwyg(element)
{
    var self = this;
    self.load();

    self.obj = null;
    self.defaultOptions = {
        minHeight: 20,
        autoresize: true,
        focus: true,
        toolbarExternal: '.redactor-control_toolbar',
        buttons: ['image'],
        plugins: ['smilesModal', 'videoModal'],
        focusCallback: function(e)
        {
            // Нужно выбирать непосредственного родителя
            $('.redactor-control_hold').addClass('redactor-control_hold__focus');
        },
        changeCallback: function(html)
        {
            // Нужно выбирать непосредственного родителя
            var bParrent = $('.redactor-control_hold');
            if(bParrent.height() >= 250) {
                bParrent.height(250);
            }
            // обновлять скролл baron
        },
        initCallback: function()
        {
            self.obj = this;
        }
    }

    self.openPopup = function() {

    }

    self.closePopup = function() {

    }




    $(element).redactor(self.defaultOptions);
}

var RedactorPlugins = {};
RedactorPlugins.smilesModal = {
    init: function()
    {
        var obj = this;

        var callback = function(buttonDOM) {
            obj.fixPosition(buttonDOM);

            $('.redactor-popup_smiles a').on('click', function() {
                var pic = $(this).find('img').attr('src');
                obj.insertHtml('<img class="smile" src="' + pic + '" />');
                obj.modalClose();
                return false;
            });
        }

        this.buttonAdd('smile', 'Смайлы', function(buttonName, buttonDOM, buttonObj, e) {
            this.modalInit('Smiles', '#redactor-popup_b-smile', 500, function() {callback(buttonDOM)});
        });
    },
    fixPosition : function(a) {
        $('#redactor_modal').hide();

        setTimeout(function() {
            var top = a.offset().top;
            var left = a.offset().left;

            $('#redactor_modal').css({
                'top': top - $('#redactor_modal').height() - 6,
                'left': left - 18
            });
            $('#redactor_modal').show();
        }, 50);
    }
}

RedactorPlugins.videoModal = {
    init: function()
    {
        var obj = this;

        var callback = function(buttonDOM) {
            var model = new WysiwygVideo();
            ko.applyBindings(model, document.getElementById('testok'));
        }

        this.buttonAdd('video', 'Видео', function(buttonName, buttonDOM, buttonObj, e) {
            this.modalInit('Video', '#redactor-popup_b-video', 500, function() {callback(buttonDOM)});
        });
    }
}

function WysiwygVideo()
{
    var self = this;
    self.link = ko.observable('');
    self.embed = ko.observable(null);
    self.previewLoading = ko.observable(false);
    self.previewError = ko.observable(false);

    self.check = function() {
        self.previewError(false);
        self.previewLoading(true);
        $.get('/newblog/videoPreview/', { url : self.link(), width : 395 }, function(response) {
            self.previewLoading(false);
            if (response.success === false)
                self.previewError(true);
            else
                self.embed(response.html);
        }, 'json');
    };

    self.remove = function() {
        self.link('');
        self.embed(null);
    };

    self.embed.subscribe(function() {
        if ($('.redactor_btn_video').length > 0)
            setPopupPosition($('.redactor_btn_video'), $('.redactor-popup_b-video'));
    });
};