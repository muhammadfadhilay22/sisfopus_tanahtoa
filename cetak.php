<?php
include 'connect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$id_rekammedis = isset($_GET['id_rekammedis']) ? intval($_GET['id_rekammedis']) : 0;

if ($id_rekammedis > 0) {
    // Ambil NIK pasien, namakk, dan statuspasien dari ID rekam medis
    $query_nik = "SELECT nikpasien, namakk, statuspasien FROM tb_rekammedis WHERE id_rekammedis = ?";
    $stmt_nik = mysqli_prepare($conn, $query_nik);
    
    if (!$stmt_nik) {
        die("Error dalam query (tb_rekammedis): " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt_nik, "i", $id_rekammedis);
    mysqli_stmt_execute($stmt_nik);
    mysqli_stmt_bind_result($stmt_nik, $nikpasien, $namakk, $statuspasien);
    mysqli_stmt_fetch($stmt_nik);
    mysqli_stmt_close($stmt_nik);

    if (!$nikpasien) {
        die("Data rekam medis tidak ditemukan!");
    }

    // Ambil data pasien berdasarkan nikpasien dari tb_pasien
    $query_pasien = "SELECT namapasien, nikpasien, tgllahir, alamat, jenkel, statuslayanan, nobpjs 
                     FROM tb_pasien WHERE nikpasien = ? LIMIT 1";
    $stmt_pasien = mysqli_prepare($conn, $query_pasien);

    if (!$stmt_pasien) {
        die("Error dalam query (tb_pasien): " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt_pasien, "s", $nikpasien);
    mysqli_stmt_execute($stmt_pasien);
    mysqli_stmt_bind_result($stmt_pasien, $namapasien, $nikpasien, $tgllahir, $alamat, $jenkel, $statuslayanan, $nobpjs);
    mysqli_stmt_fetch($stmt_pasien);
    mysqli_stmt_close($stmt_pasien);

    // Simpan hasil dalam array
    $data_pasien = compact('namapasien', 'nikpasien', 'tgllahir', 'alamat', 'jenkel', 'statuslayanan', 'nobpjs', 'namakk', 'statuspasien');

    // Ambil semua rekam medis pasien berdasarkan nikpasien
    $query_rekammedis = "SELECT rekammedis, tanggal_kunjungan, keluhan, diaknosa, dokter, namakk, statuspasien
                         FROM tb_rekammedis WHERE nikpasien = ? ORDER BY tanggal_kunjungan DESC";
    $stmt_rekammedis = mysqli_prepare($conn, $query_rekammedis);

    if (!$stmt_rekammedis) {
        die("Error dalam query (tb_rekammedis): " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt_rekammedis, "s", $nikpasien);
    mysqli_stmt_execute($stmt_rekammedis);
    mysqli_stmt_bind_result($stmt_rekammedis, $rekammedis, $tanggal_kunjungan, $keluhan, $diaknosa, $dokter, $namakk, $statuspasien);

    $rekammedis_list = [];
    while (mysqli_stmt_fetch($stmt_rekammedis)) {
        $rekammedis_list[] = compact('rekammedis', 'tanggal_kunjungan', 'keluhan', 'diaknosa', 'dokter', 'namakk', 'statuspasien');
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
    <title>Formulir Rekam Medis</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            width: 21cm;
            height: 29.7cm;
            margin: auto;
            padding: 1cm;
            background-color: #fff;
            border: 2px solid black;
        }

        .header {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }

        .section-title {
            font-weight: bold;
            background-color: #ddd;
            padding: 5px;
        }
    </style>
</head>

<body onload="window.print()">
    <div class="header">
        <p><u>LAPORAN REKAM MEDIS</u></p>
    </div>
    <br><br>
    <table>
        <tr>
            <th colspan="4" class="section-title">Identitas Pasien</th>
        </tr>
        <tr>
            <td>Nama Pasien</td>
            <td><?= htmlspecialchars($data_pasien['namapasien'] ?? '-'); ?></td>
            <td>NIK</td>
            <td><?= htmlspecialchars($data_pasien['nikpasien'] ?? '-'); ?></td>
        </tr>
        <tr>
            <td>Nama Kepala Keluarga</td>
            <td><?= htmlspecialchars($data_pasien['namakk'] ?? '-'); ?></td>
            <td>Status Pasien</td>
            <td><?= htmlspecialchars($data_pasien['statuspasien'] ?? '-'); ?></td>
        </tr>
        <tr>
            <td>Tanggal Lahir</td>
            <td><?= htmlspecialchars($data_pasien['tgllahir'] ?? '-'); ?></td>
            <td>Alamat</td>
            <td><?= htmlspecialchars($data_pasien['alamat'] ?? '-'); ?></td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td><?= htmlspecialchars($data_pasien['jenkel'] ?? '-'); ?></td>
            <td></td>
            <td></td>
        </tr>

        <tr>
            <th colspan="4" class="section-title">Riwayat Medis</th>
        </tr>
        <?php foreach ($rekammedis_list as $data_rekammedis) { ?>
            <tr>
                <td>Nomor Rekam Medis</td>
                <td><?= htmlspecialchars($data_rekammedis['rekammedis'] ?? '-'); ?></td>
                <td>Tanggal Kunjungan</td>
                <td><?= htmlspecialchars($data_rekammedis['tanggal_kunjungan'] ?? '-'); ?></td>
            </tr>
            <tr>
                <td>Keluhan</td>
                <td colspan="3"><?= htmlspecialchars($data_rekammedis['keluhan'] ?? '-'); ?></td>
            </tr>
            <tr>
                <td>Diagnosa</td>
                <td colspan="3"><?= htmlspecialchars($data_rekammedis['diaknosa'] ?? '-'); ?></td>
            </tr>
            <tr>
                <td>Dokter</td>
                <td colspan="3"><?= htmlspecialchars($data_rekammedis['dokter'] ?? '-'); ?></td>
            </tr>
            <tr>
                <td colspan="4"></td>
            </tr>
        <?php } ?>
        <tr>
            <th colspan="4" class="section-title">Informasi Layanan</th>
        </tr>
        <tr>
            <td>No. BPJS</td>
            <td><?= htmlspecialchars($data_pasien['nobpjs'] ?? '-'); ?></td>
            <td>Status Layanan</td>
            <td><?= htmlspecialchars($data_pasien['statuslayanan'] ?? '-'); ?></td>
        </tr>
    </table>

    <p style="margin-top: 30px; text-align: right;">Tanah Toa, <?= date('d F Y'); ?></p>
    <p style="text-align: right;">Kepala Puskesmas Tanah Toa</p>
    <p style="margin-top: 50px; text-align: right;">________________________</p>
</body>

</html>
