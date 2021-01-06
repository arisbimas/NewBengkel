<div class="content-wrapper">
  <h3 class="page-heading mb-4">Data Merk</h3>
  <div class="row mb-2">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="col-lg-12 mb-4">
            <div class="row">
              <div class="col-lg-9 mb-2">
                <button type="button" data-toggle="modal" data-target="#popupAddMerk" class="btn btn-outline-success mr-2"><i class="fa fa-plus"></i> Merk Baru</button>
                <a href="../export/lap_master_brg.php" class="btn btn-secondary mr-2"><i class="fa fa-print"></i> Export File</a>
              </div>              
              <div class="col-lg-3">                  
                <h6 class="float-right">Jumlah Data = <span id="jmlRecordMerk"></span></h6>
              </div>                
            </div>                 	              
          </div>
          <div class="col-sm-10 mx-auto">
            <div class="table-responsive">
                <table class="table center-aligned-table table-striped table-hover table-sm" id="tableMerk">
                <thead>
                    <tr class="bg-warning">
                    <th>No</th>
                    <th>Nama Merk</th>
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
</div>
  
<!-- Modal Tambah Merk Baru -->
<div class="modal fade" id="popupAddMerk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Merk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="" method="post" action="" id="formAddMerk">                    
          <div class="form-group">
            <label for="txt_AddMerk_NamaMerk">Nama Merk</label>
            <input type="text" class="form-control p-input" id="txt_AddMerk_NamaMerk" name="txt_AddMerk_NamaMerk" placeholder="Masukan Nama Merk">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" name="tambah" id="AddMerk" onclick="executeSaveMerk()">Simpan</button>
          </div>
        </form>
      </div>      
    </div>
  </div>
</div>

<!-- Modal Edit Merk -->
<div class="modal fade" id="popupEditMerk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Merk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="" method="post" action="" id="formEditMerk">    
        <input type="hidden" id="hdn_KodeMerk">                
          <div class="form-group">
            <label for="txt_EditMerk_NamaMerk">Nama Merk</label>
            <input type="text" class="form-control p-input" id="txt_EditMerk_NamaMerk" name="txt_EditMerk_NamaMerk" placeholder="Masukan Nama Merk">
          </div>          
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" name="update" id="EditMerk" onclick="executeEditMerk()">Simpan</button>
          </div>
        </form>
      </div>      
    </div>
  </div>
</div>

<script type="text/javascript" src="<?= base_url() ?>js/merk/merk.js"></script>

 