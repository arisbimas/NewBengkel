<div class="container">

<?php if($this->session->flashdata()): ?>
<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong><?= $this->session->flashdata('flash') ?></strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php endif ?>

    <div class="row">
        <div class="col-md-6">
            <a href="<?= base_url(); ?>mahasiswa/tambahMsh" class="btn btn-primary">Tambah Mahasiswa</a>
        </div>
    </div>

    <form action="" method="post">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="cari mhs" aria-describedby="basic-addon2" name="keyword">
            <div class="input-group-append" >
                <button class="btn btn-outline-primary" type="submit">Cari</button>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-md-6">
            <h3>Daftar MHS</h3>
            <?php if (empty($mahasiswa)) :?>
                <h4>Data Kosong</h4>
            <?php endif; ?>
            <ul class="list-group">
                <?php foreach ($mahasiswa as $mhs) : ?>
                    <li class="list-group-item"> 
                        <?= $mhs['nama']; ?>
                        <a href="<?= base_url() ?>mahasiswa/hapusMhs/<?= $mhs['id']; ?>" class="badge badge-danger float-right">hapus</a>                   
                        <a href="<?= base_url() ?>mahasiswa/detailMhs/<?= $mhs['id']; ?>" class="badge badge-info float-right">detail</a>  
                        <a href="<?= base_url() ?>mahasiswa/editMhs/<?= $mhs['id']; ?>" class="badge badge-success float-right">edit</a>                   
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
</div>