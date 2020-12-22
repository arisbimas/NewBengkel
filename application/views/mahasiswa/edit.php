<div class="container">
    <div class="row">
        <div class="col-md-6">            
            <form action="" method="post">
                <input type="hidden" value="<?= $mahasiswa['id'] ?>" name="id">
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Enter Name" value="<?= $mahasiswa['nama'] ?>">
                    <small class="form-text text-danger"><?= form_error("nama") ?></small>
                </div>
                <div class="form-group">
                    <label for="npm">NPM</label>
                    <input type="number" class="form-control" name="npm" id="npm" placeholder="Enter NPM" value="<?= $mahasiswa['npm'] ?>">
                    <small class="form-text text-danger"><?= form_error("npm") ?></small>
                </div>
                <div class="form-group">
                    <label for="jurusan">Jurusan</label>
                    <select name="jurusan" class="form-control">
                        <?php foreach ($jurusan as $j ) :?>                            
                            <?php if ($j == $mahasiswa['jurusan']):?>
                                <option value="<?= $j; ?>" selected><?= $j; ?></option>
                            <?php else: ?>
                                <option value="<?= $j; ?>"><?= $j; ?></option>
                            <?php endif; ?>
                            
                        <?php endforeach ?>
                        
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" value="<?= $mahasiswa['email'] ?>">
                    <small class="form-text text-danger"><?= form_error("email") ?></small>
                </div>                
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>