<div class="content-wrapper">
  <h3 class="page-heading mb-4">My Profile</h3>
  <div class="row mb-2">
    <div class="col-sm-12">
        <div class="card-deck">
            <div class="card col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-4" style="min-height:395px;">
              <div class="card-body">
                
                <div class="row d-flex align-items-center justify-items-center flex-column">
                  <div class="text-center">
                    <img src="<?= base_url('assets/img/profile/').$user['image'] ?>" class="rounded-circle" width="200" height="200">
                  </div>
                  <div class="text-center mt-3">
                    <i class="fa fa-quote-right icon-grey-big"></i>
                  </div>
                  <p class="font-italic text-muted mt-3 mb-4 text-center">
                    User Login : <?= $user['user_login'] ?>
                  </p>
                  <h5 class="text-center bolder"> <?= $user['name'] ?></h5>
                  <h6 class="text-center text-muted"><?= $user_role['role_name'] ?></h6>
                </div>
              </div>
            </div>
            
          </div>
    </div>
  </div>    
</div>