<!-- Font Awesome CDN -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<!-- Author Name: Nikhil Bhalerao +919423979339. 
PHP, Laravel and Codeignitor Developer
-->
<?php require_once('check_login.php'); ?>
<?php include('head.php'); ?>
<?php include('header.php'); ?>
<?php include('sidebar.php'); ?>
<?php include('connect.php');
if (isset($_GET['id'])) {
  $sql = "UPDATE patient SET delete_status='1' WHERE patientid='$_GET[id]'";
  $qsql = mysqli_query($conn, $sql);
  if (mysqli_affected_rows($conn) == 1) {
?>
    <div class="popup popup--icon -success js_success-popup popup--visible">
      <div class="popup__background"></div>
      <div class="popup__content">
        <h3 class="popup__content__title">
          Success
        </h3>
        <p>Data Pasien Berhasil Diedit.</p>
        <p>
          <!--  <a href="index.php"><button class="button button--success" data-for="js_success-popup"></button></a> -->
          <?php echo "<script>setTimeout(\"location.href = 'view-patient.php';\",1500);</script>"; ?>
        </p>
      </div>
    </div>
<?php
    //echo "<script>alert('Dcctor record deleted successfully..');</script>";
    //echo "<script>window.location='view-patient.php';</script>";
  }
}
?>
<?php
if (isset($_GET['delid'])) { ?>
  <div class="popup popup--icon -question js_question-popup popup--visible">
    <div class="popup__background"></div>
    <div class="popup__content">
      <h3 class="popup__content__title">
        Sure
        </h1>
        <p>Are You Sure To Delete This Record?</p>
        <p>
          <a href="view-patient.php?id=<?php echo $_GET['delid']; ?>" class="button button--success" data-for="js_success-popup">Yes</a>
          <a href="view-patient.php" class="button button--error" data-for="js_success-popup">No</a>
        </p>
    </div>
  </div>
<?php } ?>
<div class="pcoded-content">
  <div class="pcoded-inner-content">

    <div class="main-body">
      <div class="page-wrapper">

        <div class="page-header">
          <div class="row align-items-end">
            <div class="col-lg-8">
              <div class="page-header-title">
                <div class="d-inline">
                  <h4>Daftar Pasien</h4>

                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                  <li class="breadcrumb-item">
                    <a href="dashboard.php"> <i class="feather icon-home"></i> </a>
                  </li>
                  <li class="breadcrumb-item"><a>Pasien</a>
                  </li>
                  <li class="breadcrumb-item"><a href="view_user.php">Daftar Pasien</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <div class="page-body">

          <div class="card">
            <div class="card-header">
              <!-- <h5>DOM/Jquery</h5>
<span>Events assigned to the table can be exceptionally useful for user interaction, however you must be aware that DataTables will add and remove rows from the DOM as they are needed (i.e. when paging only the visible elements are actually available in the DOM). As such, this can lead to the odd hiccup when working with events.</span> -->
            </div>
            <div class="card-block">
              <div class="table-responsive dt-responsive">
                <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>NIK</th>
                      <th>Nama Pasien</th>
                      <th>Jenis Kelamin</th>
                      <th>Alamat</th>
                      <th>No HP</th>
                      <th>Keluhan</th>
                      <th>Status Layanan</th>
                      <th>Poli</th>
                      <th width="15%">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if (isset($_GET['delid'])) {
                      $delid = $_GET['delid'];

                      // Query untuk menghapus data pasien berdasarkan ID
                      $sql = "DELETE FROM tb_pasien WHERE id_pasien='$delid'";
                      $qsql = mysqli_query($conn, $sql);

                      if (mysqli_affected_rows($conn) > 0) {
                        echo "<script>
            alert('Data pasien berhasil dihapus.');
            window.location.href = 'view-patient.php';
        </script>";
                      } else {
                        echo "<script>
            alert('Gagal menghapus data pasien.');
            window.location.href = 'view-patient.php';
        </script>";
                      }
                    }
                    ?>
                    <?php
                    // Inisialisasi variabel nomor
                    $no = 1;

                    // Query untuk mengambil data pasien
                    $sql = "SELECT * FROM tb_pasien";
                    $qsql = mysqli_query($conn, $sql);

                    // Loop untuk menampilkan data pasien
                    while ($rs = mysqli_fetch_array($qsql)) {
                      echo "<tr>
        <td>$no</td> <!-- Kolom nomor berurut -->
        
        <td>$rs[nikpasien]</td>
        <td>$rs[namapasien]</td>
        <td>$rs[jenkel]</td>
        <td>$rs[alamat]</td>
        <td>$rs[nohp]</td>
        <td>$rs[keluhan]</td>
        <td>$rs[statuslayanan]</td>
        <td>$rs[poli]</td>
        <td>
            <!-- Tombol Edit -->
            <a href='edit_patient.php?nikpasien={$rs['nikpasien']}' class='btn btn-sm btn-primary'>
                <i class='fas fa-edit'></i> Edit
            </a>
            
            <!-- Tombol Delete -->
            <a href='view-patient.php?delid={$rs['nikpasien']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this record?\")'>
                <i class='fas fa-trash'></i> Delete
            </a>
                
        </td>
    </tr>";

                      // Increment nomor urut
                      $no++;
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>







        </div>

      </div>
    </div>

    <div id="#">
    </div>
  </div>
</div>
</div>
</div>
</div>
</div>
<?php include('footer.php'); ?>
<?php if (!empty($_SESSION['success'])) {  ?>
  <div class="popup popup--icon -success js_success-popup popup--visible">
    <div class="popup__background"></div>
    <div class="popup__content">
      <h3 class="popup__content__title">
        Success
        </h1>
        <p><?php echo $_SESSION['success']; ?></p>
        <p>
          <?php echo "<script>setTimeout(\"location.href = 'view_user.php';\",1500);</script>"; ?>
          <!-- <button class="button button--success" data-for="js_success-popup">Close</button> -->
        </p>
    </div>
  </div>
<?php unset($_SESSION["success"]);
} ?>
<?php if (!empty($_SESSION['error'])) {  ?>
  <div class="popup popup--icon -error js_error-popup popup--visible">
    <div class="popup__background"></div>
    <div class="popup__content">
      <h3 class="popup__content__title">
        Error
        </h1>
        <p><?php echo $_SESSION['error']; ?></p>
        <p>
          <?php echo "<script>setTimeout(\"location.href = 'view_user.php';\",1500);</script>"; ?>
          <!--  <button class="button button--error" data-for="js_error-popup">Close</button> -->
        </p>
    </div>
  </div>
<?php unset($_SESSION["error"]);
} ?>
<script>
  var addButtonTrigger = function addButtonTrigger(el) {
    el.addEventListener('click', function() {
      var popupEl = document.querySelector('.' + el.dataset.for);
      popupEl.classList.toggle('popup--visible');
    });
  };

  Array.from(document.querySelectorAll('button[data-for]')).
  forEach(addButtonTrigger);
</script>