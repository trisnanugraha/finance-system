<nav class="navbar navbar-static-top" role="navigation">
  <!-- Sidebar toggle button-->
  <a href="<?php echo base_url(); ?>assets/#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
  </a>
  <!-- Navbar Right Menu -->
  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
      <!-- User Account Menu -->
      <li class="dropdown user user-menu">
        <!-- Menu Toggle Button -->
        <a href="" class="dropdown-toggle" data-toggle="dropdown">
          <!-- hidden-xs hides the username on small devices so only the image appears. -->
          <span class="hidden-xs"><?php echo $userdata->nama; ?></span>
        </a>
      </li>
    </ul>
  </div>
</nav>