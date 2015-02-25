<?php
include_once $_SERVER['DOCUMENT_ROOT'] .
		'/includes/magicquotes.inc.php';

if (isset($_GET['add']))
{
	$pagetitle = 'New Author';
	$action = 'addform';
	$name = '';
	$email = '';
	$id = '';
	$button = 'Add author';

	include 'form.html.php';
	exit();
}

if (isset($_GET['addform']))
{
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

	$name = mysqli_real_escape_string($link, $_POST['name']);
	$email = mysqli_real_escape_string($link, $_POST['email']);
	$sql = "INSERT INTO author SET
			name='$name',
			email='$email'";
	if (!mysqli_query($link, $sql))
	{
		$error = 'Error adding submitted author.';
		include 'error.html.php';
		exit();
	}

	header('Location: .');
	exit();
}

if (isset($_POST['action']) and $_POST['action'] == 'Edit')
{
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

	$id = mysqli_real_escape_string($link, $_POST['id']);
	$sql = "SELECT id, name, email FROM author WHERE id='$id'";
	$result = mysqli_query($link, $sql);
	if (!$result)
	{
		$error = 'Error fetching author details.';
		include 'error.html.php';
		exit();
	}
	$row = mysqli_fetch_array($result);

	$pagetitle = 'Edit Author';
	$action = 'editform';
	$name = $row['name'];
	$email = $row['email'];
	$id = $row['id'];
	$button = 'Update author';

	include 'form.html.php';
	exit();
}

if (isset($_GET['editform']))
{
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

	$id = mysqli_real_escape_string($link, $_POST['id']);
	$name = mysqli_real_escape_string($link, $_POST['name']);
	$email = mysqli_real_escape_string($link, $_POST['email']);
	$sql = "UPDATE author SET
			name='$name',
			email='$email'
			WHERE id='$id'";
	if (!mysqli_query($link, $sql))
	{
		$error = 'Error updating submitted author.';
		include 'error.html.php';
		exit();
	}

	header('Location: .');
	exit();
}

if (isset($_POST['action']) and $_POST['action'] == 'Delete')
{
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
	$id = mysqli_real_escape_string($link, $_POST['id']);

	// Get jokes belonging to author
	$sql = "SELECT id FROM joke WHERE authorid='$id'";
	$result = mysqli_query($link, $sql);
	if (!$result)
	{
		$error = 'Error getting list of jokes to delete.';
		include 'error.html.php';
		exit();
	}

	// For each joke
	while ($row = mysqli_fetch_array($result))
	{
		$jokeId = $row[0];

		// Delete joke category entries
		$sql = "DELETE FROM jokecategory WHERE jokeid='$jokeId'";
		if (!mysqli_query($link, $sql))
		{
			$error = 'Error deleting category entries for joke.';
			include 'error.html.php';
			exit();
		}
	}

	// Delete jokes belonging to author
	$sql = "DELETE FROM joke WHERE authorid='$id'";
	if (!mysqli_query($link, $sql))
	{
		$error = 'Error deleting jokes for author.';
		include 'error.html.php';
		exit();
	}

	// Delete the author
	$sql = "DELETE FROM author WHERE id='$id'";
	if (!mysqli_query($link, $sql))
	{
		$error = 'Error deleting author.';
		include 'error.html.php';
		exit();
	}

	header('Location: .');
	exit();
}

// Display author list
include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
$result = mysqli_query($link, 'SELECT id, name FROM author');
if (!$result)
{
	$error = 'Error fetching authors from database!';
	include 'error.html.php';
	exit();
}

while ($row = mysqli_fetch_array($result))
{
	$authors[] = array('id' => $row['id'], 'name' => $row['name']);
}

include 'authors.html.php';
?>
