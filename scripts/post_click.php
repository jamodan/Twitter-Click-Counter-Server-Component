<?php
/*
 * Created By : Daniel Jamison
 */

	$ProfileName=$_GET['ProfileName'];
	$URL=$_GET['URL'];
	
	require 'connectNEW.php';
	
	$query= "SELECT * FROM click_tracker WHERE URL=\"".$URL."\"";
	$result = mysql_query($query);
	$num = mysql_numrows($result);
	echo $num;
	if($num != 0)
	{
		$update_sql= "UPDATE click_tracker SET ClickCount = ClickCount + 1 WHERE URL=\"".$URL."\"";
		mysql_query($update_sql);
	}
	else
	{
		$insert_sql= "INSERT INTO click_tracker VALUES(\"".$ProfileName."\", 1, \"".$URL."\")"; 
				
				mysql_query($insert_sql);
	}
?>
