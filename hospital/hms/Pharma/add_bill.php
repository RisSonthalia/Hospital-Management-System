<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();

if (isset($_POST['submit'])) {
    $patid = intval($_POST['patid']);
    // $roomcharge = doubleval($_POST['roomcharge']);
    $medicationcharge = doubleval($_POST['medicationcharge']);
    // $consultationfee = doubleval($_POST['consultationfee']);
    $totalcharge =$medicationcharge ; // Calculate total charge

    // Use prepared statement to get insurance
    $stmt = $con->prepare("SELECT insurance FROM tblpatient WHERE ID = ?");
    $stmt->bind_param("i", $patid);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $insur = $row['insurance'];

    $status = ($insur - $totalcharge) >= 0 ? 'paid' : 'Pending';

    // If insurance covers the charge, update insurance
    if ($status === 'paid') {
        $amnt_to_paid = 0;
        $stmt = $con->prepare("UPDATE tblpatient SET insurance = insurance - ? WHERE ID = ?");
        $stmt->bind_param("di", $totalcharge, $patid);
        $stmt->execute();
    } else {
        $amnt_to_paid =  $totalcharge - $insur;
        $new_ins = 0;
        $stmt = $con->prepare("UPDATE tblpatient SET insurance = ? WHERE ID = ?");
        $stmt->bind_param("di", $new_ins, $patid);
        $stmt->execute();
    }

    // Prepare INSERT statement
    $stmt = $con->prepare("INSERT INTO bill (patient_id,  medication_charge, total_charge, date_issued, status, amount_to_be_paid) VALUES (?, ?, ?, CURRENT_TIMESTAMP, ?, ?)");
    $stmt->bind_param("iddsd", $patid,  $medicationcharge, $totalcharge, $status, $amnt_to_paid);


    // Execute the statement and check for errors
    if ($stmt->execute()) {
        echo "<script>alert('Bill info added Successfully'); window.location.href='add_bill.php';</script>";
    } else {
        echo "<script>alert('Error Occurred');</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Pharamcy | Add Bill</title>

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('select[name="patid"]').change(function() {
                var patid = $(this).val();
                $.ajax({
                    url: 'get_patient_name.php', // PHP file to fetch patient name
                    method: 'POST',
                    data: {
                        patid: patid
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('input[name="patname"]').val(response.patientName);
                    }
                });
            });
        });
    </script>
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
                                <h1 class="mainTitle">Pharmacy | Add Bill</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li>
                                    <span>Pharmacy</span>
                                </li>
                                <li class="active">
                                    <span>Add Bill</span>
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
                                                <h5 class="panel-title">Add Bill</h5>
                                            </div>
                                            <div class="panel-body">
                                                <form role="form" id="reportform" name="reportform" method="post">
                                                    <div class="form-group">
                                                        <label for="patid">
                                                            Patient id
                                                        </label>
                                                        <select name="patid" class="form-control" required="required">
                                                            <?php $ret = mysqli_query($con, "SELECT * from tblpatient ");
                                                            while ($row = mysqli_fetch_array($ret)) {
                                                            ?>
                                                                <option value="<?php echo htmlentities($row['ID']); ?>">
                                                                    <?php echo htmlentities($row['ID']); ?>
                                                                </option>
                                                            <?php } ?>

                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="fess">
                                                            Patient Name
                                                        </label>

                                                        <input type="text" name="patname" class="form-control" required="true">
                                                    </div>

                                                    <!-- <div class="form-group">
                                                        <label for="roomcharge">
                                                            Room Charge
                                                        </label>
                                                        <input type="number" name="roomcharge" class="form-control" placeholder="Room Charge" required="true">
                                                    </div> -->
                                                    <div class="form-group">
                                                        <label for="medicationcharge">
                                                            Medication Charge
                                                        </label>
                                                        <input type="number" name="medicationcharge" class="form-control" placeholder="Medication Charge" required="true">
                                                    </div>
                                                    <!-- <div class="form-group">
                                                        <label for="consultationfee">
                                                            Consultation Fee
                                                        </label>
                                                        <input type="number" name="consultationfee" class="form-control" placeholder=" Consultation Fee" required="true">
                                                    </div> -->

                                                    <button type="submit" name="submit" id="submit" class="btn btn-o btn-primary">
                                                        Add
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

    <script>
        document.getElementById('reportform').onsubmit = function() {
            var textarea1 = document.getElementById('report');
            textarea1.value = textarea1.value.replace(/\n/g, '<br>');
            var textarea2 = document.getElementById('result');
            textarea2.value = textarea2.value.replace(/\n/g, '<br>');
        };
    </script>
    <!-- end: JavaScript Event Handlers for this page -->
    <!-- end: CLIP-TWO JAVASCRIPTS -->
</body>

</html>