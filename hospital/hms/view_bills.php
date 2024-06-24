<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Patient | View Bills</title>

    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
    <link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
    <link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
    <link href="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" media="screen">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="screen">
    <link href="vendor/bootstrap-datepicker/bootstrap-datepicker3.standalone.min.css" rel="stylesheet" media="screen">
    <link href="vendor/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/plugins.css">
    <link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
</head>

<body>
    <div id="app">
        <?php include('include/sidebar.php'); ?>
        <div class="app-content">
            <?php include('include/header.php'); ?>
            <div class="main-content">
                <div class="wrap-content container" id="container">
                    <!-- start: PAGE TITLE -->
                    <section id="page-title">
                        <div class="row">
                            <div class="col-sm-8">
                                <h1 class="mainTitle">Patient | View Bills</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li>
                                    <span>Patient</span>
                                </li>
                                <li class="active">
                                    <span>View Bills</span>
                                </li>
                            </ol>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="over-title margin-bottom-15">View <span class="text-bold">Bills</span></h5>

                                <table class="table table-hover" id="sample-table-1">
                                    <thead>
                                        <tr>
                                            <th class="center">#</th>
                                            <th>Room Charge</th>
                                            <th>Medication Charge </th>
                                            <th>Consultation Fee </th>
                                            <th>Total Charge </th>
                                            <th>Date Issued </th>
                                            <th>Amount to be paid </th>
                                            <th>Status </th>
                                            <th>Pay </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $totalRoomCharge = 0;
                                        $totalMedicationCharge = 0;
                                        $totalConsultationFee = 0;
                                        $totalCharge = 0;
                                        $sql = mysqli_query($con, "select * from bill as b,tblpatient as p WHERE b.patient_id = p.ID AND p.ID = '" . $_SESSION['id'] . "'");
                                        $cnt = 1;
                                        while ($row = mysqli_fetch_array($sql)) {
                                            $totalRoomCharge += $row['room_charge'];
                                            $totalMedicationCharge += $row['medication_charge'];
                                            $totalConsultationFee += $row['consultation_fee'];
                                            $totalCharge += $row['total_charge'];
                                        ?>
                                            <tr>
                                                <td class="center"><?php echo $cnt; ?>.</td>
                                                <td><?php echo $row['room_charge']; ?></td>
                                                <td><?php echo $row['medication_charge']; ?></td>
                                                <td><?php echo $row['consultation_fee']; ?></td>
                                                <td><?php echo $row['total_charge']; ?>
                                                <td><?php echo $row['date_issued']; ?>
                                                <td><?php echo $row['amount_to_be_paid']; ?>
                                                <td><?php echo $row['status']; ?>
                                                </td>
                                                <?php if ($row['status'] == "Pending"){?>
                                                    <td>
                                                    <a href="pay_bill.php?billid=<?php echo $row['bill_id']; ?>">Pay bill</a>
                                                    </td>
                                                <?php
                                                }else{
                                                ?>
                                                    <td>
                                                        paid
                                                    </td>
                                                <?php 
                                                }
                                                ?>


                                            </tr>
                                        <?php
                                            $cnt = $cnt + 1;
                                        } ?>
                                        <!-- Display totals -->
                                        <tr style="font-weight: bold;">
                                            <td class="center">Total:</td>
                                            <td><?php echo $totalRoomCharge; ?></td>
                                            <td><?php echo $totalMedicationCharge; ?></td>
                                            <td><?php echo $totalConsultationFee; ?></td>
                                            <td><?php echo $totalCharge; ?></td>
                                            <td colspan="2"></td> <!-- Span over the last two columns -->
                                        </tr>
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
    <!-- start: FOOTER -->
    <?php include('include/footer.php'); ?>
    <!-- end: FOOTER -->

    <!-- start: SETTINGS -->
    <?php include('include/setting.php'); ?>

    <!-- end: SETTINGS -->
    </div>
    <!-- start: MAIN JAVASCRIPTS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/modernizr/modernizr.js"></script>
    <script src="vendor/jquery-cookie/jquery.cookie.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="vendor/switchery/switchery.min.js"></script>
    <!-- end: MAIN JAVASCRIPTS -->
    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
    <script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
    <script src="vendor/autosize/autosize.min.js"></script>
    <script src="vendor/selectFx/classie.js"></script>
    <script src="vendor/selectFx/selectFx.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
    <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <!-- start: CLIP-TWO JAVASCRIPTS -->
    <script src="assets/js/main.js"></script>
    <!-- start: JavaScript Event Handlers for this page -->
    <script src="assets/js/form-elements.js"></script>
    <script>
        jQuery(document).ready(function() {
            Main.init();
            FormElements.init();
        });
    </script>
    <!-- end: JavaScript Event Handlers for this page -->
    <!-- end: CLIP-TWO JAVASCRIPTS -->
</body>

</html>