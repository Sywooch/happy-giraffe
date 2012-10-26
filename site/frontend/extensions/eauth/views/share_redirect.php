<!DOCTYPE html>
<html>
  <head>
	<script type="text/javascript">
		<?php
            $code = "
                var inc = " . CJSON::encode($inc) . ";
                window.location = '" . addslashes($url) . "';
                if (inc) {
                    var el =  window.opener.$('.rating span');
                    el.text(parseInt(el.text()) + 1);
                }

            ";
			echo $code;
		?>
	</script>
  </head>
  <body>
	<h2 id="title" style="display:none;">Redirecting back to the application...</h2>
	<h3 id="link"><a href="<?php echo $url; ?>">Click here to return to the application.</a></h3>
	<script type="text/javascript">
		document.getElementById('title').style.display = '';
		document.getElementById('link').style.display = 'none';
	</script>
  </body>
</html>