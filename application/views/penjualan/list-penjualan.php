<div class="content-wrapper">
  <h3 class="page-heading mb-4">Data Penjualan Barang</h3>
  <div class="row mb-2">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="col-lg-12 mb-4">
            <div class="row">
              <div class="col-lg-9 mb-2">
                <a href="<?= base_url("penjualan/laporan_hari_ini") ?>" target="_blank" class="btn btn-secondary mr-2"><i class="fa fa-print"></i> Laporan Hari ini</a>
                <a href="<?= base_url("penjualan/laporan_mingguan") ?>" target="_blank" class="btn btn-secondary mr-2"><i class="fa fa-print"></i> Laporan Mingguan</a>
                <a href="<?= base_url("penjualan/laporan_bulanan") ?>" target="_blank" class="btn btn-secondary mr-2"><i class="fa fa-print"></i> Laporan Bulanan</a>
              </div>              
              <div class="col-lg-3">                  
                <h6 class="float-right">Jumlah Data = <span id="jmlRecordPenjualan"></span></h6>
              </div>                
            </div>
            <!-- <div class="row my-3">
                <div class="col-lg-12 ">
                  <form class="form-inline float-right" id="form-filter">
                    <div class="form-group mx-2">
                      <label for="filter">Filter</label>                    
                    </div>                    
                    <div class="form-group">
                      <input type="text" class="form-control datepicker" id="date_filter" name="filterDate" placeholder="dd mm yyyy">
                    </div>
                    <button type="button" id="btn-filter" class="btn btn-primary mx-1">Filter</button>
                    <button type="button" id="btn-reset" class="btn btn-default ">Reset</button>
                  </form>
                </div>
            </div>                  	               -->
          </div>
          <div class="table-responsive">
            <table class="table center-aligned-table table-striped table-hover table-sm" id="tablePenjualan">
              <thead>
                <tr class="bg-success">
                  <th>No</th>
                  <th>Nomer Faktur</th>
                  <th>Total Harga</th>                    
                  <th>Tanggal Transaksi</th>
                  <th>Aktor</th>
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

<!-- Modal Detail Penjualan -->
<div class="modal fade" id="popupViewDetailPenjualan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Penjualan :</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-striped table-hover table-lg mx-auto" id="tableDetailPenjualan">
          <thead>
            <tr class="bg-success">
              <th>No</th>
              <th>Nomor Faktur</th>
              <th>Kode Barang</th>  
              <th>Nama Barang</th>                  
              <th>Jumlah Beli</th>                    
              <th>Sub Total</th> 
            </tr>
          </thead>
          <tbody>
                
          </tbody>
          <tfoot>
                <tr>
                    <th colspan="5" style="text-align:right" class="pr-0">Total:</th>
                    <th id="totalHarga"></th>
                </tr>                    
              </tfoot>
        </table>
      </div>      
    </div>
  </div>
</div>

<script type="text/javascript" src="<?= base_url() ?>js/penjualan/list-penjualan.js"></script>

 