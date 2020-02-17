<!DOCTYPE html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MySql-PHP Connect Test</title>
</head>

<body>


<?php
echo "MySQL conn test<br>";

$db =mysqli_connect("localhost", "root", "sdm9469", "dongmin");

if(!mysqli_connect_errno($db))
{
	echo "connect : success!!!!!!!<br>";
}
else
{
	echo "disconnect : fail......<br>" . mysqli_connect_error();
}

$result = mysqli_query($db, 'SELECT VERSION() as VERSION');
$data = mysqli_fetch_assoc($result);
echo $data['VERSION'];

?>



</body>
</html>
