<!DOCTYPE html>
<html lang="en">
<?php require_once('check_login.php'); ?>
<?php include('head.php'); ?>
<?php include('header.php'); ?>
<?php include('sidebar.php'); ?>
<?php include('connect.php'); ?>

<?php
include('connect.php');
$sql = "select * from admin where id = '" . $_SESSION["id"] . "'";
$result = $conn->query($sql);
$row1 = mysqli_fetch_array($result);

?>


<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper full-calender">
                <div class="page-body">
                    <div class="row">
                        <?php
                        $sql_manage = "select * from manage_website";
                        $result_manage = $conn->query($sql_manage);
                        $row_manage = mysqli_fetch_array($result_manage);
                        ?>

                        <div class="row col-lg-12">
                            <h3><b>Dashboard</b></h3>
                        </div>
                        <div class="row col-lg-12">Selamat datang di website&nbsp;<b>Sistem Informasi Puskesmas Tanah Toa</b><br><br></div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-c-green update-card">
                                <div class="card-block">
                                    <div class="row align-items-end">
                                        <div class="col-8">

                                            <h4 class="text-white">
                                                <?php
                                                $sql = "SELECT * FROM tb_rekammedis";
                                                $qsql = mysqli_query($conn, $sql);
                                                echo mysqli_num_rows($qsql);
                                                ?>
                                            </h4>
                                            <h6 class="text-white m-b-0">Rekam Medis</h6>
                                        </div>
                                        <div class="col-4 text-right">
                                            <canvas id="update-chart-2" height="50"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-c-pink update-card">
                                <div class="card-block">
                                    <div class="row align-items-end">
                                        <div class="col-8">

                                            <h4 class="text-white">
                                                <?php
                                                $sql = "SELECT * FROM tb_pasien";
                                                $qsql = mysqli_query($conn, $sql);
                                                echo mysqli_num_rows($qsql);
                                                ?>
                                            </h4>
                                            <h6 class="text-white m-b-0">Orang Pasien</h6>
                                        </div>
                                        <div class="col-4 text-right">
                                            <canvas id="update-chart-3" height="50"></canvas>
                                        </div>
                                    </div>
                                </div>
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


<link rel="stylesheet" href="files/bower_components/chartist/css/chartist.css" type="text/css" media="all">
<!-- Chartlist charts -->
<script src="files/bower_components/chartist/js/chartist.js"></script>
<script src="files/assets/pages/chart/chartlist/js/chartist-plugin-threshold.js"></script>
<script type="text/javascript">
    /*Threshold plugin for Chartist start*/
    var appointment = [];
    <?php
    for ($i = 01; $i < 13; $i++) {
        $count = 0;
        $sql = "SELECT * FROM appointment WHERE (status !='') and delete_status='0' and MONTH(appointmentdate) = '" . $i . "'";
        $qsql = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($qsql);
    ?>
        appointment.push(<?php echo $count; ?>);
    <?php } ?>
    new Chartist.Line('.ct-chart1', {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Oct', 'Sep', 'Oct', 'Nov', 'Dec'],
        series: [
            appointment
        ]
    }, {
        showArea: false,

        axisY: {
            onlyInteger: true
        },
        plugins: [
            Chartist.plugins.ctThreshold({
                threshold: 4
            })
        ]
    });

    var defaultOptions = {
        threshold: 0,
        classNames: {
            aboveThreshold: 'ct-threshold-above',
            belowThreshold: 'ct-threshold-below'
        },
        maskNames: {
            aboveThreshold: 'ct-threshold-mask-above',
            belowThreshold: 'ct-threshold-mask-below'
        }
    };

    //Second Chat
    var patient = [];
    <?php
    for ($i = 01; $i < 13; $i++) {
        $count_patient = 0;
        $sql = "SELECT * FROM patient WHERE (status !='') and delete_status='0' and MONTH(admissiondate) = '" . $i . "'";
        $qsql = mysqli_query($conn, $sql);
        $count_patient = mysqli_num_rows($qsql);
    ?>
        patient.push(<?php echo $count_patient; ?>);
    <?php } ?>

    new Chartist.Line('.ct-chart1-patient', {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Oct', 'Sep', 'Oct', 'Nov', 'Dec'],
        series: [patient]
    }, {
        showArea: false,

        axisY: {
            onlyInteger: true
        },
        plugins: [
            Chartist.plugins.ctThreshold({
                threshold: 4
            })
        ]
    });

    var defaultOptions = {
        threshold: 0,
        classNames: {
            aboveThreshold: 'ct-threshold-above',
            belowThreshold: 'ct-threshold-below'
        },
        maskNames: {
            aboveThreshold: 'ct-threshold-mask-above',
            belowThreshold: 'ct-threshold-mask-below'
        }
    };
</script>