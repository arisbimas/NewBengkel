<div class="content-wrapper">
  <h3 class="page-heading mb-4">Data Barang</h3>
  <div class="row mb-2">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="col-lg-12 mb-4">
            <div class="row">
              <div class="col-lg-9 mb-2">
                <button type="button" data-toggle="modal" data-target="#popupAddBarang" class="btn btn-outline-success mr-2"><i class="fa fa-plus"></i> Barang Baru</button>
                <a href="<?= base_url("barang/laporan_semua_barang") ?>" target="_blank" class="btn btn-secondary mr-2"><i class="fa fa-print"></i> Laporan Semua Barang</a>
              </div>              
              <div class="col-lg-3">                  
                <h6 class="float-right">Jumlah Data = <span id="jmlRecordBarang"></span></h6>
              </div>                
            </div>
            <div class="row my-3">
                <div class="col-lg-12 ">
                  <form class="form-inline float-right" id="form-filter">
                    <div class="form-group">
                      <label for="filter">Filter</label>                    
                    </div>
                    <div class="form-group mx-2">
                      <?php echo $form_merk; ?>
                    </div>
                    <!-- <div class="form-group">
                      <input type="text" class="form-control datepicker" id="date_filter" name="filterDate" placeholder="dd mm yyyy">
                    </div> -->
                    <button type="button" id="btn-filter" class="btn btn-primary mx-1">Filter</button>
                    <button type="button" id="btn-reset" class="btn btn-default ">Reset</button>
                  </form>
                </div>
              </div>                  	              
          </div>
          <div class="table-responsive">
            <table class="table center-aligned-table table-striped table-hover table-sm" id="tableBarang">
              <thead>
                <tr class="bg-warning">
                  <th>No</th>
                  <th>Kode Barang</th>
                  <th>Nama Barang</th>                    
                  <th>Merk</th>                    
                  <th>Harga Beli</th>
                  <th>Harga Jual</th>
                  <th>Stok</th>
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
  
<!-- Modal Tambah Barang Baru -->
<div class="modal fade" id="popupAddBarang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Barang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="" method="post" action="" id="formAddBarang">                    
          <div class="form-group">
            <label for="txt_AddBarang_NamaBarang">Nama Barang</label>
            <input type="text" class="form-control p-input" id="txt_AddBarang_NamaBarang" name="txt_AddBarang_NamaBarang" placeholder="Masukan Nama Barang">
          </div>
          <div class="form-group">
            <label for="txt_AddBarang_Merk">Merk</label>
            <!-- <input type="text" class="form-control p-input" id="txt_AddBarang_Merk" name="txt_AddBarang_Merk" placeholder="Masukan Merk"> -->
            <?php echo $form_merk_add; ?>
          </div>          
          <div class="form-group">
            <label for="txt_AddBarang_HargaBeli">Harga Beli</label>
            <input type="number" min="1" class="form-control p-input" id="txt_AddBarang_HargaBeli" name="txt_AddBarang_HargaBeli" placeholder="Masukan Harga Beli">              
          </div>
          <div class="form-group">
            <label for="txt_AddBarang_HargaJual">Harga Jual</label>
            <input type="number" min="1" class="form-control p-input" id="txt_AddBarang_HargaJual" name="txt_AddBarang_HargaJual" placeholder="Masukan Harga Jual">
          </div>
          <div class="form-group">
            <label for="txt_AddBarang_Jumlah">Jumlah</label>
            <input type="number" min="1" class="form-control p-input" id="txt_AddBarang_Jumlah" name="txt_AddBarang_Jumlah" placeholder="Masukan Jumlah">
          </div>     
          <div class="form-group">
            <label for="txt_AddBarang_Diskon">Diskon</label>
            <input type="number" min="1" max="100" class="form-control p-input" id="txt_AddBarang_Diskon" name="txt_AddBarang_Diskon" value="0" placeholder="Masukan Diskon">
          </div>            
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" name="tambah" id="AddBarang" onclick="executeSaveBarang()">Simpan</button>
          </div>
        </form>
      </div>      
    </div>
  </div>
</div>

<!-- Modal Edit Barang -->
<div class="modal fade" id="popupEditBarang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Barang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="" method="post" action="" id="formEditBarang">    
        <input type="hidden" id="hdn_KodeBarang">                
          <div class="form-group">
            <label for="txt_EditBarang_NamaBarang">Nama Barang</label>
            <input type="text" class="form-control p-input" id="txt_EditBarang_NamaBarang" name="txt_EditBarang_NamaBarang" placeholder="Masukan Nama Barang">
          </div>
          <div class="form-group">
            <label for="txt_EditBarang_Merk">Merk</label>
            <!-- <input type="text" class="form-control p-input" id="txt_EditBarang_Merk" name="txt_EditBarang_Merk" placeholder="Masukan Merk"> -->
            <?php echo $form_merk_edit; ?>
          </div>          
          <div class="form-group">
            <label for="txt_EditBarang_HargaBeli">Harga Beli</label>
            <input type="number" min="1" class="form-control p-input" id="txt_EditBarang_HargaBeli" name="txt_EditBarang_HargaBeli" placeholder="Masukan Harga Beli">              
          </div>
          <div class="form-group">
            <label for="txt_EditBarang_HargaJual">Harga Jual</label>
            <input type="number" min="1" class="form-control p-input" id="txt_EditBarang_HargaJual" name="txt_EditBarang_HargaJual" placeholder="Masukan Harga Jual">
          </div>
          <div class="form-group">
            <label for="txt_EditBarang_Jumlah">Stok</label>
            <input type="number" min="1" class="form-control p-input" id="txt_EditBarang_Jumlah" name="txt_EditBarang_Jumlah" placeholder="Masukan Jumlah">
          </div>     
          <div class="form-group">
            <label for="txt_EditBarang_Diskon">Diskon</label>
            <input type="number" min="1" max="100" class="form-control p-input" id="txt_EditBarang_Diskon" name="txt_EditBarang_Diskon" value="0" placeholder="Masukan Diskon">
          </div>            
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" name="update" id="EditBarang" onclick="executeEditBarang()">Simpan</button>
          </div>
        </form>
      </div>      
    </div>
  </div>
</div>

<script type="text/javascript" src="<?= base_url() ?>js/barang/index.js"></script>

 