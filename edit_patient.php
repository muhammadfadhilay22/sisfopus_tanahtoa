<?php
require_once('check_login.php');
include('head.php');
include('header.php');
include('sidebar.php');
include('connect.php');

if (isset($_POST['btn_submit'])) {
    $nikpasien = mysqli_real_escape_string($conn, $_POST['nikpasien']);
    $namapasien = mysqli_real_escape_string($conn, $_POST['namapasien']);
    $tgllahir = mysqli_real_escape_string($conn, $_POST['tgllahir']);
    $jenkel = mysqli_real_escape_string($conn, $_POST['jenkel']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $nohp = mysqli_real_escape_string($conn, $_POST['nohp']);
    // $tgldaftar = mysqli_real_escape_string($conn, $_POST['tgldaftar']);

    if (isset($_GET['nikpasien'])) {
        // UPDATE QUERY berdasarkan nikpasien
        $sql = "UPDATE tb_pasien SET 
                    namapasien = '$namapasien',
                    tgllahir = '$tgllahir',
                    jenkel = '$jenkel',
                    alamat = '$alamat',
                    nohp = '$nohp'
                WHERE nikpasien = '$nikpasien'";

        if (mysqli_query($conn, $sql)) {
            echo '<div class="popup popup--icon -success js_success-popup popup--visible">
                    <div class="popup__background"></div>
                    <div class="popup__content">
                        <h3 class="popup__content__title">Success</h3>
                        <p>Data Pasien Berhasil Diedit</p>
                        <p>' . "<script>setTimeout(\"location.href = 'view-patient.php';\",1500);</script>" . '</p>
                    </div>
                  </div>';
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        // INSERT QUERY
        $sql = "INSERT INTO tb_pasien (nikpasien, namapasien, tgllahir, jenkel, alamat, nohp)
                VALUES ('$nikpasien', '$namapasien', '$tgllahir', '$jenkel', '$alamat', '$nohp')";

        if (mysqli_query($conn, $sql)) {
            echo '<div class="popup popup--icon -success js_success-popup popup--visible">
                    <div class="popup__background"></div>
                    <div class="popup__content">
                        <h3 class="popup__content__title">Success</h3>
                        <p>Data Pasien Berhasil Ditambahkan</p>
                        <p>' . "<script>setTimeout(\"location.href = 'view-patient.php';\",1500);</script>" . '</p>
                    </div>
                  </div>';
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

if (isset($_GET['nikpasien'])) {
    $sql = "SELECT * FROM tb_pasien WHERE nikpasien = '$_GET[nikpasien]'";
    $qsql = mysqli_query($conn, $sql);
    $rsedit = mysqli_fetch_array($qsql);
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
                                    <h4>Edit Data Pasien</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="dashboard.php"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a>Pasien</a></li>
                                    <li class="breadcrumb-item"><a href="add_user.php">Edit Data Pasien</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header"></div>
                                <div class="card-block">
                                    <form id="main" method="post" action="" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">NIK Pasien</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="nikpasien" id="nikpasien"
                                                    placeholder="Masukkan NIK Pasien" value="<?php echo $rsedit['nikpasien'] ?? ''; ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Nama Pasien</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="namapasien" id="namapasien"
                                                    placeholder="Masukkan Nama Pasien" value="<?php echo $rsedit['namapasien'] ?? ''; ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Tanggal Lahir</label>
                                            <div class="col-sm-4">
                                                <input type="date" class="form-control" name="tgllahir" id="tgllahir"
                                                    value="<?php echo $rsedit['tgllahir'] ?? ''; ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" name="jenkel" required="">
                                                    <option value="disabled">--Pilih Jenis Kelamin--</option>
                                                    <option value="Laki-Laki" <?php echo isset($rsedit['jenkel']) && $rsedit['jenkel'] == 'Laki-Laki' ? 'selected' : ''; ?>>Laki-Laki</option>
                                                    <option value="Perempuan" <?php echo isset($rsedit['jenkel']) && $rsedit['jenkel'] == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Alamat</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="alamat" value="<?php echo $rsedit['alamat'] ?? ''; ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Nomor HP/Whatsapp</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="nohp" value="<?php echo $rsedit['nohp'] ?? ''; ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-10">
                                                <button type="submit" name="btn_submit" class="btn btn-primary m-b-0">Edit</button>
                                            </div>
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

    <?php include('footer.php'); ?>