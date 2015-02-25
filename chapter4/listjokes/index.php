<?php
$link = mysqli_connect('localhost', 'root', 'password');
if (!$link)
{
	$error = 'Unable to connect to the database server.';
	include 'error.html.php';
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
	$error = 'Unable to locate the joke database.';
	include 'error.html.php';
	exit();
}

$result = mysqli_query($link, 'SELECT joketext FROM joke');
if (!$result)
{
	$error = 'Error fetching jokes: ' . mysqli_error($link);
	include 'error.html.php';
	exit();
}

while ($row = mysqli_fetch_array($result))
{
	$jokes[] = $row['joketext'];
}

include 'jokes.html.php';
?>