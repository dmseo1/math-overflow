<?php

$host="localhost"
$user="root"
$password="sdm9469"

$conn=mysql_connect($host, $user, $password);
mysql_select_db("dongmin", $conn);

$sql="insert into dmtable values(10, 'dongmin')";
mysql_query($sql, $conn);

$sql="insert into dmtable values(20, 'hihi')";
mysql_query($sql, $conn);

?>

<script>
alert("success! Check your MySQL");
</script>
