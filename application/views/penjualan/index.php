<div class="content-wrapper">
  <!-- <h3 class="page-heading mb-4">Pilih Barang</h3> -->
  <div class="row mb-2">
    <div class="col-lg-5">
      <div class="card">
        <div class="card-body">
        <h5 class="card-title">Pilih Barang</h5>
        <hr>
          <form class="col-sm-12" method="post" action="" id="formPilihBarang">                    
            <div class="form-group">
                <label for="txt_Barang_NamaBarang">Nama Barang</label>                
                <div class="input-group">
                    <input type="text" class="form-control p-input" id="txt_Barang_NamaBarang" name="txt_Barang_NamaBarang" placeholder="Nama Barang" disabled>
                    <div class="input-group-append">
                        <button class="btn btn-outline-success mx-1" type="button" data-toggle="modal" data-target="#popupBarang"><i class="fas fa-search fa-2x"></i></button>
                    </div>
                </div>                
            </div>
            <!-- <div class="form-group">
                <label for="txt_Barang_Merk">Merk</label>
                <input type="text" class="form-control p-input" id="txt_Barang_Merk" name="txt_Barang_Merk" placeholder="Merk" disabled>
            </div>          
            <div class="form-group">
                <label for="txt_Barang_HargaBeli">Harga Beli</label>
                <input type="number" min="1" class="form-control p-input" id="txt_Barang_HargaBeli" name="txt_Barang_HargaBeli" placeholder="Harga Beli" disabled>              
            </div>
            <div class="form-group">
                <label for="txt_Barang_HargaJual">Harga Jual</label>
                <input type="number" min="1" class="form-control p-input" id="txt_Barang_HargaJual" name="txt_Barang_HargaJual" placeholder="Harga Jual" disabled>
            </div>
            <div class="form-group">
                <label for="txt_Barang_Jumlah">Jumlah</label>
                <input type="number" min="1" class="form-control p-input" id="txt_Barang_Jumlah" name="txt_Barang_Jumlah" placeholder="Jumlah" disabled>
            </div>      -->
            <div class="form-group">
                <label for="txt_Barang_Diskon">Diskon</label>
                <input type="number" min="1" max="100" class="form-control p-input" id="txt_Barang_Diskon" name="txt_Barang_Diskon" value="0" placeholder="Diskon" disabled>
            </div>
            <div class="form-group">
                <label for="txt_Barang_JumlahBeli">Jumlah Beli</label>
                <input type="number" min="1" class="form-control p-input" id="txt_Barang_JumlahBeli" name="txt_Barang_JumlahBeli" value="0" placeholder="JumlahBeli">
            </div>            
            <div>
                <button type="button" class="btn btn-primary" name="tambah" id="" onclick="addToCart()"><i class="fas fa-cart-plus"></i> Tambahkan</button>
            </div>
          </form>
          
        </div>
      </div>
    </div>
    <div class="col-sm-7">
      <div class="card">
        <div class="card-body">
        <h5 class="card-title">Keranjang</h5>
        <hr>
          <div class="table-responsive">
            <table class="table table-striped table-hover table-lg" id="tableCart1">
              <thead>
                <tr class="">
                  <th>Nama Barang</th>       
                  <th>Harga Jual</th>
                  <th>Diskon</th>
                  <th>Jumlah Beli</th>
                  <th>Sub Total</th>
                  <th class="mx-auto">Aksi</th>                   
                </tr>
              </thead>
              <tbody>
                    
              </tbody>
              <tfoot>
                <tr>
                    <th colspan="4" style="text-align:right" class="pr-0">Total:</th>
                    <th id="totalHarga"></th>
                </tr>                    
              </tfoot>
              
            </table>
            
          </div>
          <div class="col-sm-12 ">
              <button class="btn btn-success float-right mx-3 px-5" onclick="execute()"><i class="fas fa-file-invoice"> Beli</i> </button>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- <h3 class="page-heading mt-4 mb-4">Keranjang</h3>
  <div class="row mb-2">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table center-aligned-table table-striped table-hover table-sm" id="tableCart">
              <thead>
                <tr class="bg-info text-white">
                  <th>No</th>
                  <th>Kode Barang</th>
                  <th>Nama Barang</th>                    
                  <th>Merk</th>
                  <th>Harga Jual</th>
                  <th>Diskon</th>
                  <th>Jumlah Beli</th>
                  <th>Sub Total</th>
                  <th class="mx-auto">Aksi</th>                   
                </tr>
              </thead>
              <tbody>
                    
              </tbody>
              <tfoot>
                <tr>
                    <th colspan="7" style="text-align:right" class="pr-0">Total:</th>
                    <th id="totalHarga"></th>
                </tr>                    
              </tfoot>
              
            </table>
            
          </div>
            <div class="col-sm-12 ">
                <button class="btn btn-success float-right mx-3 px-5" onclick="execute()"><i class="fas fa-file-invoice"> Beli</i> </button>
            </div>
        </div>
      </div>
    </div>
  </div> -->
</div>
  
<!-- Modal Pilih Barang -->
<div class="modal fade" id="popupBarang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pilih Barang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table mx-auto table-striped table-hover table-sm" id="tableBarang">
                    <thead>
                    <tr class="bg-warning">
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>                    
                        <th>Merk</th>                    
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>Diskon</th>
                        <!-- <th>Jumlah Beli</th> -->
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

<script type="text/javascript" src="<?= base_url() ?>js/penjualan/penjualan.js"></script>