<?php
include('include/config.php');

if(isset($_POST['patid'])) {
    $patid = $_POST['patid'];
    $query = mysqli_query($con, "SELECT PatientName FROM tblpatient WHERE ID = '$patid'");
    $row = mysqli_fetch_assoc($query);
    echo json_encode(array('patientName' => $row['PatientName']));
    exit;
}

