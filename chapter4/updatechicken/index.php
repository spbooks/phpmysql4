<?php
$link = mysqli_connect('localhost', 'root', 'password');
if (!$link)
{
	$output = 'Unable to connect to the database server.';
	include 'output.html.php';
	exit();
}

if (!mysqli_set_charset($link, 'utf8'))
{
	$output = 'Unable to set database connection encoding.';
	include 'output.html.php';
	exit();
}

if (!mysqli_select_db($link, 'ijdb'))
{
	$output = 'Unable to locate the joke database.';
	include 'output.html.php';
	exit();
}

$sql = 'UPDATE joke SET jokedate="2010-04-01"
	WHERE joketext LIKE "%chicken%"';
if (!mysqli_query($link, $sql))
{
	$output = 'Error performing update: ' . mysqli_error($link);
	include 'output.html.php';
	exit();
}

$output = 'Updated ' . mysqli_affected_rows($link) . ' rows.';
include 'output.html.php';
?>
