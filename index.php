<?php 

	try {
		// create or open the database
		$database = new SQLiteDatabase('data/go-va-alpha.sqlite', 0666, $error);
	} catch(Exception $e) {
		die($e);
	}	
	
	$result_output = "";
	
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ //

	// get the characters, if any
	$short = $_GET['u'];
	
	$h = "none"
	
	$query = "SELECT * FROM urls WHERE chars = '{$short}'";
	if ($result = $database->query($query, SQLITE_BOTH, $error)) {
		while($row = $result->fetch()) {
			$h = $row['url'];
			$i = $row['open_count'] + 1;
			$update_query = "UPDATE urls SET open_count = '{$i}' WHERE chars = '{$short}'";
			$database->query($update_query, SQLITE_BOTH, $error);
		}
	}
	
	if ($h != "none") {
		header("Location:".$h);
	}

?>
