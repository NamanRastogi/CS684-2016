<?php
	
	if ($_SERVER["REQUEST_METHOD"] == "GET") {
		// $id = $_GET["id"]; 
		$username = $_GET["username"];
		$deviceid  = $_GET["deviceid"];
		$switch1  = $_GET["switch1"];
		$switch1  = $_GET["switch2"];

		$server_name = "u608462316_sh";
		$server_username = "u608462316_root";
		$server_password = "shroot";
		
		$conn = new mysqli( $server_name, $server_username, $server_password );
		if ( $conn->connect_error )
			die("Error: Connection to database failed");
		
		// $sql = "USE otdb";
		// $conn->query($sql);

		$sql = "INSERT INTO coordinates (username, devid, switch1, switch2, datenadtime) VALUES ( $username ,  $deviceid , $switch1 , $switch2 , now() )";
		if ( $conn->query($sql) )
			echo "Table Updated";
		else
			echo "Error: Table could not updated<br>" . $conn->error;
	} else
		echo "No data passed!";
	
?>