<div class="row">
  <div class="col-md-6">
    <div class="msg" style="display:none;">
      <?php echo $this->session->flashdata('msg'); ?>
    </div>
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#settings" data-toggle="tab">Account Information</a></li>
        <li><a href="#password" data-toggle="tab">Change Password</a></li>
      </ul>

      <div class="tab-content">
        <div class="active tab-pane" id="settings">
          <form class="form-horizontal" action="<?php echo base_url('Account/update') ?>" method="POST" enctype="multipart/form-data">
            <div class="box-body">
              <div class="form-group">
                <div class="col-offset-2 col-sm-12">
                  <label for="inputUsername">Username</label>
                  <input type="text" class="form-control" placeholder="Username" name="username" value="<?php echo $userdata->username; ?>">
                </div>
              </div>
              <div class="form-group">
                <div class="col-offset-2 col-sm-12">
                  <label for="inputNama">Name</label>
                  <input type="text" class="form-control" placeholder="Name" name="nama" value="<?php echo $userdata->nama; ?>">
                </div>
              </div>
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-primary pull-right">Submit</button>
            </div>
          </form>
        </div>

        <div class="tab-pane" id="password">
          <form class="form-horizontal" action="<?php echo base_url('Account/ubah_password') ?>" method="POST">
            <div class="box-body">
              <div class="form-group">
                <div class="col-offset-2 col-sm-12">
                  <label for="passLama">Current Password</label>
                  <input input type="password" class="form-control" placeholder="Current Password" name="passLama">
                </div>
              </div>
              <div class="form-group">
                <div class="col-offset-2 col-sm-12">
                  <label for="passBaru">New Password</label>
                  <input input type="password" class="form-control" placeholder="New Password" name="passBaru">
                </div>
              </div>
              <div class="form-group">
                <div class="col-offset-2 col-sm-12">
                  <label for="passKonf">Confirmation New Password</label>
                  <input type="password" class="form-control" placeholder="Confirmation New Password" name="passKonf">
                </div>
              </div>
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-primary pull-right">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>