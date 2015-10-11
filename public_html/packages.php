<?php
	//USER CAKE
	require_once("models/config.php");
	if (!securePage($_SERVER['PHP_SELF'])){die();}

	require_once('models/Gear.php');
    require_once('models/Package.php');
	require_once('models/Person.php');

    $packages = Package::getAllPackages();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<!-- INCLUDE BS HEADER INFO -->
	<?php include('templates/bs-head.php'); ?>

    <title>Welcome!</title>
</head>
<body>
	<!-- IMPORT NAVIGATION -->
	<?php include('templates/bs-nav.php'); ?>

    <!-- HEADER -->
    <div class="container-fluid gray">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1>Packages</h1>
            </div>
        </div><!-- end row -->
    </div><!-- end container -->

    <br /><br />

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <a class="btn btn-primary" href="new-package.php">New Package&nbsp;&nbsp;<span class="glyphicon glyphicon-plus"></span></a>
                    <a class="btn btn-primary" href="edit-packages.php">Edit Packages&nbsp;&nbsp;<span class="glyphicon glyphicon-pencil"></span></a>

                    <table class="table table-hover"> 
                        <!-- <colgroup>
                            <col class="one-fifth">
                            <col class="one-fifth">
                            <col class="one-fifth">
                            <col class="one-fifth">
                            <col class="one-fifth">
                            <col class="one-fifth">
                        </colgroup> -->
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th class='text-center'>Gear</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach($packages as $pkg){
                                    $gearList = $pkg->getGearList();

                                    echo "<tr>";
                                    echo "<td>" . $pkg->getTitle() . "</td>";
                                    echo "<td>" . $pkg->getDescription() . "</td><td class='text-center'>";
                                    foreach($gearList as $gear){
                                        echo getGearName($gear) . "<br />";
                                    }
                                    echo "</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </form>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- end container -->

    <br /><br />

    <!-- INCLUDE BS STICKY FOOTER -->
    <?php include('templates/bs-footer.php'); ?>

    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>