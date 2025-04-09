<?php
require_once('check_login.php');
include('head.php');
include('header.php');
include('sidebar.php');
include('connect.php');

if (isset($_GET['delid'])) {
  $delid = $_GET['delid'];
  $sql = "DELETE FROM tb_rekammedis WHERE id_rekammedis='$delid'";
  $qsql = mysqli_query($conn, $sql);
  if (mysqli_affected_rows($conn) > 0) {
    echo "<script>
                alert('Data rekammedis berhasil dihapus.');
                window.location.href = 'view-appointments-approved.php';
              </script>";
  } else {
    echo "<script>
                alert('Gagal menghapus data rekammedis.');
                window.location.href = 'view-appointments-approved.php';
              </script>";
  }
}
?>

<div class="pcoded-content">
  <div class="pcoded-inner-content">
    <div class="main-body">
      <div class="page-wrapper">
        <div class="page-header">
          <h4>Daftar Rekam Medis</h4>
        </div>
        <div class="page-body">
          <div class="card">
            <div class="card-block">
              <div class="table-responsive dt-responsive">
                <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Pasien</th>
                      <th>Jenis Kelamin</th>
                      <th>Nama KK</th>
                      <th>Baru/Lama</th>
                      <th>Rekam Medis</th>
                      <th>Tanggal Lahir</th>
                      <th>Keluhan</th>
                      <th>Diaknosa</th>
                      <th>Alamat</th>
                      <th>Status Layanan</th>
                      <th>No BPJS / NIK</th>
                      <th>Dokter</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
<tbody>
    <?php
    $no = 1;
    $sql = "SELECT rm.*, p.namapasien, p.jenkel, p.tgllahir, p.alamat, 
                   p.statuslayanan, p.keluhan, p.nobpjs  -- Ambil dari tb_pasien
            FROM tb_rekammedis rm 
            JOIN tb_pasien p ON rm.nikpasien = p.nikpasien";

    $qsql = mysqli_query($conn, $sql);

    while ($rs = mysqli_fetch_array($qsql)) {
        echo "<tr>
                <td>{$no}</td>
                <td>{$rs['namapasien']}</td>
                <td>{$rs['jenkel']}</td>
                <td>{$rs['namakk']}</td>
                <td>{$rs['statuspasien']}</td>
                <td>{$rs['rekammedis']}</td>
                <td>{$rs['tgllahir']}</td>
                <td>{$rs['keluhan']}</td>
                <td>{$rs['diaknosa']}</td>
                <td>{$rs['alamat']}</td>
                <td>{$rs['statuslayanan']}</td>  <!-- Sekarang dari tb_pasien -->
                <td>{$rs['nobpjs']}</td>          <!-- Sekarang dari tb_pasien -->
                <td>{$rs['dokter']}</td>
                <td>
                    <a href='cetak.php?id_rekammedis={$rs['id_rekammedis']}' class='btn btn-sm btn-success'>
                        <i class='fas fa-print'></i> Visit
                    </a>
                    <a href='edit_appoiment.php?id_rekammedis={$rs['id_rekammedis']}' class='btn btn-sm btn-primary'>
                        <i class='fas fa-edit'></i> Edit
                    </a>
                    <a href='view-appointments-approved.php?delid={$rs['id_rekammedis']}' class='btn btn-sm btn-danger' 
                       onclick='return confirm(\"Are you sure you want to delete this record?\")'>
                        <i class='fas fa-trash'></i> Delete
                    </a>
                </td>
              </tr>";
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
  </div>
</div>
<?php include('footer.php'); ?>