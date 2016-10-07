<?php
	session_start();

	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		$USERID	  = $_POST["USERID"];
		$PASSWORD = $_POST["PASSWORD"];

		$server_name = "u608462316_sh";
		$server_username   = "u608462316_root";
		$server_password   = "shroot";

		$conn = new mysqli( $server_name, $server_username, $server_password );
		if ($conn->connect_error)
			header("Location: index.php?error=Connection to database failed");
		
		// $sql = "USE shdb";
		// $conn->query($sql);

		$sql = "SELECT * FROM users WHERE username = $USERID";
		$table_data = $conn->query($sql);

		if ( $table_data->num_rows == 0 ) {
			$_SESSION["loggedin"] = "no";
			header("Location: index.php?error=User does not exist!");
		} else {
			$row = $table_data->fetch_assoc();
			// strlen($row["passwd"])==strlen($PASSWORD) and strcmp($row["passwd"],$PASSWORD)==0
			if ( $row["password"] == $PASSWORD ){
				$_SESSION["loggedin"] = "yes";
				$_SESSION["userid"] = $USERID;
				// $_SESSION["userid"] = $row["uname"];
				header("Location: dashboard.php");
			} else {
				$_SESSION["loggedin"] = "no";
				header("Location: index.php?error=Wrong password entered!");
			}
		}

	} else {
		header("Location: index.php");
	}

?>