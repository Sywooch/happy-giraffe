<!DOCTYPE html>
<html class="no-js">
  <head><meta charset="utf-8">
    <title>Happy Giraffe</title>
    <!-- including .css--><link rel="stylesheet" type="text/css" href="/redactor/redactor.css" />
    <link rel="stylesheet" type="text/css" href="../../../css/all1.css" />
    <!-- <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300&amp;subset=latin,cyrillic-ext,cyrillic"> -->
    <!-- including other jade works-->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script>
      window.jQuery || document.write('<script src="/javascript/jquery-1.10.2.min.js"><\/script>')
      
    </script>
    <script src="/javascript/modernizr-2.7.1.min.js"></script>
    <!-- tooltip-->
    <script src="/javascript/jquery.powertip.js"></script>
    <!-- custom scroll-->
    <script src="/javascript/baron.js"></script>
    <!-- wisywig-->
    <script src="/redactor/redactor.js"></script>
    <!-- Базовый js (вызывается на всех страницах)-->
    <script src="/javascript/common.js"></script>
  </head>
  <body class="body body__im">
    <div class="layout-container">
      <!-- header-->
      <div class="header">
        <div class="header_hold clearfix">
          <!-- logo-->
          <div class="logo"><a title="Веселый жираф - сайт для всей семьи" href="" class="logo_i">Веселый жираф - сайт для всей семьи</a><span class="logo_slogan">САЙТ ДЛЯ ВСЕЙ СЕМЬИ</span></div>
          <!-- /logo-->
        </div>
      </div>
      <!-- /header-->
      <div class="layout-wrapper">
		  <?=$content?>
        </div>
      </div>
    </div>
  </body>
</html>