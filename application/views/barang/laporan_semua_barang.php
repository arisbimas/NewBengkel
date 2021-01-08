<style>
    th, td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;

    }
    th {
        background-color: #4CAF50;
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
    <h2 class="text-center">Laporan Semua Barang</h2>
    <hr>
    <br>
    <table class="table-center center-aligned-table table-striped table-hover table-sm" id="tableBarang">
        <thead>
        <tr class="bg-warning">
            <th>No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>                    
            <th>Merk</th>                    
            <th>Harga Beli</th>
            <th>Harga Jual</th>
            <th>Stok</th>
        </tr>
        </thead>
        <tbody>
            <?php $no =1 ?>
            <?php foreach ($barang as $brg) : ?>
                <tr>
                    <th scope="row"><?= $no++ ?></th>
                    <td><?= $brg['kode_barang'] ?></td>
                    <td><?= $brg['nama_barang'] ?></td>
                    <td><?= $brg['merk'] ?></td>
                    <td><?= $brg['harga_beli'] ?></td>
                    <td><?= $brg['harga_jual'] ?></td>
                    <td><?= $brg['stok'] ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>