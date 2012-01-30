
jQuery(function(){
	
	jQuery.fn.jTitle = function(){
		
		if(window.jTitle == undefined){
			window.jTitle = jTitle = $('<div id="jTitle"></div>').css({position:'absolute'});
			
			jTitle.show = function(target){
				$(this).appendTo('body').text(target.jtext);
			};
			jTitle.hide = function(){
				$(this).detach();
			};
			$(window).mousemove(function(event){
				$(jTitle).css({top:event.pageY + 20, left: event.pageX + 15 });
			});
		}
		
		return $(this).each(function(){
			var title = this;
			title.jtext = $(title).attr('jtitle');
			
			if(title.timeout === undefined){
				title.timeout = null;
				
				$(this)
					.mouseenter(function(){
						clearTimeout(title.timeout);
						title.timeout = setTimeout(function(){
							jTitle.show(title);
							
						}, 300);
						
					})
					.mouseout(function(){
						
						clearTimeout(title.timeout);
						jTitle.hide();
						
					});
				
			}
			
		});
	};
	
	$('[jtitle]').jTitle();

	jQuery.fn.jForm = function(){
		
		return $(this).each(function(){
			var defInput = this;
			if(defInput.parent == undefined){
				
				$(defInput).wrap('<div class="jCustomFile" ></div>');
				defInput.parent = $(defInput).parent();
			
				$(defInput).parent().mousemove(function(event){
					var offset = $(defInput.parent).offset();
					$(defInput).css({top: event.pageY - offset.top - 10, left: event.pageX - offset.left - ($.browser.msie ? 150 : 20)})
				});
			}
			
			
		});
	}
	
	$('.sex_block input[type="radio"]').click(function(){
		$(this).parent().addClass('active').siblings().removeClass('active');
	});

	$('[jform],.upload_image').jForm();
	
	
	$('.main_table .add').click(function(){
		$('.main_table tbody').append('<tr><td><form action="#"><div><input type="text" value="" class="simple" /><a href="#" class="simple">Ok</a></div></form></td><td><form action="#"><div><input type="file" class="upload_image" jform /></div></form></td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>');
		$('[jform],.upload_image').jForm();
		return false;
	});
	
});