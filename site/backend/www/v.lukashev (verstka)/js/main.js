
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
	
	$('.sex_block input[type="radio"]').each(function(){
		if($(this).is(':checked'))
			$(this).parent().addClass('active').siblings().removeClass('active');
	}).click(function(){
		$(this).parent().addClass('active').siblings().removeClass('active');
	});

	$('[jform],.upload_image').jForm();
	
	
	$('.main_table .add').click(function(){
		$('.main_table tbody').append('<tr><td><form action="#"><div><input type="text" value="" class="simple" /><a href="#" class="simple">Ok</a></div></form></td><td><form action="#"><div><input type="file" class="upload_image" jform /></div></form></td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><a href="#" class="delete"></a></td></tr>');
		$('[jform],.upload_image').jForm();
		return false;
	});
	
	$.fn.alert = function(str){
		
	};
	jQuery.confirm = function(message, param1, param2){
		option = {
			true_text: 'OK',
			false_text: 'Cancel'
		};
		var callbak;
		if(typeof(param2) == 'function')
			var callbak = param2;
		if(typeof(param1) == 'function')
			var callbak = param1;
			
		if(typeof(param1) == 'object'){
			$.extend(option, param1);
		}
		
		$('<div class="popup"><div class="popup_box hint" id="jconfirm">\
			<a href="#" class="close">Закрыть</a>\
			<p>'+ message +'</p>\
			<div class="actions">\
				<a href="#" class="no">'+ option.false_text +'<span></span></a>\
				<a href="#" class="yes">'+ option.true_text + '<span></span></a>\
			</div>\
		</div></div>').hide().appendTo('body').fadeIn(300);
		
		$('#jconfirm .close').click(function(){
			$(this).parent().parent().fadeOut(300, function(){
				$(this).remove()
			});
			return false;
		});
		$('#jconfirm .no, #jconfirm .yes').click(function(){
			$(this).parent().parent().parent().fadeOut(300, function(){
				$(this).remove()
			});
			callbak($(this).attr('class') == 'yes');
			return false;
		});
		
	};
	
	$('#brands').each(function(){
		$('a.activation').live('click',function(){
			
			var root = this;
			if($(root).hasClass('act')){
				
				$.confirm('Вы уверены, что хотите деактивировать категорию?',{true_text:'Да',false_text: 'Отказаться'}, function(answer){
					if(answer){
						$(root).removeClass('act').addClass('deact');
						//Ajax запрос на деактивацию
					}
				
				});
			}else{
				$.confirm('Вы уверены, что хотите активировать категорию?',{true_text:'Да',false_text: 'Отказаться'}, function(answer){
					if(answer){
						$(root).removeClass('deact').addClass('act');
						//Ajax запрос на активацию
					}
				
				});
				
			}
			
			return false;
		});
		
		$('a.delete').live('click', function(){
			var root = this;
			$.confirm('Вы уверены, что хотите удалить категорию?',{true_text:'Да',false_text: 'Отказаться'}, function(answer){
				if(answer){
					$(root).closest('tr').fadeOut(500, function(){
						$(this).remove();
					});
					//Ajax запрос на активацию TODO
				}
				
			});
			return false;
		});
	});
	
	
	
	
	
	$('#names').each(function(){
		$('.edit:not(".header")').live('click',function(){
			var root = $(this).parent();
			root.defaultName = $(root).text();
			$(root).hide().after('<input class="simple" type="text" value="'+ root.defaultName +'"><a class="simple" href="#">Ok</a>');
			$(root).next().keypress(function(event){
				if(event.which == 13){
					$(root).next().next().click();
					return false;
				}
			});
			$(root).next().next().click(function(){
				var val = $(this).prev().val();
				if(root.defaultName != val){
					$(root).html(val+'<a href="#" class="edit"></a><a href="#" class="delete"></a>');
					//var temp = $(root).find('.edit');
				/*	console.log(typeof(root));*/
					//Ajax запрос изменение имени TODO
				}
				$(root).show()
				$(this).prev().remove();
				$(this).remove();
				return false;
			});
			return false;
		});
		
		$('.delete').live('click', function(){
			$(this).parent().fadeOut(250, function(){
				
				$(this.nextSibling).remove();
				$(this).remove();
			});
			return false;
		});
		
		$('a.add_2').click(function(){
			var root = this;
			$(this).before('<input class="simple" type="text" value=""><a class="simple" href="#">Ok</a>');
			$(root).prev().prev().keypress(function(event){
				if(event.which == 13){
					$(root).prev().click();
					return false;
				}
			});
			$(root).prev().click(function(){
				var val = $(this).prev().val();
				$(this).prev().before('<span>'+val+'<a href="#" class="edit"></a><a href="#" class="delete"></a></span>, ');
				$(this).prev().remove();
				$(this).remove();
				return false;
			});
			return false;
		});
		
		
		$('.edit.header.editor').click(function(){
			$(this).parent().next().hide()
			$(this).parent().append('<div class="leave_message">\
								<div class="message_bar">\
									<div>\
										<a href="#"><img src="img/message_bar_1.png" alt=""/></a>\
										<a href="#"><img src="img/message_bar_2.png" alt=""/></a>\
										<a href="#"><img src="img/message_bar_3.png" alt=""/></a>\
									</div>\
								</div>\
								<textarea class="simple">Напишите характеристику имени не более 400 символов</textarea>\
								<div class="buttons_block">\
									<a href="#" class="reset big_sub">Отменить<i></i></a>\
									<a href="#" class="big_sub">Ok<i></i></a>\
								</div>\
							</div>');
			return false;
		});
	});
	
	
});