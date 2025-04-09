<?php
include 'connect.php';

// Tangkap ID dari URL
$nikpasien = isset($_GET['nikpasien']) ? intval($_GET['nikpasien']) : 0;

// Validasi ID (Harus angka positif)
if ($nikpasien > 0) {
    $query = "SELECT * FROM tb_pasien WHERE nikpasien = $nikpasien LIMIT 1";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    if (!$data) {
        die("Data tidak ditemukan!");
    }
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
        <p><u>LAPORAN DATA PASIEN</u></p>
    </div>
    <br><br>
    <table>
        <tr>
            <th colspan="2" class="section-title">Identitas Pasien</th>
        </tr>
        <tr>
            <td>Nik Pasien</td>
            <td><?= $data['nikpasien']; ?></td>
        </tr>
        <tr>
            <td>Nama Pasien</td>
            <td><?= $data['namapasien']; ?></td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td><?= $data['jenkel']; ?></td>
        </tr>
        <tr>
            <td>Keluhan</td>
            <td><?= $data['keluhan']; ?></td>
        </tr>
        <tr>
            <td>Status Layanan</td>
            <td><?= $data['statuslayanan']; ?></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td><?= $data['alamat']; ?></td>
        </tr>
        <tr>
            <td>Nomor HP</td>
            <td><?= $data['nohp']; ?></td>
        </tr>
    </table>

    <p style="margin-top: 30px; text-align: right;">Tanah Toa, <?= date('d F Y'); ?></p>
    <p style="text-align: right;">Kepala Puskesmas Tanah Toa</p>
    <p style="margin-top: 50px; text-align: right;">________________________</p>
</body>

</html>