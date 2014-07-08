	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Happy Giraffe</title>
	
	<link rel="stylesheet" type="text/css" href="/redactor/redactor.css" />
	<link rel="stylesheet" type="text/css" href="/stylesheets/common.dev.css" />
	<link rel="stylesheet" type="text/css" href="/stylesheets/global.dev.css" />
	<!-- 
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	 -->
	<script type="text/javascript">
	if (typeof jQuery == 'undefined') {
	    document.write(unescape("%3Cscript src='/javascripts/jquery-1.8.3.min.js' type='text/javascript'%3E%3C/script%3E"));
	}
	</script>
	<script src="/new/javascript/modernizr-2.7.1.min.js"></script>
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
	<script type="text/javascript" src="/new/javascript/select2.js"></script>
	<script type="text/javascript" src="/new/javascript/jquery.magnific-popup.js"></script>
	<script>
	$(function() {
		    /* Для работы select2 в magnificPopup */
		    $.magnificPopup.instance._onFocusIn = function(e) {
		              // Do nothing if target element is select2 input
		              if( $(e.target).hasClass('select2-input') ) {
		                return true;
		              } 
		              // Else call parent method
		              $.magnificPopup.proto._onFocusIn.call(this,e);
		    };
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


        // Измененный tag select
	    $(".select-cus__search-off").select2({
	        width: '100%',
	        minimumResultsForSearch: -1,
	        dropdownCssClass: 'select2-drop__search-off"',
	        escapeMarkup: function(m) { return m; }
	    });

	    // Измененный tag select c инпутом поиска
	    $(".select-cus__search-on").select2({
	        width: '100%',
	        dropdownCssClass: 'select2-drop__search-on',
	        escapeMarkup: function(m) { return m; }
	    });

	    function selectCus__SearchOnDesc(state) {
	        if (!state.id) return state.text; // optgroup
	        return "<div class='select2-result_i'>" + state.text + "</div><div class='select2-result_desc'>Текст описание</div>";
	    }
	    // Измененный tag select c инпутом поиска
	    $(".select-cus__search-on-desc").select2({
	        width: '100%',
	        dropdownCssClass: 'select2-drop__search-on',
	        formatResult: selectCus__SearchOnDesc,
	        formatSelection: selectCus__SearchOnDesc,
	        escapeMarkup: function(m) { return m; }
	    });
    });
	</script>



