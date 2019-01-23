<?php

try 
{
  //create or open the database
  $database = new SQLiteDatabase('data/go-va.sqlite', 0666, $error);
}
catch(Exception $e) 
{
  die($error);
}
$result_output = "";

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ //

//read data from database
$query = "SELECT * FROM urls ORDER BY open_count DESC";
if($result = $database->query($query, SQLITE_BOTH, $error))
{
	
  while($row = $result->fetch())
  {
		$result_output = $result_output . 'INSERT INTO urls (url, chars, open_count, crated_by, tags) VALUES ';
		$result_output = $result_output . '("'. $row['url'] . '", "' . $row['chars'] . '", "' . $row['open_count'] . '", "' . $row['crated_by'] . '", "' . $row['tags'] . '");';
	
  }
}
else
{
  die($error);
}
echo("Current Output<br><hr><br>");
echo($result_output);
?>