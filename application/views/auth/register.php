<div class="container-scroller">
    <div class="container-fluid">
      <div class="row">
        <div class="content-wrapper full-page-wrapper d-flex align-items-center auth-pages">
          <div class="card col-lg-4 mx-auto">
            <div class="card-body px-5 py-5">
              <h3 class="card-title text-left mb-3">Register</h3>
              <form class="user" method="POST" action="<?= base_url('auth/registration') ?>">
                <div class="form-group">
                  <input type="text" class="form-control p_input" name="user_login" placeholder="User Login"  value="<?= set_value('user_login') ?>">
                  <?= form_error('user_login', '<small class="text-danger pl-3">', '</small>') ?>
                </div> 
                <div class="form-group">
                  <input type="text" class="form-control p_input" name="name" placeholder="Name"  value="<?= set_value('name') ?>">
                  <?= form_error('name', '<small class="text-danger pl-3">', '</small>') ?>
                </div>                
                <div class="form-group">
                  <input type="password" name="password1" class="form-control p_input" placeholder="Password">
                  <?= form_error('password1', '<small class="text-danger pl-3">', '</small>') ?>
                </div>
                <div class="form-group">
                  <input type="password" name="password2" class="form-control p_input" placeholder="Repeat Password">
                  <?= form_error('password2', '<small class="text-danger pl-3">', '</small>') ?>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary btn-block enter-btn">Register</button>
                </div>
                <p class="existing-user text-center pt-4 mb-0">Already have an acount?&nbsp;<a href="#">Sign In</a></p>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>