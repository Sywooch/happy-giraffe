	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Happy Giraffe</title>
	
	<link rel="stylesheet" type="text/css" href="/redactor/redactor.css" />
	<link rel="stylesheet" type="text/css" href="/stylesheets/common.css" />
	<link rel="stylesheet" type="text/css" href="/stylesheets/global.css" />
	<!-- 
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	 -->
	<script type="text/javascript">
	if (typeof jQuery == 'undefined') {
	    document.write(unescape("%3Cscript src='/javascripts/jquery-1.8.3.min.js' type='text/javascript'%3E%3C/script%3E"));
	}
	</script>

	<script type="text/javascript" src="/javascripts/jquery.fancybox-1.3.4.js"></script>
	
	<script type="text/javascript" src="/javascripts/jquery.tooltip.pack.js"></script>
	<script type="text/javascript" src="/javascripts/tooltipsy.min.js"></script>
	<script type="text/javascript" src="/javascripts/jquery.powertip.js"></script>
	<script type="text/javascript" src="/javascripts/baron.js"></script>  <!-- custom scrollbar -->

	<script type="text/javascript" src="/javascripts/jquery.placeholder.min.js"></script>
	<script type="text/javascript" src="/javascripts/jquery.jcarousel.js"></script>
	<script type="text/javascript" src="/javascripts/jquery.jcarousel.control.js"></script>
	<script type="text/javascript" src="/javascripts/jquery.Jcrop.min.js"></script>
  	<script type="text/javascript" src="/javascripts/chosen.jquery.min.js"></script>
	<script type="text/javascript" src="/javascripts/jquery.masonry.min.js"></script>
	<script type="text/javascript" src="/javascripts/jquery.isotope.min.js"></script>
	<script type="text/javascript" src="/javascripts/jquery.flydiv.js"></script>

	<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="/redactor/redactor.js"></script>
  
	<script type="text/javascript" src="/javascripts/jquery.flip.js"></script>
	<script type="text/javascript" src="/javascripts/addtocopy.js"></script>
	<!--- <script type="text/javascript" src="/javascripts/messaging.js"></script> -->
  
	<script type="text/javascript" src="/javascripts/common.js"></script>
	
	<!--[if IE 7]>
		<link rel="stylesheet" href='/stylesheets/ie.css' type="text/css" media="screen" />
	<![endif]-->
	
	
	<link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300&amp;subset=latin,cyrillic-ext,cyrillic">


	<!-- new -->
	<script type="text/javascript" src="/new/javascript/selectize.min.js"></script>
	<script type="text/javascript" src="/new/javascript/jquery.magnific-popup.js"></script>
	<script>
	$(function() {
		
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

	    // Измененный tag select c инпутом поиска
	    $('.select-cus__search-on').selectize({
	        create: true,
	        dropdownParent: 'body'
	    });
	    // Измененный tag select
	    $('.select-cus__search-off').selectize({
	        create: true,
	        dropdownParent: 'body',
	        onDropdownOpen: function(){
	            // Делает не возможным ввод в input при открытом списке, без autocomplite
	            this.$wrapper.find('input').attr({disabled: 'disabled'})
	        }
	    });
    });
	</script>



