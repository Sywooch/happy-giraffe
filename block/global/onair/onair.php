

<div class="b-onair">
	<div class="b-onair_tab clearfix">
		<a href="" class="b-onair_tab-a active">Прямой эфир</a>
		<a href="" class="b-onair_tab-a"><span class="icon-status "></span> Друзья</a>
	</div>
	<div class="b-onair_cont scroll">
		<div class="scroll_scroller">
			<div class="b-onair_hold">
				
			</div>
		</div>
		<div class="scroll_bar-hold">
            <div class="scroll_bar">
            	<div class="scroll_bar-in"></div>
            </div>
        </div>
	</div>
	<div class="b-onair_bottom">
		<a href="" class="font-small">Весь прямой эфир </a>
	</div>
</div>

<script>
/* Кастомный скролл */
window.onload = function() {
  /* custom scroll */
  var scroll = $('.scroll').baron({
    scroller: '.scroll_scroller',
    container: '.scroll_cont',
    track: '.scroll_bar-hold',
    barOnCls: 'scroll__on',
    bar: '.scroll_bar'
  });
  
}
</script>