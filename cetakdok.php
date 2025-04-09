<?php
include 'connect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$id_rekammedis = isset($_GET['id_rekammedis']) ? intval($_GET['id_rekammedis']) : 0;
$data_pasien = [];
$rekammedis_list = [];

if ($id_rekammedis > 0) {
    // Ambil NIK pasien, nama KK, dan status pasien dari tb_rekammedis
    $query_nik = "SELECT nikpasien, namakk, statuspasien FROM tb_rekammedis WHERE id_rekammedis = ?";
    $stmt_nik = mysqli_prepare($conn, $query_nik);
    mysqli_stmt_bind_param($stmt_nik, "i", $id_rekammedis);
    mysqli_stmt_execute($stmt_nik);
    mysqli_stmt_bind_result($stmt_nik, $nikpasien, $namakk, $statuspasien);
    mysqli_stmt_fetch($stmt_nik);
    mysqli_stmt_close($stmt_nik);

    if (!$nikpasien) {
        die("Data rekam medis tidak ditemukan!");
    }

    // Ambil data pasien
    $query_pasien = "SELECT namapasien, nikpasien, tgllahir, alamat, jenkel, statuslayanan, nobpjs 
                     FROM tb_pasien WHERE nikpasien = ? LIMIT 1";
    $stmt_pasien = mysqli_prepare($conn, $query_pasien);
    mysqli_stmt_bind_param($stmt_pasien, "s", $nikpasien);
    mysqli_stmt_execute($stmt_pasien);
    mysqli_stmt_bind_result($stmt_pasien, $namapasien, $nikpasien, $tgllahir, $alamat, $jenkel, $statuslayanan, $nobpjs);
    mysqli_stmt_fetch($stmt_pasien);
    mysqli_stmt_close($stmt_pasien);

    // Simpan hasil dalam array
    $data_pasien = compact('namapasien', 'nikpasien', 'tgllahir', 'alamat', 'jenkel', 'statuslayanan', 'nobpjs', 'namakk', 'statuspasien');

    // Ambil rekam medis pasien
    $query_rekammedis = "SELECT rekammedis, tanggal_kunjungan, keluhan, diaknosa, dokter 
                         FROM tb_rekammedis WHERE nikpasien = ? ORDER BY tanggal_kunjungan DESC";
    $stmt_rekammedis = mysqli_prepare($conn, $query_rekammedis);
    mysqli_stmt_bind_param($stmt_rekammedis, "s", $nikpasien);
    mysqli_stmt_execute($stmt_rekammedis);
    mysqli_stmt_bind_result($stmt_rekammedis, $rekammedis, $tanggal_kunjungan, $keluhan, $diaknosa, $dokter);

    while (mysqli_stmt_fetch($stmt_rekammedis)) {
        $rekammedis_list[] = compact('rekammedis', 'tanggal_kunjungan', 'keluhan', 'diaknosa', 'dokter');
    }
    mysqli_stmt_close($stmt_rekammedis);
} else {
    die("ID tidak valid!");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rekam Medis</title>
    <style>
        @page {
            size: A4;
            margin: 2cm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            color: #000;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2, .header h3 {
            margin: 0;
        }
        .content {
            width: 100%;
        }
        .content td {
            padding: 5px;
            vertical-align: top;
        }
        .content th {
            text-align: left;
            padding-right: 15px;
        }
        .signature {
            text-align: right;
            margin-top: 40px;
        }
        .rekam-medis-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .rekam-medis-table, .rekam-medis-table th, .rekam-medis-table td {
            border: 1px solid black;
            padding: 8px;
        }
        .rekam-medis-table th {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>

<div class="header">
    <h2>PEMERINTAH KABUPATEN BULUKUMBA</h2>
    <h3>PUSKESMAS TANAH TOA</h3>
    <p>Tanah Toa, Kajang, Kabupaten Bulukumba, Sulawesi Selatan, 92574</p>
    <p>Email: puskesmas@tanaktoa.go.id</p>
    <hr>
</div>

<p><strong>Kepada Yth,</strong></p>
<p>Kepala Puskesmas</p>
<p>di Tempat</p>

<p>Dengan hormat,</p>

<p>Bersama ini kami sampaikan laporan rekam medis pasien yang telah mendapatkan pelayanan kesehatan di Puskesmas Tanah Toa. Berikut adalah rincian data pasien:</p>

<table class="content">
    <tr>
        <th>Nama Pasien</th>
        <td>: <?= $data_pasien['namapasien'] ?? '-' ?></td>
    </tr>
    <tr>
        <th>Nama KK</th>
        <td>: <?= $data_pasien['namakk'] ?? '-' ?></td>
    </tr>
    <tr>
        <th>Status Pasien</th>
        <td>: <?= $data_pasien['statuspasien'] ?? '-' ?></td>
    </tr>
    <tr>
        <th>No. Rekam Medis</th>
        <td>: <?= $rekammedis_list[0]['rekammedis'] ?? '-' ?></td>
    </tr>
    <tr>
        <th>Tanggal Lahir</th>
        <td>: <?= $data_pasien['tgllahir'] ?? '-' ?></td>
    </tr>
    <tr>
        <th>Alamat</th>
        <td>: <?= $data_pasien['alamat'] ?? '-' ?></td>
    </tr>
    <tr>
        <th>Status Layanan</th>
        <td>: <?= $data_pasien['statuslayanan'] ?? '-' ?></td>
    </tr>
    <tr>
        <th>No. BPJS</th>
        <td>: <?= $data_pasien['nobpjs'] ?? '-' ?></td>
    </tr>
</table>

<h3>Rekam Medis</h3>
<table class="rekam-medis-table">
    <tr>
        <th>Tanggal</th>
        <th>Keluhan</th>
        <th>Diagnosa</th>
        <th>Dokter</th>
    </tr>
    <?php foreach ($rekammedis_list as $rekam) : ?>
    <tr>
        <td><?= $rekam['tanggal_kunjungan'] ?></td>
        <td><?= $rekam['keluhan'] ?></td>
        <td><?= $rekam['diaknosa'] ?></td>
        <td><?= $rekam['dokter'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<div class="signature">
    <p>Hormat kami,</p>
    <p><strong>Kepala Puskesmas Tanah Toa</strong></p>
    <p>______________________</p>
</div>

</body>
</html>
