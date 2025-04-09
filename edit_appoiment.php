<?php require_once('check_login.php'); ?>
<?php include('head.php'); ?>
<?php include('header.php'); ?>
<?php include('sidebar.php'); ?>
<?php include('connect.php'); ?>

<?php
if (isset($_GET['id_rekammedis'])) {
    $id_rekammedis = $_GET['id_rekammedis'];

    // Mengambil data rekam medis dan pasien berdasarkan nikpasien
    $sql = "SELECT rm.*, p.nikpasien, p.namapasien, p.tgllahir, p.alamat 
            FROM tb_rekammedis rm 
            JOIN tb_pasien p ON rm.nikpasien = p.nikpasien 
            WHERE rm.id_rekammedis = '$id_rekammedis'";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($result);
}

// Proses update jika tombol Edit diklik
if (isset($_POST['btn_edit'])) {
    $keluhan        = mysqli_real_escape_string($conn, $_POST['keluhan']);
    $diaknosa       = mysqli_real_escape_string($conn, $_POST['diaknosa']);
    $statuslayanan  = mysqli_real_escape_string($conn, $_POST['statuslayanan']);
    $nobpjs         = mysqli_real_escape_string($conn, $_POST['nobpjs']);
    $dokter         = mysqli_real_escape_string($conn, $_POST['dokter']);
    $namakk         = mysqli_real_escape_string($conn, $_POST['namakk']);
    $rekammedis     = mysqli_real_escape_string($conn, $_POST['rekammedis']);
    $statuspasien   = mysqli_real_escape_string($conn, $_POST['statuspasien']);

    $update_sql = "UPDATE tb_rekammedis SET 
        keluhan = '$keluhan',
        diaknosa = '$diaknosa',
        statuslayanan = '$statuslayanan',
        nobpjs = '$nobpjs',
        dokter = '$dokter',
        namakk = '$namakk',
        rekammedis = '$rekammedis',
        statuspasien = '$statuspasien'
    WHERE id_rekammedis = '$id_rekammedis'";

    if (mysqli_query($conn, $update_sql)) {
        echo '<div class="popup popup--icon -success js_success-popup popup--visible">
                <div class="popup__background"></div>
                <div class="popup__content">
                <h3 class="popup__content__title">Success</h3>
                <p>Data Rekam Medis Berhasil Diperbarui</p>
                <p>';
        echo "<script>setTimeout(\"location.href = 'view-appointments-approved.php';\",1500);</script>";
        echo '</p></div></div>';
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Edit Rekam Medis</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="dashboard.php"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a>Rekam Medis</a></li>
                                    <li class="breadcrumb-item"><a href="#">Edit Rekam Medis</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-block">
                                    <form id="main" method="post" action="">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Keluhan</label>
                                                    <input class="form-control" name="keluhan" required value="<?php echo $data['keluhan']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nama Dokter</label>
                                                    <input class="form-control" name="dokter" required value="<?php echo $data['dokter']; ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Status Pasien</label>
                                                    <select class="form-control" name="statuspasien" required>
                                                        <option value="Baru" <?php echo ($data['statuspasien'] == 'Baru') ? 'selected' : ''; ?>>Baru</option>
                                                        <option value="Lama" <?php echo ($data['statuspasien'] == 'Lama') ? 'selected' : ''; ?>>Lama</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nama Kepala Keluarga</label>
                                                    <input class="form-control" name="namakk" required value="<?php echo $data['namakk']; ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>No. Rekammedis</label>
                                                    <input class="form-control" name="rekammedis" required value="<?php echo $data['rekammedis']; ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Status Layanan</label>
                                                    <select class="form-control" name="statuslayanan" required>
                                                        <option value="Umum" <?php echo ($data['statuslayanan'] == 'Umum') ? 'selected' : ''; ?>>Umum</option>
                                                        <option value="BPJS" <?php echo ($data['statuslayanan'] == 'BPJS') ? 'selected' : ''; ?>>BPJS</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>No BPJS/NIK</label>
                                                    <input class="form-control" name="nobpjs" required value="<?php echo $data['nobpjs']; ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Diaknosa</label>
                                                    <input class="form-control" name="diaknosa" required value="<?php echo $data['diaknosa']; ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group text-right">
                                            <button type="submit" name="btn_edit" class="btn btn-primary">Edit</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>