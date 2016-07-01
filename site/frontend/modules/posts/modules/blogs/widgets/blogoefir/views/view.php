<?php if (FALSE): ?>
<div class="b-widget-wrapper b-widget-wrapper_theme b-widget-wrapper_border">
	<div class="b-widget-header">
    	<div class="b-widget-header__title b-widget-header__title_live">Блогоэфир</div>
	</div>
  	<div class="b-widget-content">
        <ul class="b-widget-content__list"><?php echo $items; ?></ul>
    	<div class="b-widget-controls">
      		<div class="b-widget-controls__left"></div>
      		<div class="b-widget-controls__right"></div>
    	</div>
  	</div>
</div>
<?php endif; ?>

<blogoefir params="{ items: <?php echo $itemsDataJSON; ?>, limit: <?php echo $limit; ?>}"></blogoefir>