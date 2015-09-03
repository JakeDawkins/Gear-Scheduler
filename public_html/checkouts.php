<?php
	//USER CAKE
	require_once("models/config.php");
	if (!securePage($_SERVER['PHP_SELF'])){die();}

	require_once('models/Checkout.php');
	require_once('models/Form.php');
	require_once('models/Gear.php');
	//require_once("models/config.php"); //needed for funcs
	require_once('models/funcs.php'); //to fetch details about person

	if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['month'])) {
		$month = test_input($_GET['month']);
		$year = test_input($_GET['year']);

		//calculate date from m/y
		$date = "$year-$month-01";
	} else {
		$date = date('Y-m-01'); //pick first of month
		$month = date('m');
		$year = date('y');
	}


	$start = $date;
	$end = strtotime(date("Y-m-d", strtotime($date)) . "+1 month");
	$end = date('Y-m-d', $end);

	$checkouts = array();
	$checkouts = Checkout::getCheckoutsInRange($start, $end);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!-- INCLUDE BS HEADER INFO -->
	<?php include('templates/bs-head.php'); ?>

	<title>Checkouts</title>
</head>
<body>
	<!-- IMPORT NAVIGATION -->
	<?php include('templates/bs-nav.php'); ?>

    <!-- HEADER -->
    <div class="container-fluid gray">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1>Checkouts</h1>
                <!-- <p class="lead">A system for scheduling gear among a team</p> -->
            </div>
        </div><!-- /.row -->
    </div><!-- /.container -->

	<br /><br />


	<!-- CHECKOUTS TABLE CONCEPT -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- <form class="form-inline"> -->
                <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
                    <select class="push-bottom form-control" style="display: inline" name="year" id="sel1">
                        <!-- <option value="2015" selected="selected">2015</option>
                        <option value="2016">2016</option> -->
                        <option value="2015" <?php if ($year == 15) echo 'selected="selected"';?>>2015</option>
						<option value="2016" <?php if ($year == 16) echo 'selected="selected"';?>>2016</option>
                    </select>
                    <select class="push-bottom form-control" style="display: inline" name="month" id="sel2">
						<option value="01" <?php if ($month == 1) echo 'selected="selected"';?>>January</option>
						<option value="02" <?php if ($month == 2) echo 'selected="selected"';?>>February</option>
						<option value="03" <?php if ($month == 3) echo 'selected="selected"';?>>March</option>
						<option value="04" <?php if ($month == 4) echo 'selected="selected"';?>>April</option>
						<option value="05" <?php if ($month == 5) echo 'selected="selected"';?>>May</option>
						<option value="06" <?php if ($month == 6) echo 'selected="selected"';?>>June</option>
						<option value="07" <?php if ($month == 7) echo 'selected="selected"';?>>July</option>
						<option value="08" <?php if ($month == 8) echo 'selected="selected"';?>>August</option>
						<option value="09" <?php if ($month == 9) echo 'selected="selected"';?>>September</option>
						<option value="10" <?php if ($month == 10) echo 'selected="selected"';?>>October</option>
						<option value="11" <?php if ($month == 11) echo 'selected="selected"';?>>November</option>
						<option value="12" <?php if ($month == 12) echo 'selected="selected"';?>>December</option>
                    </select>
                    <button type="submit" name="submit" class="push-bottom full btn btn-primary">Filter</button> 
                    <a class="btn btn-primary pull-right" href="new-checkout.php">New Checkout&nbsp;&nbsp;<span class="glyphicon glyphicon-plus"></span></a>
                </form>

            </div>
        </div>

        <br />

        <div class="row">
            <div class="col-lg-12">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th class="hidden-xs">Description</th>
                            <th>Person</th>
                            <th>Start</th>
                            <th>End</th>
                            <th class="hidden-xs hidden-sm">Gear</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
							foreach($checkouts as $checkout){
								$person = $checkout->getPerson();
								$personDetails = fetchUserDetails(NULL,NULL,$person);

								printf("<tr>");
								printf("<td><a href='checkout.php?co_id=%s'>%s</a></td>",$checkout->getID(),$checkout->getTitle());
								printf("<td class=\"hidden-xs\">%s</td>",$checkout->getDescription());
								printf("<td>%s</td>",$personDetails['display_name']);
								printf("<td>%s</td>",$checkout->getStart());
								printf("<td>%s</td>",$checkout->getEnd());
								printf("<td class=\"hidden-xs hidden-sm\">");
								foreach($checkout->getGearList() as $gear){
									printf("%s<br>",getGearName($gear));
								}
								printf("</td></tr>");
							}
						?>
                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- /container -->

    <!-- INCLUDE BS STICKY FOOTER -->
    <?php include('templates/bs-footer.php'); ?>

    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>
</html>
