<?php
	/*
	* Created By : Daniel Jamison
	*/
	
	// Start the Session
	session_start();
	require 'scripts/connectNEW.php';
	$errorMessage = "";
	
	$SQLStatement = "SELECT ProfileName AS 'Name', ClickCount AS 'Click Count', URL AS 'Twitter Profile URL' FROM click_tracker ORDER BY ClickCount DESC;";
	$report = mysql_query($SQLStatement);
	$_SESSION["save"] = $SQLStatement;
	$_SESSION["ReportName"] = $ReportName;
	$_SESSION["error"] = null;
	
	if($_POST['formSubmit'] == "Save") 
    {
		
		$errorMessage = "";
		$ReportName= htmlentities($_POST['ReportName'], ENT_QUOTES);
		$_SESSION["ReportName"] = $ReportName;
		
		if (empty($ReportName))
		{
			$errorMessage .= "Report name cannot be blank if you wish to save it.<br>";
		}
		else
		{
			require 'scripts/SaveReport.php';
		}
	}
	echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
?>

<html>
<head>
    <link href="css/phpMM.css" rel="stylesheet" type="text/css"/>
	<div id="header"><h1>Twitter Click Counter</h1></div>
</head>

<body>
   <div id="content">
		<?php
		    if(!empty($_SESSION["status"]) || !empty($errorMessage)) 
		    {
				echo '<span style="color:#F00;">' . "<ul>" . $_SESSION["status"] . "</ul>\n" . '</span>';
				echo '<span style="color:#F00;">' . "<ul>" . $errorMessage . "</ul>\n" . '</span>';
            }
        ?>
		<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
		<?php if(!empty($report)) :?>
		<p>Report Name (if saving for future use)</label> <br>
       <input type="text" name="ReportName" size="40" maxlength="40" value="<?php echo $ReportName;?>" />
	   <input type="submit" name="formSubmit" value="Save">
	   </form>
         <p><b></b></br>
		 <table border=1 rules="all">
			<?php
				$columns = mysql_num_fields($report);
				echo "<tr>";
				$temp = 0;
				while($temp < $columns)
				{
					echo "<td><b>".mysql_field_name($report, $temp)."</b></td>";
					$temp++;
				}
				echo "</tr>";
				while($row = mysql_fetch_row($report))
				{
					echo "<tr>";
					$temp = 0;
					while($temp < $columns)
					{
						echo "<td>".preg_replace('/((http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?)/', '<a href="\1">\1</a>', $row[$temp])."</td>";
						//echo "<td>".$row[$temp]."</td>";
						$temp++;
					}
					echo "</tr>";
				}
				//echo $report; 
			?>
		</table>
	   <?php endif; ?>
			
		</form>
		</div>

</body>
</html>