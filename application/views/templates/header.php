<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>BengkelKu</title>
  <link rel="stylesheet" href ="<?= base_url() ?>assets/fontawesome/css/all.css" />
  <link rel="stylesheet" href="<?= base_url() ?>assets/fontawesome/css/font-awesome-animation.min.css" />

  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
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
        <a class="navbar-brand brand-logo" href="../partials/index.php">BengkelKu</a>
        <a class="navbar-brand brand-logo-mini" href="../partials/index.php"><img src="<?= base_url() ?>assets/img/mini.jpg" alt=""></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center">
        <button class="navbar-toggler navbar-toggler d-none d-lg-block navbar-dark align-self-center mr-3" type="button" data-toggle="minimize">
          <!-- <span class="navbar-toggler-icon"></span> -->
          <span class="fas fa-align-center text-warning"></span>
        </button>        
        <ul class="navbar-nav ml-lg-auto d-flex align-items-center flex-row">
          <li class="nav-item">
            <a class="nav-link profile-pic" href="#notif" data-toggle="modal" title="Notification"><i class="fa fa-bell faa-ring animated text-warning"></i><span class="label label-warning">
              
            </span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link profile-pic" href="#"><img class="rounded-circle" src="<?= base_url() ?>assets/img/face.jpg" alt=""></a>
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
            <img src="<?= base_url() ?>assets/img/face.jpg" alt="">
            
            <p class="name">
              
            </p>
            <p class="designation">
              
            </p>
            <span class="online"></span>
          </div>
          <ul class="nav">
            <li class="nav-item active">
              <a class="nav-link" href="../partials/index.php">
                <i class="fab fa-slack mr-4 fa-2x"></i>
                <span class="menu-title">Dashboard</span>
              </a>
            </li>
            
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#master" aria-expanded="false" aria-controls="dropdown">
                <i class="fas fa-box-open mr-3 fa-2x text-warning"></i>
                <span class="menu-title">Master <i class="fas fa-chevron-circle-down"></i></span>
              </a>
              <div class="collapse" id="master">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>Barang/index">
                      <i class="fa fa-angle-right"></i>Barang
                    </a>
                  </li>                        
                </ul>
              </div>
            </li>
            
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#dropdown" aria-expanded="false" aria-controls="dropdown">
                <i class="fa fa-dolly mr-3 fa-2x text-success"></i>
                <span class="menu-title">Transaksi <i class="fas fa-chevron-circle-down"></i></span>
              </a>
              <div class="collapse" id="dropdown">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="../transaksi/brg_masuk.php">
                      <i class="fa fa-angle-right"></i>Barang Masuk
                    </a>
                  </li>

                  <li class="nav-item">
                    <a class="nav-link" href="../transaksi/brg_kirim.php">
                      <i class="fa fa-angle-left"></i>Barang Kirim
                    </a>
                  </li>

                  <li class="nav-item">
                    <a class="nav-link" href="../transaksi/jual.php">
                      <i class="fa fa-angle-left"></i>Penjualan
                    </a>
                  </li>                  
                </ul>
              </div>
            </li>

             <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#pgw" aria-expanded="false" aria-controls="pgw">
                <i class="fa fa-user-circle mr-4 fa-2x" style="color: lightpink"></i>
                <span class="menu-title">Pegawai <i class="fas fa-chevron-circle-down"></i></span>
              </a>
              <div class="collapse" id="pgw">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="../users/users.php">
                      <i class="fa fa-angle-right"></i>Users
                    </a>
                  </li>

                  <li class="nav-item">
                    <a class="nav-link" href="../users/montir.php">
                      <i class="fa fa-angle-left"></i>Montir
                    </a>
                  </li>                  
                </ul>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="../transaksi/jual.php">                
                <i class="fa fa-cart-plus mr-3 fa-2x" style="color: lightpink"></i>
                <span class="menu-title">Penjualan</span>                
              </a>
            </li>
            
            <!-- <li class="nav-item">
              <a class="nav-link" href="../transaksi/jasa.php">                
                <i class="fa fa-wrench mr-4 fa-2x" style="color: coral"></i>
                <span class="menu-title">Jasa</span>                
              </a>
            </li> -->

            <li class="nav-item">
              <a class="nav-link" href="../transaksi/today.php">                
                <i class="fab fa-trello mr-4 fa-2x" style="color: lightseagreen"></i>
                <span class="menu-title">Today</span>                
              </a>
            </li>          
            
          </ul>
        </nav>


<!-- modal -->
  <div class="modal fade mt-3" id="logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">              
        <div class="modal-body text-center">
          <h3><i class="fa fa-question-circle"></i></h3>
          <h4><strong>Apakah Anda Akan Keluar???</strong></h4>
        <hr>
        <div class="text-center">
          <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <a class="btn btn-danger ml-2" href="../partials/logout.php">Yes!</a>          
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
