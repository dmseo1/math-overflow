<?php
	$hostname ="localhost";
	$user_name ="root";
	$password = "sdm9469";
	$db_name = "dongmin";
	$conn = mysql_connect($hostname, $user_name, $password);
	mysql_select_db($db_name);

	$qy = "select * from dmtable";
	$mssql_slt = mysql_query($qy, $conn);
	while($row=mysql_fetch_array($mssql_slt))
	{
		echo $row[0]."&nbsp;&nbsp;&nbsp;".$row[1]."<br>";
	}

?>
