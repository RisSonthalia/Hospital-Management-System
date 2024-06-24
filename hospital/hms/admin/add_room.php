<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();
if (isset($_POST['submit'])) {
    $num = $_POST['num'];
    $type = $_POST['type'];
    $capacity = $_POST['capacity'];
    $availability = $_POST['availability'];
    $rent = $_POST['rent'];

    $sql = mysqli_query($con, "INSERT INTO rooms (RoomId, Type, Capacity, Availability, RoomRent) VALUES ('$num', '$type', '$capacity', '$availability', '$rent')");
    if ($sql) {
        $_SESSION['msg'] = "Room added successfully !!";
    } else {
        $_SESSION['msg'] = "Error occurred while adding the room !!";
    }
}


if (isset($_GET['del'])) {
    $del_id = $_GET['del'];


    if ($stmt = $con->prepare("DELETE FROM rooms WHERE RoomId = ?")) {
        $stmt->bind_param("i", $del_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['msg'] = "Room deleted successfully !!";
        } else {
            $_SESSION['msg'] = "Error occurred while deleting the room or room not found!!";
        }

        $stmt->close();
    } else {
        $_SESSION['msg'] = "Error preparing statement for deletion.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin | Add Room</title>

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

            <!-- end: TOP NAVBAR -->
            <div class="main-content">
                <div class="wrap-content container" id="container">
                    <!-- start: PAGE TITLE -->
                    <section id="page-title">
                        <div class="row">
                            <div class="col-sm-8">
                                <h1 class="mainTitle">Admin | Add Room</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li>
                                    <span>Admin</span>
                                </li>
                                <li class="active">
                                    <span>Add Add Room</span>
                                </li>
                            </ol>
                        </div>
                    </section>
                    <!-- end: PAGE TITLE -->
                    <!-- start: BASIC EXAMPLE -->
                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="row margin-top-30">
                                    <div class="col-lg-6 col-md-12">
                                        <div class="panel panel-white">
                                            <div class="panel-heading">
                                                <h5 class="panel-title">Add Room</h5>
                                            </div>
                                            <div class="panel-body">
                                                <p style="color:red;"><?php echo htmlentities($_SESSION['msg']); ?>
                                                    <?php echo htmlentities($_SESSION['msg'] = ""); ?></p>
                                                <form role="form" name="roomnum" method="post">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">
                                                            Room Number
                                                        </label>
                                                        <input type="text" name="num" class="form-control" placeholder="Enter Room Number">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">
                                                            Room Type
                                                        </label>
                                                        <input type="text" name="type" class="form-control" placeholder="Enter Room Type">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">
                                                            Capacity
                                                        </label>
                                                        <input type="text" name="capacity" class="form-control" placeholder="Enter Capacity">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">
                                                            Availability
                                                        </label>
                                                        <input type="text" name="availability" class="form-control" placeholder="Enter Availability">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">
                                                            Room Rent
                                                        </label>
                                                        <input type="text" name="rent" class="form-control" placeholder="Enter Room Rent">
                                                    </div>





                                                    <button type="submit" name="submit" class="btn btn-o btn-primary">
                                                        Submit
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

                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="over-title margin-bottom-15">Manage <span class="text-bold">Room</span></h5>

                                <table class="table table-hover" id="sample-table-1">
                                    <thead>
                                        <tr>
                                            <th class="center">#</th>
                                            <th>Room Num</th>
                                            <th class="hidden-xs">Type</th>
                                            <th>Capacity</th>
                                            <th>Availability</th>
                                            <th>Rent</th>
                                            

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = mysqli_query($con, "select * from rooms");
                                        $cnt = 1;
                                        while ($row = mysqli_fetch_array($sql)) {
                                        ?>

                                            <tr>
                                                <td class="center"><?php echo $cnt; ?>.</td>
                                                <td class="hidden-xs"><?php echo $row['RoomId']; ?></td>
                                                <td><?php echo $row['Type']; ?></td>
                                                <td><?php echo $row['Capacity']; ?>
                                                </td>
                                                <td><?php echo $row['Availability']; ?>
                                                </td>
                                                <td><?php echo $row['RoomRent']; ?>
                                                </td>

                                                <td>
                                                    <div class="visible-xs visible-sm hidden-md hidden-lg">
                                                        <div class="btn-group" dropdown is-open="status.isopen">
                                                            <button type="button" class="btn btn-primary btn-o btn-sm dropdown-toggle" dropdown-toggle>
                                                                <i class="fa fa-cog"></i>&nbsp;<span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu pull-right dropdown-light" role="menu">
                                                                <li>
                                                                    <a href="#">
                                                                        Edit
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        Share
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        Remove
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                        <?php
                                            $cnt = $cnt + 1;
                                        } ?>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end: BASIC EXAMPLE -->
            <!-- end: SELECT BOXES -->

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