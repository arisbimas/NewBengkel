<style>
    th, td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;

    }
    th {
        background-color: #442321;
        color: white;
    }
    .table-center {
        margin-left: auto;
        margin-right: auto;
    }

    .text-center{
        text-align: center;
    }
    
</style>

<div class="">
    <h2 class="text-center">Laporan Penjualan Bulanan / Bulan <?= $bulanIni ?> </h2>
    <hr>
    <br>
    <table class="table-center center-aligned-table table-striped table-hover table-sm" id="tableBarang">
        <thead>
        <tr class="bg-warning">
            <th>No</th>
            <th>Nomor Faktur</th>
            <th>Kode Barang</th>  
            <th>Nama Barang</th>                  
            <th>Jumlah Beli</th>                    
            <th>Sub Total</th>            
        </tr>
        </thead>
        <tbody>
            <?php 
                $no =1 ;
                $total = 0;
            ?>
            <?php foreach ($penjualan as $sell) : ?>
                <tr>
                    <td scope="row"><?= $no++ ?></td>
                    <td><?= $sell['nomor_faktur'] ?></td>
                    <td><?= $sell['kode_barang'] ?></td>
                    <td><?= $sell['nama_barang'] ?></td>
                    <td><?= $sell['jumlah_beli'] ?></td>
                    <td><?= number_format($sell['sub_total']) ?></td>     
                    <?php $total = $total + $sell['sub_total'];?>                                   
                    <?php endforeach ?>                                        
                </tr>            
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" style="text-align:right">Total</td>
                <td><?= number_format($total) ?></td>
            </tr>
        </tfoot>
    </table>
</div>