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
	'INSERT INTO urls (url, chars, open_count) ' .
	'VALUES ("http://vaww.oed.portal.va.gov/administration/communications", "comm", 0); ' .
    
	'INSERT INTO urls (url, chars, open_count) ' .
	'VALUES ("http://vaww.oed.portal.va.gov", "oed", 0); ' .
    
	'INSERT INTO urls (url, chars, open_count) ' .
	'VALUES ("http://vaww.oed.portal.va.gov/administration/communications/production", "production", 0); ' .

	'INSERT INTO urls (url, chars, open_count) ' .
	'VALUES ("http://vaww.oed.portal.va.gov/administration/communications/production/sandbox", "sandbox", 0); ' .

	'INSERT INTO urls (url, chars, open_count) ' .
	'VALUES ("http://vaww.mysite.portal.va.gov/personal/vhamaster_vhaisadenkea", "adge", 0) ';

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