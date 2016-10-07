<?php
	session_start();
	if( !isset($_SESSION["loggedin"]) or $_SESSION["loggedin"] != "yes" )
		header("Location: index.php?error=Please login first!");

?>

<!DOCTYPE html>

<html>

<head>
	<title>Object Tracker</title>

<!-- 	<script src="resources/jquery-2.2.3.min.js"></script>
	<link rel="stylesheet" href="resources/bootstrap-3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" href="resources/bootstrap-3.3.6/css/bootstrap-theme.min.css">
	<script src="resources/bootstrap-3.3.6/js/bootstrap.min.js"></script> -->
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>	

	<style type="text/css">
		body {
			padding-top: 70px;
		}
		#map-canvas {
			width:50%;
			height:calc(100% - 0);
			position:absolute;
			right:10px;
			top:60px;
			bottom:10px;
			overflow:hidden;
		}
		.table-borderless tr td{
			border: none !important;
			padding: 0px !important;
		}
	</style>

	<script src="http://maps.googleapis.com/maps/api/js"></script>
	<script>
		function initialize() {
			var mapProp = {
				center: myCenter,
				zoom:15,
				mapTypeId:google.maps.MapTypeId.HYBRID
			};
			var map = new google.maps.Map(document.getElementById("map-canvas"), mapProp);
			var marker = new google.maps.Marker({
				position:myCenter,
				//animation:google.maps.Animation.BOUNCE
			});
			marker.setMap(map);
		}
		// var myCenter = new google.maps.LatLng(25.5687593,91.9214266);
		// google.maps.event.addDomListener(window, 'load', initialize);
	</script>
</head>

<body>

<nav class="navbar navbar-fixed-top navbar-inverse">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="#"> Object Tracker </a>
		</div>
		
		<ul class="nav navbar-nav">
			<!-- <li class="active"><a href="#">Home</a></li>
			<li><a href="#">Page 1</a></li>
			<li><a href="#">Page 2</a></li>
			<li><a href="#">Page 3</a></li> -->
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li><p class="navbar-text"> Signed in as <?php echo $_SESSION["uname"] ?> </p></li>
			<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout </a></li>
			<!-- <li><a href="register.php"><span class="glyphicon glyphicon-user"></span> Register </a></li> -->
		</ul>
	</div>
</nav>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-6">

<?php

	$server_name = "u608462316_sh";
	$server_username = "u608462316_root";
	$server_password = "shroot";
	
	$DEVICEID = $_SESSION["userid"];

	$conn = new mysqli( $server_name, $server_username, $server_password );
	if ($conn->connect_error)
		die("Error: Connection to database failed");
	
	// $sql = "USE otdb";
	// $conn->query($sql);

	$sql = "SELECT `devid`, `switch1`, `switch2`
			FROM smarthome
			WHERE username = $USERID
			ORDER BY dateandtime DESC
			LIMIT 9";
	$table_data = $conn->query($sql);

	if ( $table_data->num_rows > 0 ) {
		$row = $table_data->fetch_assoc();
		// $id = $row["id"];
		$devid = $row["devid"];
		$switch1 = $row["switch1"];
		$switch2 = $row["switch2"];
		
		$table_body = "";
		while( $row = $table_data->fetch_assoc() ){
			$table_body .= "<tr>
								<td>". $row["devid"] ."</td>
								<td>". $row["switch1"] ."</td>
								<td>". $row["switch2"] ."</td>
							</tr>";
		}

		// echo "<script>
		// 		var myCenter = new google.maps.LatLng(".$lat.",".$long.");
		// 		google.maps.event.addDomListener(window, 'load', initialize);

		// 		var geocoder = geocoder = new google.maps.Geocoder();
		// 		geocoder.geocode({ 'latLng': myCenter }, function (results, status) {
		// 			if (status == google.maps.GeocoderStatus.OK) {
		// 				if (results[0]) {
		// 					$('#address').html(results[0].formatted_address);
		// 				}
		// 			}
		// 		});

		// 	</script>";
		// echo "ID: " . $id . "<br>Latitude: " . $lat . "<br>Longitude: " . $long . "Last Updated: " . $time;
		// echo '<div class="panel panel-info">
		// 		<div class="panel-heading">
		// 			<h3 class="panel-title">Last uploaded at <strong>'. $time .'</strong> </h3>
		// 		</div>
		// 		<div class="panel-body">
		// 			<table class="table table-borderless">
		// 				<tr>
		// 					<td>Latitude:</td>
		// 					<td>'. $lat .'</td>
		// 				</tr>
		// 				<tr>
		// 					<td>Longitude:</td>
		// 					<td>'. $long .'</td>
		// 				</tr>
		// 				<tr>
		// 					<td>Address:</td>
		// 					<td id="address"></td>
		// 				</tr>
		// 				<tr>
		// 					<td>Temperature:</td>
		// 					<td>'. $temp .'</td>
		// 				</tr>
		// 			</table>
		// 		</div>
		// 	</div>
		// 	<div class="panel panel-danger">
		// 		<div class="panel-heading">
		// 			<h3 class="panel-title">Old data </h3>
		// 		</div>
		// 		<table class="table">
		// 			<thead>
		// 				<tr>
		// 					<th>Time</th>
		// 					<th>Latitude</th>
		// 					<th>Longitude</th>
		// 					<th>Temperature</th>
		// 				</tr>
		// 			</thead>
		// 			<tbody>'.
		// 				$table_body
		// 			.'</tbody>
		// 		</table>
		// 	</div>';
	} else {
		echo "Error: No data!";
	}

?>

		</div>
		<div id="map-canvas" class="col-sm-6"><!-- style="width:1000px;height:600px;" -->
		</div>
	</div>
	
</div>

</body>

</html>