<?php
require_once('check_login.php');
include('head.php');
include('header.php');
include('sidebar.php');
include('connect.php');

if (isset($_POST['btn_submit'])) {
    // Sanitasi input untuk menghindari SQL Injection
    $nikpasien = mysqli_real_escape_string($conn, $_POST['nikpasien']);
    $namapasien = mysqli_real_escape_string($conn, $_POST['namapasien']);
    $tgllahir = mysqli_real_escape_string($conn, $_POST['tgllahir']);
    $jenkel = mysqli_real_escape_string($conn, $_POST['jenkel']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $nohp = mysqli_real_escape_string($conn, $_POST['nohp']);
    $status_layanan = mysqli_real_escape_string($conn, $_POST['statuslayanan']);

    // Jika status layanan adalah BPJS, simpan nomor BPJS, jika tidak biarkan NULL
    $nobpjs = ($status_layanan == 'bpjs' && !empty($_POST['nobpjs'])) 
              ? mysqli_real_escape_string($conn, $_POST['nobpjs']) 
              : NULL;

    // Cek apakah NIK sudah ada di database
    $cek_nik = mysqli_query($conn, "SELECT * FROM tb_pasien WHERE nikpasien = '$nikpasien'");

    if (mysqli_num_rows($cek_nik) > 0) {
        // Jika NIK sudah ada, update data pasien
        $sql = "UPDATE tb_pasien SET 
                    namapasien = '$namapasien',
                    tgllahir = '$tgllahir',
                    jenkel = '$jenkel',
                    alamat = '$alamat',
                    nohp = '$nohp',
                    statuslayanan = '$status_layanan',
                    nobpjs = " . ($nobpjs ? "'$nobpjs'" : "NULL") . ",
                    tgldaftar = NOW()
                WHERE nikpasien = '$nikpasien'";
        $message = "Data Pasien Berhasil Diperbarui";
    } else {
        // Jika NIK belum ada, insert data baru
        $sql = "INSERT INTO tb_pasien (
                    nikpasien, 
                    namapasien, 
                    tgllahir, 
                    jenkel, 
                    alamat, 
                    nohp, 
                    statuslayanan, 
                    nobpjs, 
                    tgldaftar
                ) VALUES (
                    '$nikpasien', 
                    '$namapasien', 
                    '$tgllahir', 
                    '$jenkel', 
                    '$alamat', 
                    '$nohp', 
                    '$status_layanan', 
                    " . ($nobpjs ? "'$nobpjs'" : "NULL") . ", 
                    NOW()
                )";
        $message = "Data Pasien Berhasil Ditambahkan";
    }

    if (mysqli_query($conn, $sql)) {
        echo '<div class="popup popup--icon -success js_success-popup popup--visible">
                <div class="popup__background"></div>
                <div class="popup__content">
                    <h3 class="popup__content__title">Success</h3>
                    <p>' . $message . '</p>
                    <p>' . "<script>setTimeout(\"location.href = 'view-patient.php';\",1500);</script>" . '</p>
                </div>
              </div>';
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Ambil data pasien jika sedang dalam mode edit
if (isset($_GET['editid'])) {
    $sql = "SELECT * FROM tb_pasien WHERE nikpasien = '" . mysqli_real_escape_string($conn, $_GET['editid']) . "'";
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
                                    <h4>Input Data Pasien</h4>
                                </div>
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
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">NIK Pasien</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="nikpasien" id="nikpasien"
                                                    placeholder="Masukkan NIK Pasien"
                                                    value="<?php echo $rsedit['nikpasien'] ?? ''; ?>"
                                                    maxlength="16"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16);"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Nama Pasien</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="namapasien" id="namapasien"
                                                    placeholder="Masukkan Nama Pasien"
                                                    value="<?php echo $rsedit['namapasien'] ?? ''; ?>" required>
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
                                                <select class="form-control" name="jenkel" required>
                                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                                    <option value="Laki-Laki" <?php echo (isset($rsedit['jenkel']) && $rsedit['jenkel'] == 'Laki-Laki') ? 'selected' : ''; ?>>Laki-Laki</option>
                                                    <option value="Perempuan" <?php echo (isset($rsedit['jenkel']) && $rsedit['jenkel'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                                                </select>
                                            </div>
                                        </div>

                                       <div class="form-group row">
    <label class="col-sm-2 col-form-label">Status Layanan</label>
    <div class="col-sm-4">
        <select class="form-control" name="statuslayanan" id="statuslayanan" required>
            <option value="" disabled selected>Pilih Status Layanan</option>
            <option value="umum">Umum</option>
            <option value="bpjs">BPJS</option>
        </select>
    </div>
</div>

<div class="form-group row" id="bpjs_input" style="display: none;">
    <label class="col-sm-2 col-form-label">No BPJS</label>
    <div class="col-sm-4">
        <input type="text" class="form-control" name="nobpjs" id="nobpjs" placeholder="Masukkan No BPJS"
            value="<?php echo $rsedit['nobpjs'] ?? ''; ?>">
    </div>
</div>

<script>
document.getElementById('statuslayanan').addEventListener('change', function() {
    var bpjsInput = document.getElementById('bpjs_input');
    if (this.value === 'bpjs') {
        bpjsInput.style.display = 'flex'; // Menampilkan input No BPJS
        document.getElementById('nobpjs').setAttribute('required', 'true');
    } else {
        bpjsInput.style.display = 'none'; // Menyembunyikan input No BPJS
        document.getElementById('nobpjs').removeAttribute('required');
    }
});
</script>

                                        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Alamat</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="alamat" id="alamat"
                                                    placeholder="Masukkan Alamat"
                                                    value="<?php echo $rsedit['alamat'] ?? ''; ?>" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">No HP</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="nohp" id="nohp"
                                                    placeholder="Masukkan No HP"
                                                    value="<?php echo $rsedit['nohp'] ?? ''; ?>"
                                                    maxlength="13"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13);"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-10">
                                                <button type="submit" name="btn_submit" class="btn btn-primary">Submit</button>
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