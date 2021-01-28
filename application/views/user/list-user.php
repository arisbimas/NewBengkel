<div class="content-wrapper">
  <h3 class="page-heading mb-4">Daftar User</h3>
  <div class="row mb-2">
    <div class="col-sm-12">
        <div class="card">
        <div class="card-body">
          <div class="col-lg-12 mb-4">
            <div class="row">
              <div class="col-lg-9 mb-2">
                <button type="button" data-toggle="modal" data-target="#popupAddUser" class="btn btn-outline-success mr-2"><i class="fa fa-plus"></i> User Baru</button>
                <!-- <a href="<?= base_url("barang/laporan_semua_barang") ?>" target="_blank" class="btn btn-secondary mr-2"><i class="fa fa-print"></i> Laporan Semua Users</a> -->
              </div>              
              <div class="col-lg-3">                  
                <h6 class="float-right">Jumlah Data = <span id="jmlRecordUsers"></span></h6>
              </div>                
            </div>                     	              
          </div>
          <div class="table-responsive">
            <table class="table center-aligned-table table-striped table-hover table-sm" id="tableUsers">
              <thead>
                <tr class="bg-warning">
                  <th>No</th>
                  <th>User Login</th>
                  <th>Nama</th>                    
                  <th>Foto</th>                    
                  <th>Role</th>
                  <th class="mx-auto">Aksi</th> 
                </tr>
              </thead>
              <tbody>
                    
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>    
</div>

<!-- Modal Tambah User Baru -->
<div class="modal fade" id="popupAddUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="" method="post" action="" id="formAddUser" autocomplete="off">  
        <div class="form-group">
            <label for="txt_AddUser_UserLogin">User Login</label>
            <input type="text" class="form-control p-input" id="txt_AddUser_UserLogin" name="user_login" placeholder="Masukan User Login" >
          </div>                  
          <div class="form-group">
            <label for="txt_AddUser_NamaUser">Nama User</label>
            <input type="text" class="form-control p-input" id="txt_AddUser_NamaUser" name="name" placeholder="Masukan Nama User" >
          </div>
          <div class="form-group">
            <label for="txt_AddUser_Role">Role</label>
            <?php echo $form_role; ?>
          </div>
          <div class="form-group">
            <label for="txt_AddUser_Password">Password</label>
            <input type="text" class="form-control p-input" id="txt_AddUser_Password" name="password" placeholder="Masukan Password"   >
          </div>          
                      
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" name="tambah" id="AddUser" onclick="executeSaveUser()">Simpan</button>
          </div>
        </form>
      </div>      
    </div>
  </div>
</div>

<!-- Modal Edit User -->
<div class="modal fade" id="popupEditUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="" method="post" action="" id="formEditUser">    
        <input type="hidden" id="hdn_UserLogin" name="user_login">                
          <!-- <div class="form-group">
            <label for="txt_EditUser_UserLogin">User Login</label>
            <input type="text" class="form-control p-input" id="txt_EditUser_UserLogin" name="user_login" placeholder="Masukan User Login" >
          </div>-->
          <div class="form-group">
            <label for="txt_EditUser_NamaUser">Nama User</label>
            <input type="text" class="form-control p-input" id="txt_EditUser_NamaUser" name="name" placeholder="Masukan Nama User" >
          </div>
          <div class="form-group">
            <label for="txt_EditUser_Role">Role</label>
            <?php echo $form_role_edit; ?>
          </div>
          <!-- <div class="form-group">
            <label for="txt_EditUser_Password">Password</label>
            <input type="text" class="form-control p-input" id="txt_EditUser_Password" name="password" placeholder="Masukan Password"   >
          </div>-->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" name="update" id="EditUser" onclick="executeEditUser()">Simpan</button>
          </div>
        </form>
      </div>      
    </div>
  </div>
</div>

<script type="text/javascript" src="<?= base_url() ?>js/users/users.js"></script>
