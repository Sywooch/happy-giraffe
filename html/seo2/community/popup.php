<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js"> <!--<![endif]-->
<head>

    <?php 
    $path = $_SERVER['DOCUMENT_ROOT'];
    include $path.'/html/seo2/include/head.php'; ?>
    
</head>
<body >
<div class="layout-page">
    <div class="layout-page_w1">
        <?php include $path.'/html/seo2/include/community-header.php'; ?>
        
        <div class="block">
            <div class="block_title">
                <div class="block_title-ico"></div>
                <div class="block_title-tx">Popup</div>
            </div>
            <div class="block_hold">
                <div class="margin-b10">
                     <a href="#popup-keyword" class="fancybox">попап выбора ключевика</a>
                </div>
            </div>
        </div>

    </div>
</div>        
<?php include $path.'/html/seo2/include/footer.php'; ?>

<div class="popup-hold">
    <?php include $path.'/html/seo2/include/popup/popup-keyword.php'; ?>
    
</div>

</body>
</html>
