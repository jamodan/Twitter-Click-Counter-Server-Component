<?php
	require 'connectNEW.php';
	$csv_terminated = "\n";
	$csv_separator = ",";
	$csv_enclosed = '"';
	$csv_escaped = "\\";
	$sql_query = "select * from $table";
	// Gets the data from the database
	$result = mysql_query($_SESSION["save"]);
	$fields_cnt = mysql_num_fields($result);
	$schema_insert = '';
	for ($i = 0; $i < $fields_cnt; $i++)
	{
		$l = $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed,
		stripslashes(mysql_field_name($result, $i))) . $csv_enclosed;
		$schema_insert .= $l;
		$schema_insert .= $csv_separator;
	}
	$out = trim(substr($schema_insert, 0, -1));
	$out .= $csv_terminated;
	// Format the data
	while ($row = mysql_fetch_array($result))
	{
		$schema_insert = '';
		for ($j = 0; $j < $fields_cnt; $j++)
		{
			if ($row[$j] == '0' || $row[$j] != '')
			{
				if ($csv_enclosed == '')
				{
					$schema_insert .= $row[$j];
				} 
				else
				{
					$schema_insert .= $csv_enclosed .
					str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $row[$j]) . $csv_enclosed;
				}
			} 
			else
			{
				$schema_insert .= '';
			}
			if ($j < $fields_cnt - 1)
			{
				$schema_insert .= $csv_separator;
			}
		} 
		$out .= $schema_insert;
		$out .= $csv_terminated;
	} 
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Length: " . strlen($out));
	header("Content-type: text/csv");
	$ReportName = $_SESSION["ReportName"].".csv";
	header("Content-Disposition: attachment; filename=\"".$ReportName."\"");
	echo $out;
    ?>