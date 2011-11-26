$(document).ready(function(){
	
	if ($('a.fancy').size() > 0) $('a.fancy').fancybox({
		overlayColor: '#000',
		overlayOpacity: '0.6',
		padding:0,
		showCloseButton:false,
		scrolling: false
	});	
})

function setTab(el, num){
	var tabs = $(el).parents('.tabs');
	var li = $(el).parent();
	if (!li.hasClass('active')){
		tabs.find('li').removeClass('active');
		li.addClass('active');
		tabs.find('.tab-box-'+num).fadeIn();
		tabs.find('.tab-box').not('.tab-box-'+num).hide();
	}
}

function setItemRadiogroup(el, val){
	var rg = $(el).parents('.filter-radiogroup');
	var li = $(el).parent();
	 
	if (!li.hasClass('active')){
		if (!rg.hasClass('filter-radiogroup-multiply'))
			{rg.find('li').removeClass('active');
			rg.find('input').val(val);
		} else {
			li.find('input').val(1);
		}
		
		li.addClass('active');
	}
	
}

function unsetItemRadiogroup(el){
	var rg = $(el).parents('.filter-radiogroup');
	var li = $(el).parent();
	
	$(li).removeClass('active');
	$(li).find('input').val(0);
}

function setRatingHover(el, num){
	var block = $(el).parents('.setRating');
	
	block.addClass('hover');
	
	var i = 0;
	
	while (i < num) {
		block.find('span').eq(i).addClass('hover');
		i++;
	}	
}

function setRatingOut(el){
	$(el).removeClass('hover').find('span').removeClass('hover');
	
}

function setRating(el, num){
	
	var block = $(el).parents('.setRating');
	
	block.find('span').removeClass('active');
	
	var i = 0;
	
	while (i < num) {
		block.find('span').eq(i).addClass('active');
		i++;
	}
	
	block.find('input').val(num);
}

$('.setRating span').hover(function(){
		
	$('.hotel-class .star-hover').removeClass('star-hover');
	
	var ok = false;
	$(this).addClass('star-hover');
	var i = 1;
	$('.hotel-class .star').each(function(){
		
		if ($(this).hasClass('star-hover')) {ok = true;}
		
		if (ok == false) {
			$(this).addClass('star-hover');
			i++;
		}			
	})
})

$('.hotel-class .star').click(function(){
	$('.hotel-class .star').removeClass('checked');
	
	var ok = false;
	$(this).addClass('checked');
	var i = 1;
	$('.hotel-class .star').each(function(){
		
		if ($(this).hasClass('checked')) {ok = true;$('.hotel-class input').val(i);}
		
		if (ok == false) {
			$(this).addClass('checked');
			i++;
		}			
	})
});

function toggleFilterBox(el){
	$(el).parents('.filter-box').toggleClass('filter-box-toggled');
}

function setPlaceholder(el){
	if ($(el).val() == '') {$(el).val($(el).attr('placeholder'));$(el).addClass('placeholder')}
}

function unsetPlaceholder(el){
	if ($(el).val() == $(el).attr('placeholder')) {$(el).val('');$(el).removeClass('placeholder');}
}


function toggleChildForm(el){
	$(el).parents('.child').find('.child-form').fadeToggle();
}

function toggleBudgetCategoryBox(el) {
	$(el).parents('.category-box').find('.box-in:not(:animated)').slideToggle(function(){$(this).parents('.category-box').toggleClass('toggled')});
}