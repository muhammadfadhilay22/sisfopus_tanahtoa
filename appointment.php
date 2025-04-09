<?php require_once('check_login.php'); ?>
<?php include('head.php'); ?>
<?php include('header.php'); ?>
<?php include('sidebar.php'); ?>
<?php include('connect.php'); ?>

<?php
if (isset($_POST['btn_submit'])) {
    $nikpasien       = mysqli_real_escape_string($conn, $_POST['nikpasien']);
    $diaknosa        = mysqli_real_escape_string($conn, $_POST['diaknosa']);
    $statuslayanan   = mysqli_real_escape_string($conn, $_POST['statuslayanan']);
    $nobpjs          = mysqli_real_escape_string($conn, $_POST['nobpjs'] ?? '');
    $dokter          = mysqli_real_escape_string($conn, $_POST['dokter']);
    $namakk          = mysqli_real_escape_string($conn, $_POST['namakk']);
    $statuspasien    = mysqli_real_escape_string($conn, $_POST['statuspasien']);

    // Generate nomor rekam medis dengan format PTT-YYYYMMDDHHMMSS
    date_default_timezone_set('Asia/Jakarta');
    $tanggal_waktu = date('YmdHis');
    $rekammedis = "PTT-" . $tanggal_waktu;

    // Simpan ke database
    $sql = "INSERT INTO tb_rekammedis (
                nikpasien, diaknosa, dokter, namakk, rekammedis, statuspasien, tanggal_kunjungan
            ) VALUES (
                '$nikpasien', '$diaknosa', '$dokter', '$namakk', '$rekammedis', '$statuspasien', NOW()
            )";

    if (mysqli_query($conn, $sql)) {
        echo '
        <div class="popup popup--icon -success js_success-popup popup--visible">
            <div class="popup__background"></div>
            <div class="popup__content">
                <h3 class="popup__content__title">Success</h3>
                <p>Data Rekam Medis Berhasil Ditambahkan</p>
                <p><script>setTimeout("location.href = \'view-appointments-approved.php\';",1500);</script></p>
            </div>
        </div>';
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>

<!-- Page Content -->
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <h4>Input Rekam Medis</h4>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <ul class="breadcrumb-title">
                                <li class="breadcrumb-item"><a href="dashboard.php"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a>Rekam Medis</a></li>
                                <li class="breadcrumb-item"><a href="add_user.php">Input Rekam Medis</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Form Input -->
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-block">
                                    <form method="post" action="">

                                        <!-- Pilih Pasien -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Pasien</label>
                                                    <select class="form-control" name="nikpasien" id="nikpasien" required>
                                                        <option value="">-- Pilih Pasien --</option>
                                                        <?php
                                                        $sql_pasien = "SELECT * FROM tb_pasien";
                                                        $result_pasien = mysqli_query($conn, $sql_pasien);
                                                        while ($row = mysqli_fetch_array($result_pasien)) {
                                                            echo "<option value='{$row['nikpasien']}'
                                                                data-nama='{$row['namapasien']}'
                                                                data-jenkel='{$row['jenkel']}'
                                                                data-tgllahir='{$row['tgllahir']}'
                                                                data-alamat='{$row['alamat']}'
                                                                data-keluhan='{$row['keluhan']}'
                                                                data-statuslayanan='{$row['statuslayanan']}'>
                                                                {$row['nikpasien']} - {$row['namapasien']}
                                                            </option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Data Pasien -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nama Pasien</label>
                                                    <input class="form-control" id="namapasien" name="namapasien" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Jenis Kelamin</label>
                                                    <input class="form-control" id="jenkel" name="jenkel" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tanggal Lahir</label>
                                                    <input class="form-control" type="date" id="tgllahir" name="tgllahir" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Alamat</label>
                                                    <input class="form-control" id="alamat" name="alamat" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Status Layanan</label>
            <input class="form-control" id="statuslayanan" name="statuslayanan" readonly>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group">
            <label>Keluhan</label>
            <input class="form-control" id="keluhan" name="keluhan" readonly>
        </div>
    </div>
</div>


                                        <!-- Dokter & Status Pasien -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nama Dokter</label>
                                                    <select class="form-control" name="dokter" required>
                                                        <option value="" disabled selected>Pilih Dokter</option>
                                                        <option value="dr. A. Erilka Sri Abrar">dr. A. Erilka Sri Abrar</option>
                                                        <option value="dr. Yunita Risdifani">dr. Yunita Risdifani</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Status Pasien</label>
                                                    <select class="form-control" name="statuspasien" required>
                                                        <option value="">-- Pilih Status --</option>
                                                        <option value="Baru">Baru</option>
                                                        <option value="Lama">Lama</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Kepala Keluarga dan Diaknosa -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nama Kepala Keluarga</label>
                                                    <input class="form-control" name="namakk" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Diaknosa</label>
                                                    <input class="form-control" name="diaknosa" required>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="form-group text-right">
                                            <button type="submit" name="btn_submit" class="btn btn-primary">Submit</button>
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

<!-- Script untuk autofill data pasien -->
<script>
    document.getElementById('nikpasien').addEventListener('change', function () {
        const option = this.options[this.selectedIndex];
        document.getElementById('namapasien').value = option.getAttribute('data-nama');
        document.getElementById('jenkel').value = option.getAttribute('data-jenkel');
        document.getElementById('tgllahir').value = option.getAttribute('data-tgllahir');
        document.getElementById('alamat').value = option.getAttribute('data-alamat');
        document.getElementById('keluhan').value = option.getAttribute('data-keluhan');
        document.getElementById('statuslayanan').value = option.getAttribute('data-statuslayanan');
    });
</script>

<?php include('footer.php'); ?>
