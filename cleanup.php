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

//insert data into database
$query = 
	'DELETE FROM urls WHERE chars = "oed";' .
	'DELETE FROM urls WHERE chars = "production";' .
	'DELETE FROM urls WHERE chars = "adge";' .
	'DELETE FROM urls WHERE chars = "comm";' .
	'DELETE FROM urls WHERE chars = "sandbox";' ;


if(!$database->queryExec($query, $error))
{
  die($error);
}






//read data from database
$query = "SELECT * FROM urls";
if($result = $database->query($query, SQLITE_BOTH, $error))
{
  while($row = $result->fetch())
  {
    print("Url: {$row['url']} <br />" .
          "Chars: {$row['chars']} <br />".
          "Count: {$row['open_count']} <br /><br />");
  }
}
else
{
  die($error);
}
?>