<!DOCTYPE html>
<html>
  <head>
	<script type="text/javascript">
		<?php 
			if ($redirect)
				$code .= 'window.location = \''.addslashes($url).'\';';
			echo $code;
		?>
	</script>
  </head>
  <body>
    <?=$url ?>
    <?php var_dump($_GET) ?>
    <?php var_dump($_POST) ?>
	<h2 id="title" style="display:none;">Redirecting back to the application...</h2>
	<h3 id="link"><a href="<?php echo $url; ?>">Click here to return to the application.</a></h3>
	<script type="text/javascript">
		document.getElementById('title').style.display = '';
		document.getElementById('link').style.display = 'none';
	</script>
  </body>
</html>