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

$sql = 'CREATE TABLE joke (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			joketext TEXT,
			jokedate DATE NOT NULL
		) DEFAULT CHARACTER SET utf8';
if (!mysqli_query($link, $sql))
{
	$output = 'Error creating joke table: ' . mysqli_error($link);
	include 'output.html.php';
	exit();
}

$output = 'Joke table successfully created.';
include 'output.html.php';
?>
