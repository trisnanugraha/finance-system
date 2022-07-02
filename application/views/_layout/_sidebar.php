<?php if ($userdata->role_id == 0) { ?>
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">

        <li class="header">MENU</li>

        <!-- Optionally, you can add icons to the links -->
        <li <?php if ($page == 'dashboard') {
              echo 'class="active"';
            } ?>>
          <a href="<?php echo base_url('Dashboard'); ?>">
            <i class="fa fa-home"></i>
            <span>Dashboard</span>
          </a>
        </li>

        <li class="treeview <?= $this->uri->segment(1) == 'Owner' || $this->uri->segment(1) == 'Customer' || $this->uri->segment(1) == 'Description' ? 'active' : '' ?>">
          <a href="#">
            <i class="fa fa-group"></i> <span>Data</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?= $this->uri->segment(1) == 'Owner' ? 'class="active"' : '' ?>>
              <a href="<?php echo base_url('Owner'); ?>">
                <i class="fa fa-building-o">
                </i> Owner</a>
            </li>

            <li <?= $this->uri->segment(1) == 'Customer' ? 'class="active"' : '' ?>>
              <a href="<?php echo base_url('Customer'); ?>">
                <i class="fa fa-user-plus">
                </i> Customer</a>
            </li>

            <li <?= $this->uri->segment(1) == 'Description' ? 'class="active"' : '' ?>>
              <a href="<?php echo base_url('Description'); ?>">
                <i class="fa fa-cube">
                </i> Description</a>
            </li>
          </ul>
        </li>

        <li class="treeview <?= $this->uri->segment(1) == 'Coa' || $this->uri->segment(1) == 'Voucher' || $this->uri->segment(1) == 'AR' || $this->uri->segment(1) == 'GL' || $this->uri->segment(1) == 'CF' ? 'active' : '' ?>">
          <a href="#">
            <i class="fa fa-bank"></i> <span>Cash Flow</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?= $this->uri->segment(1) == 'Coa' ? 'class="active"' : '' ?>>
              <a href="<?php echo base_url('Coa'); ?>">
                <i class="fa fa-money">
                </i>Charts Of Accounts</a>
            </li>

            <li <?= $this->uri->segment(1) == 'Voucher' ? 'class="active"' : '' ?>>
              <a href="<?php echo base_url('Voucher'); ?>">
                <i class="fa fa-money">
                </i> Voucher</a>
            </li>

            <li <?= $this->uri->segment(1) == 'AR' ? 'class="active"' : '' ?>>
              <a href="<?php echo base_url('AR'); ?>">
                <i class="fa fa-money">
                </i> Kartu Piutang (AR)</a>
            </li>

            <li <?= $this->uri->segment(1) == 'GL' ? 'class="active"' : '' ?>>
              <a href="<?php echo base_url('GL'); ?>">
                <i class="fa fa-money">
                </i> Link GL</a>
            </li>

            <li <?= $this->uri->segment(1) == 'CF' ? 'class="active"' : '' ?>>
              <a href="<?php echo base_url('CF'); ?>">
                <i class="fa fa-money">
                </i> Cash Flow</a>
            </li>
          </ul>
        </li>

        <li class="treeview <?= $this->uri->segment(1) == 'Rates' || $this->uri->segment(1) == 'Period' || $this->uri->segment(1) == 'Water' || $this->uri->segment(1) == 'Electricity' || $this->uri->segment(1) == 'StorageParking' || $this->uri->segment(1) == 'WorkingRequest' ? 'active' : '' ?>">
          <a href="#">
            <i class="fa fa-money"></i> <span>Invoice</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?= $this->uri->segment(1) == 'Rates' ? 'class="active"' : '' ?>>
              <a href="<?php echo base_url('Rates'); ?>">
                <i class="fa fa-tags">
                </i> Rates</a>
            </li>

            <li <?= $this->uri->segment(1) == 'Period' ? 'class="active"' : '' ?>>
              <a href="<?php echo base_url('Period'); ?>">
                <i class="fa fa-sort">
                </i> Period</a>
            </li>

            <li <?= $this->uri->segment(1) == 'Water' ? 'class="active"' : '' ?>>
              <a href="<?php echo base_url('Water'); ?>">
                <i class="fa fa-tint">
                </i> Water</a>
            </li>

            <li <?= $this->uri->segment(1) == 'Electricity' ? 'class="active"' : '' ?>>
              <a href="<?php echo base_url('Electricity'); ?>">
                <i class="fa fa-flash">
                </i> Electricity</a>
            </li>

            <li <?= $this->uri->segment(1) == 'StorageParking' ? 'class="active"' : '' ?>>
              <a href="<?php echo base_url('StorageParking'); ?>">
                <i class="fa fa-archive">
                </i> Storage/Parking</a>
            </li>

            <li <?= $this->uri->segment(1) == 'WorkingRequest' ? 'class="active"' : '' ?>>
              <a href="<?php echo base_url('WorkingRequest'); ?>">
                <i class="fa fa-briefcase">
                </i> Working Request</a>
            </li>
          </ul>
        </li>

        <li class="treeview <?= $this->uri->segment(1) == 'Billing' || $this->uri->segment(1) == 'Service' || $this->uri->segment(1) == 'Iuran' ? 'active' : '' ?>">
          <!-- <li class="" <?php if ($page == 'tarif' || $page == 'periode') {
                              echo 'class="treeview active"';
                            } ?>> -->
          <a href="#">
            <i class="fa fa-money"></i> <span>Report</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?= $this->uri->segment(1) == 'Billing' ? 'class="active"' : '' ?>>
              <!-- <li <?php if ($page == 'report') {
                          echo 'class="active"';
                        } ?>> -->
              <a href="<?php echo base_url('Billing'); ?>">
                <i class="fa fa-print">
                </i> Billing</a>
            </li>

            <li <?= $this->uri->segment(1) == 'Service' ? 'class="active"' : '' ?>>
              <!-- <li <?php if ($page == 'report') {
                          echo 'class="active"';
                        } ?>> -->
              <a href="<?php echo base_url('Service'); ?>">
                <i class="fa fa-plug">
                </i> Service Charge</a>
            </li>

            <li <?= $this->uri->segment(1) == 'Iuran' ? 'class="active"' : '' ?>>
              <!-- <li <?php if ($page == 'report') {
                          echo 'class="active"';
                        } ?>> -->
              <a href="<?php echo base_url('Iuran'); ?>">
                <i class="fa fa-briefcase">
                </i> Iuran IPK</a>
            </li>
          </ul>
        </li>

        <li <?php if ($page == 'keluhan') {
              echo 'class="active"';
            } ?>>
          <a href="<?php echo base_url('Keluhan'); ?>">
            <i class="fa fa-tasks"></i>
            <span>Daftar Keluhan</span>
          </a>
        </li>

        <li <?php if ($page == 'log') {
              echo 'class="active"';
            } ?>>
          <a href="<?php echo base_url('Log'); ?>">
            <i class="fa fa-file-text"></i>
            <span>Log Aktivitas</span>
          </a>
        </li>

        <li class="header">SETTINGS</li>
        <li <?php if ($page == 'account') {
              echo 'class="active"';
            } ?>>
          <a href="<?php echo base_url('Account'); ?>">
            <i class="fa fa-wrench"></i>
            <span>Account Settings</span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url('Auth/logout'); ?>">
            <i class="fa fa-sign-out"></i>
            <span>Exit</span>
          </a>
        </li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
<?php } else if ($userdata->role_id == 1) { ?>
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">

        <li class="header">MENU</li>

        <!-- Optionally, you can add icons to the links -->
        <li <?php if ($page == 'dashboard') {
              echo 'class="active"';
            } ?>>
          <a href="<?php echo base_url('Dashboard'); ?>">
            <i class="fa fa-home"></i>
            <span>Dashboard</span>
          </a>
        </li>

        <li class="treeview <?= $this->uri->segment(1) == 'Owner' || $this->uri->segment(1) == 'Customer' || $this->uri->segment(1) == 'Description' ? 'active' : '' ?>">
          <a href="#">
            <i class="fa fa-group"></i> <span>Data</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?= $this->uri->segment(1) == 'Owner' ? 'class="active"' : '' ?>>
              <a href="<?php echo base_url('Owner'); ?>">
                <i class="fa fa-building-o">
                </i> Owner</a>
            </li>

            <li <?= $this->uri->segment(1) == 'Customer' ? 'class="active"' : '' ?>>
              <a href="<?php echo base_url('Customer'); ?>">
                <i class="fa fa-user-plus">
                </i> Customer</a>
            </li>

            <li <?= $this->uri->segment(1) == 'Description' ? 'class="active"' : '' ?>>
              <a href="<?php echo base_url('Description'); ?>">
                <i class="fa fa-cube">
                </i> Description</a>
            </li>
          </ul>
        </li>

        <li class="treeview <?= $this->uri->segment(1) == 'Coa' || $this->uri->segment(1) == 'Voucher' || $this->uri->segment(1) == 'AR' || $this->uri->segment(1) == 'GL' || $this->uri->segment(1) == 'CF' ? 'active' : '' ?>">
          <a href="#">
            <i class="fa fa-bank"></i> <span>Cash Flow</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?= $this->uri->segment(1) == 'Coa' ? 'class="active"' : '' ?>>
              <a href="<?php echo base_url('Coa'); ?>">
                <i class="fa fa-money">
                </i>Charts Of Accounts</a>
            </li>

            <li <?= $this->uri->segment(1) == 'Voucher' ? 'class="active"' : '' ?>>
              <a href="<?php echo base_url('Voucher'); ?>">
                <i class="fa fa-money">
                </i> Voucher</a>
            </li>

            <li <?= $this->uri->segment(1) == 'AR' ? 'class="active"' : '' ?>>
              <a href="<?php echo base_url('AR'); ?>">
                <i class="fa fa-money">
                </i> Kartu Piutang (AR)</a>
            </li>

            <li <?= $this->uri->segment(1) == 'GL' ? 'class="active"' : '' ?>>
              <a href="<?php echo base_url('GL'); ?>">
                <i class="fa fa-money">
                </i> Link GL</a>
            </li>

            <li <?= $this->uri->segment(1) == 'CF' ? 'class="active"' : '' ?>>
              <a href="<?php echo base_url('CF'); ?>">
                <i class="fa fa-money">
                </i> Cash Flow</a>
            </li>
          </ul>
        </li>

        <li class="treeview <?= $this->uri->segment(1) == 'Rates' || $this->uri->segment(1) == 'Period' || $this->uri->segment(1) == 'Water' || $this->uri->segment(1) == 'Electricity' || $this->uri->segment(1) == 'StorageParking' || $this->uri->segment(1) == 'WorkingRequest' ? 'active' : '' ?>">
          <a href="#">
            <i class="fa fa-money"></i> <span>Invoice</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?= $this->uri->segment(1) == 'Rates' ? 'class="active"' : '' ?>>
              <a href="<?php echo base_url('Rates'); ?>">
                <i class="fa fa-tags">
                </i> Rates</a>
            </li>

            <li <?= $this->uri->segment(1) == 'Period' ? 'class="active"' : '' ?>>
              <a href="<?php echo base_url('Period'); ?>">
                <i class="fa fa-sort">
                </i> Period</a>
            </li>

            <li <?= $this->uri->segment(1) == 'Water' ? 'class="active"' : '' ?>>
              <a href="<?php echo base_url('Water'); ?>">
                <i class="fa fa-tint">
                </i> Water</a>
            </li>

            <li <?= $this->uri->segment(1) == 'Electricity' ? 'class="active"' : '' ?>>
              <a href="<?php echo base_url('Electricity'); ?>">
                <i class="fa fa-flash">
                </i> Electricity</a>
            </li>

            <li <?= $this->uri->segment(1) == 'StorageParking' ? 'class="active"' : '' ?>>
              <a href="<?php echo base_url('StorageParking'); ?>">
                <i class="fa fa-archive">
                </i> Storage/Parking</a>
            </li>

            <li <?= $this->uri->segment(1) == 'WorkingRequest' ? 'class="active"' : '' ?>>
              <a href="<?php echo base_url('WorkingRequest'); ?>">
                <i class="fa fa-briefcase">
                </i> Working Request</a>
            </li>
          </ul>
        </li>

        <li class="treeview <?= $this->uri->segment(1) == 'Billing' || $this->uri->segment(1) == 'Service' ? 'active' : '' ?>">
          <!-- <li class="" <?php if ($page == 'tarif' || $page == 'periode') {
                              echo 'class="treeview active"';
                            } ?>> -->
          <a href="#">
            <i class="fa fa-money"></i> <span>Report</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?= $this->uri->segment(1) == 'Billing' ? 'class="active"' : '' ?>>
              <!-- <li <?php if ($page == 'report') {
                          echo 'class="active"';
                        } ?>> -->
              <a href="<?php echo base_url('Billing'); ?>">
                <i class="fa fa-print">
                </i> Billing</a>
            </li>

            <li <?= $this->uri->segment(1) == 'Service' ? 'class="active"' : '' ?>>
              <!-- <li <?php if ($page == 'report') {
                          echo 'class="active"';
                        } ?>> -->
              <a href="<?php echo base_url('Service'); ?>">
                <i class="fa fa-plug">
                </i> Service Charge</a>
            </li>
          </ul>
        </li>

        <li class="header">SETTINGS</li>
        <li <?php if ($page == 'account') {
              echo 'class="active"';
            } ?>>
          <a href="<?php echo base_url('Account'); ?>">
            <i class="fa fa-wrench"></i>
            <span>Account Settings</span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url('Auth/logout'); ?>">
            <i class="fa fa-sign-out"></i>
            <span>Exit</span>
          </a>
        </li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
<?php } else if ($userdata->role_id == 2) { ?>
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">

        <li class="header">MENU</li>

        <!-- Optionally, you can add icons to the links -->
        <li>
          <a href="<?php echo base_url('User'); ?>">
            <i class="fa fa-money"></i>
            <span>Tagihan</span>
          </a>
        </li>

        <li>
          <a href="<?php echo base_url('User/keluhan'); ?>">
            <i class="fa fa-envelope"></i>
            <span>Keluhan</span>
          </a>
        </li>

        <li class="header">SETTINGS</li>
        <li <?php if ($page == 'account') {
              echo 'class="active"';
            } ?>>
          <a href="<?php echo base_url('Account'); ?>">
            <i class="fa fa-wrench"></i>
            <span>Account Settings</span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url('Auth/logout'); ?>">
            <i class="fa fa-sign-out"></i>
            <span>Exit</span>
          </a>
        </li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
<?php } else { ?>
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">

        <li class="header">MENU</li>

        <!-- Optionally, you can add icons to the links -->
        <li>
          <a href="<?php echo base_url('Teknisi'); ?>">
            <i class="fa fa-tasks"></i>
            <span>Daftar Keluhan</span>
          </a>
        </li>

        <li class="header">SETTINGS</li>
        <li <?php if ($page == 'account') {
              echo 'class="active"';
            } ?>>
          <a href="<?php echo base_url('Account'); ?>">
            <i class="fa fa-wrench"></i>
            <span>Account Settings</span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url('Auth/logout'); ?>">
            <i class="fa fa-sign-out"></i>
            <span>Exit</span>
          </a>
        </li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
<?php } ?>