<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();

if (isset($_POST['submit'])) {
    $eid = intval($_GET['editid']);
    $patient_id = intval($_POST['patient_id']);
    $room_charge = doubleval($_POST['room_charge']);
    $medication_charge = doubleval($_POST['medication_charge']);
    $consultation_fee = doubleval($_POST['consultation_fee']);
    $total_charge = $room_charge + $medication_charge + $consultation_fee;

    // Fetch the previous total charge and status
    $stmt = $con->prepare("SELECT total_charge, status FROM bill WHERE bill_id = ?");
    $stmt->bind_param("i", $eid);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $total_charge_before = $row['total_charge'];
    $status_before = $row['status'];

    // Revert insurance if the bill was previously paid
    if ($status_before === 'paid') {
        // Fetch current insurance
        $stmt = $con->prepare("SELECT insurance FROM tblpatient WHERE ID = ?");
        $stmt->bind_param("i", $patient_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $insur = $row['insurance'] + $total_charge_before;

        $new_status = ($insur - $total_charge) >= 0 ? 'paid' : 'Pending';
        $new_insur = $insur - $total_charge;

        // Update insurance and bill status if insurance covers the new charge
        if ($new_status === 'paid') {
            $amnt_to_paid = 0;
            $stmt = $con->prepare("UPDATE tblpatient SET insurance = ? WHERE ID = ?");
            $stmt->bind_param("di", $new_insur, $patient_id);
            $stmt->execute();
        } else {
            $amnt_to_paid =$total_charge-$insur ;
            $new_insur2=0;
            $stmt = $con->prepare("UPDATE tblpatient SET insurance = ? WHERE ID = ?");
            $stmt->bind_param("di", $new_insur2, $patient_id);
            $stmt->execute();
        }
        $stmt = $con->prepare("UPDATE bill SET room_charge = ?, medication_charge = ?, consultation_fee = ?, total_charge = ?, status = ? , amount_to_be_paid = ? WHERE bill_id = ?");
        $stmt->bind_param("ddddsdi", $room_charge, $medication_charge, $consultation_fee, $total_charge, $new_status,$amnt_to_paid, $eid);
        $stmt->execute();
    } else {
        // Update bill without touching insurance
        $stmt = $con->prepare("UPDATE bill SET room_charge = ?, medication_charge = ?, consultation_fee = ?, total_charge = ?,amount_to_be_paid=? WHERE bill_id = ?");
        $stmt->bind_param("dddddi", $room_charge, $medication_charge, $consultation_fee, $total_charge,$total_charge, $eid);
        $stmt->execute();
    }

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Bill info updated Successfully'); window.location.href = 'view_bill.php';</script>";
    } else {
        echo "<script>alert('Error Occurred or No changes made'); window.location.href = 'view_bill.php';</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin | Edit Patient</title>

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
                                <h1 class="mainTitle">Admin | Edit Bill</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li>
                                    <span>Admin</span>
                                </li>
                                <li class="active">
                                    <span>Edit Bill</span>
                                </li>
                            </ol>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row margin-top-30">
                                    <div class="col-lg-8 col-md-12">
                                        <div class="panel panel-white">
                                            <div class="panel-heading">
                                                <h5 class="panel-title">Edit Bill</h5>
                                            </div>
                                            <div class="panel-body">
                                                <form role="form" name="" method="post">
                                                    <?php
                                                    $eid = $_GET['editid'];
                                                    $ret = mysqli_query($con, "select * from bill where bill_id='$eid'");
                                                    $cnt = 1;
                                                    while ($row = mysqli_fetch_array($ret)) {

                                                    ?>
                                                        <div class="form-group">
                                                            <label for="doctorname">
                                                                Patient ID
                                                            </label>
                                                            <input type="text" name="patient_id" class="form-control" value="<?php echo $row['patient_id']; ?>" required="true" readonly="true">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="fess">
                                                                Room Charge
                                                            </label>
                                                            <input type="number" name="room_charge" class="form-control" value="<?php echo $row['room_charge']; ?>" required="true" maxlength="10">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="fess">
                                                                Medication Carge
                                                            </label>
                                                            <input type="number" id="medication_charge" name="medication_charge" class="form-control" value="<?php echo $row['medication_charge']; ?>" required="true">

                                                        </div>
                                                        <div class="form-group">
                                                            <label for="fess">
                                                                Consultation Fee
                                                            </label>
                                                            <input type="number" id="consultation_fee" name="consultation_fee" class="form-control" value="<?php echo $row['consultation_fee']; ?>" required="true">

                                                        </div>
                                                        <div class="form-group">
                                                            <label for="fess">
                                                                Creation Date
                                                            </label>
                                                            <input type="text" name="date" class="form-control" value="<?php echo $row['date_issued']; ?>" required="true" readonly="true">

                                                        </div>

                                                    <?php } ?>
                                                    <button type="submit" name="submit" id="submit" class="btn btn-o btn-primary">
                                                        Update
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="panel panel-white">
                                </div>
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