<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
  <meta charset="utf-8">

  <?php /*
       Always force latest IE rendering engine (even in intranet) & Chrome Frame
       Remove this if you use the .htaccess
  */ ?>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <?php include_title() ?>

  <?php include_http_metas() ?>
  <?php include_metas() ?>

  <meta name="description" content="">
  <meta name="author" content="Use All Five">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Place favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">


  <link rel="stylesheet" type="text/css" media="screen" href="/ua5AdminThemePlugin/ua5_2/css/admin.css" />
  <?php include_stylesheets() ?>

  <script src="/js/libs/modernizr-2.0.min.js"></script>
  <script src="/js/libs/respond.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.1.min.js"><\/script>')</script>

  <?php include_javascripts() ?>
</head>

<body>

  <header class="c_p1_fg clearfix">
    <div class="container">
      <ul id="header-nav" class="il">
        <li><a href="#" class="c_p1_fg">J.J. Kaye</a></li>
        <li><a href="#" class="c_p1_fg">Account</a></li>
        <li><a href="#" class="c_p1_fg">Help</a></li>
      </ul>
      <h3 class="c_p1b man">IM Global</h3>
    </div> <!-- end of .container -->
  </header>

  <div class="container">
    <div class="page liquid">
      <div class="body">
        <div class="leftNav leftCol">
          <?php include_component('ua5Nav', 'site_nav'); ?>
        </div>
        <div class="main c_p4">
          <?php echo $sf_content ?>
        </div>
      </div>
    </div>


  </div> <!-- end of .container -->



<?php if ( $googleAnalyticsSideId = sfConfig::get('app_google_analytics_site_id') ): ?>
  <script>
    var _gaq=[['_setAccount','<?php echo $googleAnalyticsSideId; ?>'],['_trackPageview'],['_trackPageLoadTime']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
  </script>
<?php endif; ?>


  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script>
    <script>window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})</script>
  <![endif]-->
</body>
</html>
