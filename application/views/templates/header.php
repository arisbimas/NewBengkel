<!-- show notif min barang -->
<?php 
  $minBarang = $this->db->get_where('tbl_barang', ['stok <=' => MINBARANG]);    
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>BengkelKu</title>
  <link rel="stylesheet" href ="<?= base_url() ?>assets/bootstrap/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href ="<?= base_url() ?>assets/fontawesome/css/all.css" />
  <link rel="stylesheet" href="<?= base_url() ?>assets/fontawesome/css/font-awesome-animation.min.css" />

  <!-- <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'> -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/perfect-scrollbar/dist/css/perfect-scrollbar.min.css" />
  <link rel="stylesheet" href="<?= base_url() ?>assets/dataTables/dataTables.bootstrap4.min.css"  />
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/select2/dist/css/select2.min.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/select2/dist/css/select2-bootstrap.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/toaster/toastr.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/loader/Holdon/HoldOn.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css" />
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/site.css" />
  <link rel="shortcut icon" href="../favicon.ico" />
  <style>
    .brand-logo{
      font-family: 'Kaushan Script', 'Helvetica Neue', Helvetica, Arial, cursive;
      color: #fed136 !important;
    }
    .brand-logo:hover{
      color: #fec503 !important;      
    }
    .brand-logo-mini {
      width: 60px !important;
    }
    button {
      cursor: pointer;
    }
    .modal {
      z-index: 2000;
    }
  </style>
   
</head>

<body>
  <div class=" container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar navbar-default col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="bg-white text-center navbar-brand-wrapper">
        <a class="navbar-brand brand-logo" href="<?= base_url() ?>">BengkelKu</a>
        <a class="navbar-brand brand-logo-mini" href="<?= base_url() ?>"><img src="<?= base_url('assets/img/profile/'). $user['image'] ?>" alt=""></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center">
        <button class="navbar-toggler navbar-toggler d-none d-lg-block navbar-dark align-self-center mr-3" type="button" data-toggle="minimize">
          <!-- <span class="navbar-toggler-icon"></span> -->
          <span class="fas fa-align-center text-warning"></span>
        </button>        
        <ul class="navbar-nav ml-lg-auto d-flex align-items-center flex-row">
          <li class="nav-item">
            <a class="nav-link profile-pic" href="#notif" data-toggle="modal" title="Notification"><i class="fa fa-bell faa-ring animated text-warning"></i><span class="label label-warning">
              <?= $minBarang->num_rows() ?>
            </span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link profile-pic" href="#"><img class="rounded-circle" src="<?= base_url('assets/img/profile/').$user['image'] ?>" alt=""></a>
          </li>          
          <li class="nav-item">
            <a class="nav-link" href="#logout" data-toggle="modal" title="Keluar"><i class="fa fa-power-off animated"></i></a>
          </li>          
        </ul>
        <button class="navbar-toggler navbar-dark navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <!-- <span class="navbar-toggler-icon"></span> -->
          <span class="fas fa-ellipsis-v text-warning"></span>
        </button>
      </div>
    </nav>

    <!-- partial -->
    <div class="container-fluid">
      <div class="row row-offcanvas row-offcanvas-right">
        <!-- partial:partials/_sidebar.html -->
        <nav class="bg-white sidebar sidebar-offcanvas" id="sidebar">
          <div class="user-info">
            <img src="<?= base_url('assets/img/profile/').$user['image'] ?>" alt="">
            
            <p class="name">
              <?= $user['name'] ?>
            </p>
            <p class="designation">
              
            </p>
            <span class="online"></span>
          </div>
          <ul class="nav">
            <!-- query menu -->
            <?php
              $role_id = $user['role_id'];
              $queryMenu = "SELECT `tbl_menu`.*
              FROM `tbl_menu` JOIN `tbl_rolexmenu`
              ON `tbl_menu`.`id` = `tbl_rolexmenu`.`menu_id`
              WHERE `tbl_rolexmenu`.`role_id` = $role_id AND `tbl_menu`.`id_parent` = 0
              ORDER BY `tbl_rolexmenu`.`menu_id` ASC";

              $menu = $this->db->query($queryMenu)->result_array();
              
            ?>
            <!-- Looping for parent menu -->
            <?php foreach ($menu as $m) : ?>
              <!-- check has child menu -->
              <?php 
                $menu_id = $m['id'];
                $querySubMenu = "SELECT `tbl_menu`.*
                FROM `tbl_menu` JOIN `tbl_rolexmenu`
                ON `tbl_menu`.`id` = `tbl_rolexmenu`.`menu_id`
                WHERE `tbl_rolexmenu`.`role_id` = $role_id AND `tbl_menu`.`id_parent` = $menu_id
                ORDER BY `tbl_rolexmenu`.`menu_id` ASC";

                $subMenu = $this->db->query($querySubMenu);
              ?>

              <!-- if parent have child menu -->
              <?php if($subMenu->num_rows() > 0): ?>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="collapse" href="#<?= $m['url'] ?>" aria-expanded="false" aria-controls="dropdown">
                    <i class="fas fa-box-open mr-3 fa-2x text-warning"></i>
                    <span class="menu-title">Master <i class="fas fa-chevron-circle-down"></i></span>
                  </a>
                  <div class="collapse" id="<?= $m['url'] ?>">
                    <ul class="nav flex-column sub-menu">
                      <!-- print dropdown -->
                      <?php foreach($subMenu->result_array() as $sm): ?>
                        <li class="nav-item">
                          <a class="nav-link" href="<?= base_url($sm['url']) ?>">
                            <i class="<?= $sm['icon'] ?>"></i><?= $sm['title'] ?>
                          </a>
                        </li>                      
                      <?php endforeach ?>                                                               
                    </ul>
                  </div>
                </li>

                <!-- else parnt havnt child menu -->
                <?php else: ?>
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url($m['url']) ?>">
                      <i class="<?= $m['icon'] ?>"></i>
                      <span class="menu-title"><?= $m['title'] ?></span>
                    </a>
                  </li>
              <?php endif ?>
              
            <?php endforeach ?>                                          
            
          </ul>
        </nav>


<!-- modal -->
  <div class="modal fade mt-3" id="logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">              
        <div class="modal-body text-center">
          <h3><i class="fa fa-question-circle"></i></h3>
          <h4><strong>Keluar Dari Sistem?</strong></h4>
        <hr>
        <div class="text-center">
          <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <a class="btn btn-danger ml-2" href="<?= base_url('auth/logout') ?>">Ya!</a>          
        </div>
        </div>      
      </div>
    </div>
  </div>
  
  <div class="modal fade mt-3" id="notif" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Notification</h5>
          <button type="button" class=" btn btn-secondary" data-dismiss="modal" aria-label="Close">
            Close
          </button>
        </div>              
        <div class="modal-body">
          <?php foreach($minBarang->result_array() as $minBrg) :?>
            <div style='padding:5px' class='alert alert-warning'>
              <span class='glyphicon glyphicon-info-sign'></span> Stok  <a style='color:red'><?= $minBrg['nama_barang']; ?></a> yang tersisa sudah kurang dari <?= MINBARANG ?> . silahkan pesan lagi !!
            </div>
          <?php endforeach ?>
        </div>
        </div>      
      </div>
    </div>
  </div>

<script src="<?= base_url() ?>assets/jquery/jquery.min.js"></script>
<script src="<?= base_url() ?>assets/popper.js/dist/umd/popper.min.js"></script>
<script src="<?= base_url() ?>assets/bootstrap/dist/js/bootstrap.min.js"></script>        
<script src="<?= base_url() ?>assets/dataTables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/dataTables/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/perfect-scrollbar/dist/js/perfect-scrollbar.jquery.min.js"></script>
<script src="<?= base_url() ?>assets/toaster/toastr.min.js"></script>
<script src="<?= base_url() ?>assets/sweetalert2/package/dist/sweetalert2.all.min.js"></script>
<script src="<?= base_url() ?>assets/loader/HoldOn/HoldOn.min.js"></script>
<script src="<?= base_url() ?>assets/js/off-canvas.js"></script>
<script src="<?= base_url() ?>assets/js/hoverable-collapse.js"></script>
<script src="<?= base_url() ?>assets/js/misc.js"></script>
<script src="<?= base_url() ?>assets/js/chart.js"></script>
<script src="<?= base_url() ?>assets/js/maps.js"></script>
<script type="text/javascript">
  const baseUrl = '<?= base_url()?>';
</script>
<script src="<?= base_url() ?>assets/js/site.js"></script>
