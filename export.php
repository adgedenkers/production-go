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
$result_output = "<table><tr><th>Short URL</th><th>Full ULR</th><th>Date Created</th><th>Usage</th></tr>";

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ //

//read data from database
$query = "SELECT * FROM urls ORDER BY open_count DESC";
if($result = $database->query($query, SQLITE_BOTH, $error))
{
	
  while($row = $result->fetch())
  {
		//$result_output = $result_output . 'INSERT INTO urls (url, chars, open_count, crated_by, tags) VALUES ';
		//$result_output = $result_output . '("'. $row['url'] . '", "' . $row['chars'] . '", "' . $row['open_count'] . '", "' . $row['crated_by'] . '", "' . $row['tags'] . '");';
		
		$result_output = $result_output . "<tr><td>http://go.va.gov/{$row['chars']}</td><td>{$row['url']}</td><td>{$row['created_by']}</td><td>{$row['open_count']}</td></tr>"
		
  }
	$result_output = $result_output . "</table>";
}
else
{
  die($error);
}
echo($result_output);
?>