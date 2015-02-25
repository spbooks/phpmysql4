<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

$result = mysqli_query($link,
		'SELECT id, joketext FROM joke
		ORDER BY jokedate DESC
		LIMIT 3');
if (!$result)
{
	$error = 'Error fetching jokes: ' . mysqli_error($link);
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/error.html.php';
	exit();
}

while ($row = mysqli_fetch_array($result))
{
	$jokes[] = array('text' => $row['joketext']);
}

include 'jokes.html.php';

?>
