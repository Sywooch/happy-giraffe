<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="ie7"> <![endif]-->
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class=""> <!--<![endif]-->
<head>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/head.php'; ?>
	<link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,100&amp;subset=latin,cyrillic-ext,cyrillic">
	
	<script type="text/javascript">
	$(".chzn").chosen().ready(function(){
	    
	    $('.chzn-itx-simple').find('.chzn-drop').append("<div class='chzn-itx-simple_add'><div class='chzn-itx-simple_add-hold'> <input type='text' name='' id='' class='chzn-itx-simple_add-itx'> <a href='' class='chzn-itx-simple_add-del'></a> </div> <button class='btn-green'>Ok</button> </div>");

	  });
	</script>

</head>
<body class="body-gray">

	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/top-line-menu.php'; ?>
	
<div class="layout-container">

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
					<div class="wysiwyg-v wysiwyg-blue clearfix">
					
						<script>
$(document).ready(function () { 
  $('.wysiwyg-redactor-v').redactor({
      minHeight: 450,
      autoresize: true,
      /* В базовом варианте нет кнопок 'h2', 'h3', 'link_add', 'link_del' но их функции реализованы с помощью выпадающих списков */

  buttons: ['bold', 'italic', 'underline', 'deleted', 'h2', 'h3', 'unorderedlist', 'orderedlist', 'link_add', 'link_del', 'image', 'video', 'smile'],



 activeButtonsAdd: {
            h2: 'h2',
            h3: 'h3'
        },

      buttonsCustom: {

          h2: {
              title: 'h2',
              callback: function(buttonName, buttonDOM, buttonObject) {
                    a = buttonDOM;
                    buttonDOM.hasClass('redactor_act') ? this.formatBlocks('div') : this.formatBlocks(buttonName);
                }
          },
          h3: {
              title: 'h3',
              callback: function(buttonName, buttonDOM, buttonObject) {
                    a = buttonDOM;
                    buttonDOM.hasClass('redactor_act') ? this.formatBlocks('div') : this.formatBlocks(buttonName);
                }
          }
      }
  });
});
						</script>
						<textarea name="" class="wysiwyg-redactor-v"></textarea>
					
					</div>
					

	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/footer.php'; ?>
</div>


</body>
</html>