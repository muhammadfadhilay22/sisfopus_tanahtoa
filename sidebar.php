 <?php
    include('connect.php');
    $sql = "select * from admin where id = '" . $_SESSION["id"] . "'";
    $result = $conn->query($sql);
    $ro = mysqli_fetch_array($result);

    ?>


 <div class="pcoded-main-container">
     <div class="pcoded-wrapper">
         <nav class="pcoded-navbar">
             <div class="pcoded-inner-navbar main-menu">
                 <div class="pcoded-navigatio-lavel">Navigasi</div>
                 <ul class="pcoded-item pcoded-left-item">
                     <li class="">
                         <a href="index.php">
                             <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                             <span class="pcoded-mtext">Beranda</span>
                         </a>
                     </li>

                     <?php if (($_SESSION['user'] == 'patient')) { ?>
                         <li class="">
                             <a href="laporan.php">
                                 <span class="pcoded-micon"><i class="feather icon-book"></i></span>
                                 <span class="pcoded-mtext">Laporan</span>
                             </a>
                         </li>
                     <?php } ?>

                     <?php if (($_SESSION['user'] == 'doctor')) { ?>
                         <li class="pcoded-hasmenu">
                             <a href="javascript:void(0)">
                                 <span class="pcoded-micon"><i class="feather icon-user"></i></span>
                                 <span class="pcoded-mtext">Pasien</span>
                             </a>
                             <ul class="pcoded-submenu">
                                 <li class="">
                                     <a href="view-patient.php">
                                         <span class="pcoded-mtext">Lihat Daftar Pasien</span>
                                     </a>
                                 </li>
                             </ul>
                         </li>
                     <?php } ?>

                     <?php if (($_SESSION['user'] == 'admin')) { ?>
                         <li class="pcoded-hasmenu">
                             <a href="javascript:void(0)">
                                 <span class="pcoded-micon"><i class="feather icon-user"></i></span>
                                 <span class="pcoded-mtext">Pasien</span>
                             </a>
                             <ul class="pcoded-submenu">
                                 <?php if ($_SESSION['user'] == 'admin') { ?>
                                     <li class="">
                                         <a href="patient.php">
                                             <span class="pcoded-mtext">Tambah Pasien</span>
                                         </a>
                                     </li>
                                 <?php } ?>
                                 <li class="">
                                     <a href="view-patient.php">
                                         <span class="pcoded-mtext">Lihat Daftar Pasien</span>
                                     </a>
                                 </li>
                             </ul>
                         </li>
                     <?php } ?>

                     <?php if (($_SESSION['user'] == 'admin') || ($_SESSION['user'] == 'doctor')) { ?>
                         <li class="pcoded-hasmenu">
                             <a href="javascript:void(0)">
                                 <span class="pcoded-micon"><i class="feather icon-edit"></i></span>
                                 <span class="pcoded-mtext">Rekam Medis</span>
                             </a>
                             <ul class="pcoded-submenu">
                                 <?php if (($_SESSION['user'] == 'doctor')) { ?>
                                     <li class="">
                                         <a href="appointment.php">
                                             <span class="pcoded-mtext">Tambah Rekam Medis</span>
                                         </a>
                                         <a href="view-appointments-approved.php">
                                             <span class="pcoded-mtext">Lihat Rekam Medis</span>
                                         </a>
                                     </li>
                                 <?php } ?>
                                 <?php if (($_SESSION['user'] == 'admin')) { ?>
                                     <li class="">
                                         <a href="view-appointments-approved.php">
                                             <span class="pcoded-mtext">Lihat Rekam Medis</span>
                                         </a>
                                     </li>
                                 <?php } ?>
                             </ul>
                         </li>
                     <?php } ?>
                     <?php if (($_SESSION['user'] == 'admin')) { ?>
                         <li class="">
                             <a href="laporan_datapasien.php">
                                 <span class="pcoded-micon"><i class="feather icon-book"></i></span>
                                 <span class="pcoded-mtext">Laporan</span>
                             </a>
                         </li>
                     <?php } ?>
                     <?php if (($_SESSION['user'] == 'doctor')) { ?>
                         <li class="">
                             <a href="laporan_dokter.php">
                                 <span class="pcoded-micon"><i class="feather icon-book"></i></span>
                                 <span class="pcoded-mtext">Laporan</span>
                             </a>
                         </li>
                     <?php } ?>

                     <li>
                         <a href="logout.php">
                             <i class="feather icon-log-out"></i> Keluar
                         </a>
                     </li>
                 </ul>
             </div>
         </nav>