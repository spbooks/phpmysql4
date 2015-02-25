<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

function totaljokes()
{
	global $link;

	$result = mysqli_query($link, 'SELECT COUNT(*) FROM joke');
	if (!$result)
	{
		$error = 'Database error counting jokes!';
		include 'error.html.php';
		exit();
	}

	$row = mysqli_fetch_array($result);

	return $row[0];
}
?>
