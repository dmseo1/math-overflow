<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


$link=mysqli_connect("localhost", "root", "sdm9469", "dongmin");

if(!$link)
{
	echo "MySQL Connection Error! : ";
	echo mysqli_connect_error();
	exit();
}

mysqli_set_charset($link, "utf8");

$name=isset($_POST['name']) ? $_POST['name'] : '';
$address=isset($_POST['address']) ? $_POST['address'] : '';

if($name != "" and $address !="")
{
	$sql="insert into Person(name,address) values('$name','$address')";
	$result=mysqli_query($link, $sql);

	if($result)
	{
		echo "SQL processing SUCCESS";
	}
	else
	{
		echo "Error in processing SQL...: ";
		echo mysqli_error($link);
	}
}
else
{
	echo "Please insert Data";
}


mysqli_close($link);
?>


<html>
<body>

<form action="<?php $_PHP_SELF ?>" method="POST">
	Name: <input type="text" name="name" />
	Address: <input type="text" name="address" />
	<input type="submit" />

</form>

</body>
</html>
