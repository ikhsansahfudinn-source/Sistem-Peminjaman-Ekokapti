<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
            <div class="login-brand">
              <!-- <img src="<?php echo base_url('assets/assets_stisla/') ?>/assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle"> -->
            </div>

            <div class="card card-primary">
              <div class="card-header">
                <h4>Register</h4>
              </div>

              <div class="card-body">
                <form method="POST" action="<?php echo base_url('register') ?>">
                  <div class="row">
                    <div class="form-group col-6">
                      <label for="nama">Nama</label>
                      <input id="nama" type="text" class="form-control" name="nama" autofocus>
                      <?php echo form_error('nama', '<div class="text-small text-danger">', '</div>') ?>
                    </div>
                    <div class="form-group col-6">
                      <label for="username">Username</label>
                      <input id="username" type="text" class="form-control" name="username">
                      <?php echo form_error('username', '<div class="text-small text-danger">', '</div>') ?>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input id="alamat" type="text" class="form-control" name="alamat">
                    <?php echo form_error('alamat', '<div class="text-small text-danger">', '</div>') ?>
                    <div class="invalid-feedback">
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-6">
                      <label for="gender" class="d-block">Gender</label>
                      <select class="form-control" name="gender">
                        <option value="">-- Pilih gender --</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                      </select>
                      <?php echo form_error('gender', '<div class="text-small text-danger">', '</div>') ?>
                    </div>
                    <div class="form-group col-6">
                      <label for="no_telp" class="d-block">No. Telepon</label>
                      <input id="no_telp" type="text" class="form-control" name="no_telp">
                      <?php echo form_error('no_telp', '<div class="text-small text-danger">', '</div>') ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-6">
                      <label>No. KTP</label>
                      <input type="text" name="no_ktp" class="form-control">
                      <?php echo form_error('no_ktp', '<div class="text-small text-danger">', '</div>') ?>
                    </div>
                    <div class="form-group col-6">
                      <label>Password</label>
                      <div class="input-group">
                        <input type="password" id="password" name="password" class="form-control" aria-describedby="togglePassword">
                        <div class="input-group-append">
                          <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                          </button>
                        </div>
                      </div>
                      <?php echo form_error('password', '<div class="text-small text-danger">', '</div>') ?>
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                      Register
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <div class="simple-footer">
              Copyright © Muda-Mudi Ekokapti
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Tambahkan JavaScript di akhir body -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#togglePassword').click(function() {
        const passwordField = $('#password');
        const eyeIcon = $('#eyeIcon');
        if (passwordField.attr('type') === 'password') {
          passwordField.attr('type', 'text');
          eyeIcon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
          passwordField.attr('type', 'password');
          eyeIcon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
      });
    });
  </script>
</body>