<div class="container-scroller">
    <div class="container-fluid">
      <div class="row">
        <div class="content-wrapper full-page-wrapper d-flex align-items-center auth-pages">
          <div class="card col-lg-4 mx-auto">
            <div class="card-body px-5 py-5">
              <h3 class="card-title text-left mb-3">Login</h3>
              <?= $this->session->flashdata("message"); ?>
              <br>
              <form class="user" method="POST" action="<?= base_url("auth"); ?>">
                <div class="form-group">
                  <input type="text" name="user_login" class="form-control p_input" placeholder="User Login" value="<?= set_value('user_login') ?>">
                  <?= form_error('user_login', '<small class="text-danger pl-3">', '</small>') ?>
                </div>
                <div class="form-group">
                  <input type="password" name="password" class="form-control p_input" placeholder="Password" >
                  <?= form_error('password', '<small class="text-danger pl-3">', '</small>') ?>
                </div>
                
                <div class="text-center">
                  <button type="submit" class="btn btn-primary btn-block enter-btn">LOG IN</button>
                </div>
                
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>