<?php 
function serialize_ke_string($serial)
    {
        $hasil = unserialize($serial);
        return implode(', ', $hasil);
    }

?>

<div class="content-wrapper">
		<h3 class="page-heading mb-4">Data Barang</h3>
		<div class="row mb-2">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="col-lg-12 mb-4">
              <div class="row">
                <div class="col-lg-10 mb-2">
                  <button type="button" data-toggle="modal" data-target="#tbhBaru" class="btn btn-outline-success mr-2"><i class="fa fa-plus"></i> Sparepart Baru</button>
                  <a href="../export/lap_master_brg.php" class="btn btn-secondary mr-2"><i class="fa fa-print"></i> Export File</a>
                </div>              
                <div class="col-lg-2">                  
                  <h6 class="pull-right">Jumlah Record = <?= $jumlah_barang ?></h6>
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
                      <button type="button" id="btn-filter" class="btn btn-primary mx-1">Filter</button>
                      <button type="button" id="btn-reset" class="btn btn-default ">Reset</button>
                    </form>
                  </div>
                </div>                  	              
            </div>
            <div class="table-responsive">
              <table class="table center-aligned-table table-striped table-hover table-sm" id="table">
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
  <div class="modal fade" id="tbhBaru" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Barang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="" method="post" action="">
            <!-- <div class="form-row pull-right">
              <label for="id_brg">ID Barang</label>
              <input type="text" class="form-control p-input col-lg-4 ml-2 mr-2 mb-2" id="id_brg" name="id_brg" placeholder="Masukan ID Barang" value="<?= $idauto; ?>" readonly>
              <input type="text" class="form-control p-input col-lg-4 ml-2 mr-2 mb-2 " id="tgl_msk" name="tgl_msk" value="<?= $tgl_msk; ?>" readonly>
            </div> -->
            <br>
            <div class="form-group">
              <label for="nama_brg">Nama Barang</label>
              <input type="text" class="form-control p-input" id="nama_brg" name="nama_brg" placeholder="Masukan Nama Barang">
            </div>
            <div class="form-group">
              <label for="merk">Merk</label>
              <input type="text" class="form-control p-input" id="merk" name="merk" placeholder="Masukan Merk">
            </div>
            <!-- <div class="form-group">
              <label>Kompatibilitas</label>
              <select class="form-control select2-multiple" multiple="multiple" name="kompatibilitas[]">
                <option>Universal</option>                
                <option>Yamaha</option>
                <option>Honda</option>
                <option>Suzuki</option>
                <option>Kawasaki</option>
                <option>Lainnya</option>
              </select>
            </div> -->
            <div class="form-group">
              <label for="hrg_beli">Harga Beli</label>
              <input type="number" min="1" class="form-control p-input" id="hrg_beli" name="hrg_beli" placeholder="Masukan Harga Beli">              
            </div>
            <div class="form-group">
              <label for="hrg_jual">Harga Jual</label>
              <input type="number" min="1" class="form-control p-input" id="hrg_jual" name="hrg_jual" placeholder="Masukan Harga Jual">
            </div>
            <div class="form-group">
              <label for="jml">Jumlah</label>
              <input type="number" min="1" class="form-control p-input" id="jml" name="jml" placeholder="Masukan Jumlah">
            </div>            
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="tambah">Simpan</button>
            </div>
          </form>
        </div>      
      </div>
    </div>
  </div>


  <script type="text/javascript" src="<?= base_url() ?>js/index.js"></script>

 