<div class="container">
    <div class="row">
        <div class="col-md-6">            
            <form action="" method="post">
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Enter Name">
                    <small class="form-text text-danger"><?= form_error("nama") ?></small>
                </div>
                <div class="form-group">
                    <label for="npm">NPM</label>
                    <input type="number" class="form-control" name="npm" id="npm" placeholder="Enter NPM">
                    <small class="form-text text-danger"><?= form_error("npm") ?></small>
                </div>
                <div class="form-group">
                    <label for="jurusan">Jurusan</label>
                    <select name="jurusan" class="form-control">
                        <option value="TI">TI</option>
                        <option value="SI">SI</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter email">
                    <small class="form-text text-danger"><?= form_error("email") ?></small>
                </div>                
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>