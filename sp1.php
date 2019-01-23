<?php

require_once('lib/nusoap.php');

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




//read data from database
$query = "SELECT * FROM urls ORDER BY open_count DESC";
if($result = $database->query($query, SQLITE_BOTH, $error))
{
  while($row = $result->fetch())
  {
	$result_output = $result_output . "{$row['url']},{$row['chars']},{$row['open_count']},1"."<br>";
	}
}
else
{
  die($error);
}


print $result_output;
?>

