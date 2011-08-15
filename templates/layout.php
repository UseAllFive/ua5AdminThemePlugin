<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/ua5AdminThemePlugin/js/jquery-1.6.1.min.js">\x3C/script>')</script>
    <?php include_javascripts() ?>
  </head>

  <body class="<?php echo "module". ucfirst($sf_request->getParameter('module')) .' action'. ucfirst($sf_request->getParameter('action')); ?>">

    <div id="main">

      <div id="hd">
        <?php include_partial('global/owner')?>
        <?php include_partial('global/top_menu') ?>

        <?php include_slot('tabs')?>

      </div>

      <div id="ua5_admin_container">                       <!-- Body Start -->

        <div id="bd-hd" class="yui-g">

          <div class="yui-u first">
            <h1><?php include_slot('list_title')?></h1>
          </div>

          <div class="yui-u">

          </div>

        </div>

        <?php include_partial('global/flashes') ?>

        <div id="yui-main" class="yui-ge"> <!-- main content -->

          <div class="yui-u first">

             <div class="yui-b" id="bd-content">
               <?php echo $sf_content ?>
             </div>

          </div>

          <div class="yui-u">  <!-- Right Side -->

            <div id="bd-secondary">
              <?php include_slot('right_column')?>
            </div>

          </div>  <!-- End Right Side -->

        </div>

      </div>   <!-- End Main Content Section -->

    </div>

  </body>

</html>
