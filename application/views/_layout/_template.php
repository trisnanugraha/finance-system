<!DOCTYPE html>
<html>

<head>
  <title>SCBD Suites | Dashboard</title>
  <!-- meta -->
  <?php echo @$_meta; ?>

  <!-- css -->
  <?php echo @$_css; ?>

  <!-- jQuery 2.2.3 -->

  <style>
    body:not(.modal-open) {
      padding-right: 0px !important;
    }
  </style>

  <script src="<?php echo base_url(); ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    <!-- header -->
    <?php echo @$_header; ?>
    <!-- nav -->

    <!-- sidebar -->
    <?php echo @$_sidebar; ?>

    <!-- content -->
    <?php echo @$_content; ?>
    <!-- headerContent -->
    <!-- mainContent -->

    <!-- footer -->
    <?php echo @$_footer; ?>

    <div class="control-sidebar-bg"></div>
  </div>

  <!-- js -->
  <?php echo @$_js;
  if (@$_additional_js != null) {
    echo @$_additional_js;
  } ?>
</body>

</html>