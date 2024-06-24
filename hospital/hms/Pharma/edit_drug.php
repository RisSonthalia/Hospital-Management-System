<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();

if (isset($_POST['submit'])) {
    $drug_id = intval($_GET['editid']);
    $category = $_POST['category'];
    $drug_name = $_POST['drug_name'];
    $description = nl2br($_POST['description']);
    $description = nl2br($_POST['description']);
    $price = $_POST['price'];
    $quantity = $_POST['qty'];
    $sql = mysqli_query($con, "UPDATE drug_table SET name='$drug_name', category_name='$category', price='$price', description='$description', quantity='$quantity' WHERE drug_id='$drug_id'");


    if ($sql) {
        echo "<script>alert('Drug info updated Successfully');</script>";
        echo "<script>window.location.href ='view_drug.php'</script>";
    } else {
        echo "<script>alert('Something went wrong. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Pharmacy | Edit Drug</title>

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
                                <h1 class="mainTitle">Pharmacy | Edit Drug</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li>
                                    <span>Pharmacy</span>
                                </li>
                                <li class="active">
                                    <span>Edit Drug</span>
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
                                                <h5 class="panel-title">Edit Drug</h5>
                                            </div>
                                            <div class="panel-body">
                                                <form role="form" name="" method="post">
                                                    <?php
                                                    $eid = $_GET['editid'];
                                                    $ret_1 = mysqli_query($con, "select * from drug_table where drug_id='$eid'");
                                                    $cnt = 1;
                                                   

                                                    while ($row = mysqli_fetch_array($ret_1)) {

                                                    ?>
                                                        <div class="form-group">
                                                            <label for="DrugCategory">
                                                                Drug Category
                                                            </label>
                                                            <select name="category" class="form-control" required="true">
                                                                <option value="<?php echo htmlentities($row['category_name']); ?>">Select Category</option>
                                                                <?php $ret = mysqli_query($con, "select * from drug_category");
                                                                
                                                                while ($row1 = mysqli_fetch_array($ret)) {
                                                                ?>
                                                                    <option value="<?php echo htmlentities($row1['category_name']); ?>">
                                                                        <?php echo htmlentities($row1['category_name']); ?>
                                                                    </option>
                                                                <?php } ?>

                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="drug_name">
                                                                Drug Name
                                                            </label>
                                                            <input type="text" name="drug_name" class="form-control" value="<?php echo htmlentities($row['name']); ?>" required="true">
                                                        </div>


                                                        <div class="form-group">
                                                            <label for="price">
                                                                Description
                                                            </label>
                                                            <textarea name="description" id="description" class="form-control" required="true"><?php echo htmlentities($row['description']); ?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="price">
                                                                Price
                                                            </label>
                                                            <input type="number" name="price" class="form-control" value="<?php echo $row['price']; ?>" required="true">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="qty">
                                                                Quantity
                                                            </label>
                                                            <input type="number" name="qty" class="form-control" value="<?php echo $row['quantity']; ?>" required="true">
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