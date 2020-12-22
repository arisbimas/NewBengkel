<div class="container">
    <div class="row ">
        <div class="col-md-10">
            <form action="<?= base_url('peoples'); ?>" method="post">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Cari..." name="keyword" autocomplate="off" autofocus="on">
                    <div class="input-group-append">
                        <input class="btn btn-outline-secondary" type="submit" name="submitCari"></input>
                    </div>
                </div>
            </form>
        </div>
        
    </div>
    <div class="row">
        <div class="col-md-10">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>                    
                    </tr>
                </thead>
                <tbody>
                    <?= $no = 1 ?>
                    <?php foreach ($peoples as $p ) : ?>
                    <tr>
                        <th><?= ++$start ?></th>
                        <th><?= $p['nama'] ?></th>
                        <th><?= $p['email'] ?></th>
                        <th>Action</th>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <?= $this->pagination->create_links(); ?>
        </div>
    </div>
</div>