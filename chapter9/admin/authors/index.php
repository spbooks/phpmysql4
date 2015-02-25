<?php
include_once $_SERVER['DOCUMENT_ROOT'] .
		'/includes/magicquotes.inc.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/access.inc.php';

if (!userIsLoggedIn())
{
	include '../login.html.php';
	exit();
}

if (!userHasRole('Account Administrator'))
{
	$error = 'Only Account Administrators may access this page.';
	include '../accessdenied.html.php';
	exit();
}

if (isset($_GET['add']))
{
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

	$pagetitle = 'New Author';
	$action = 'addform';
	$name = '';
	$email = '';
	$id = '';
	$button = 'Add author';

	// Build the list of roles
	$sql = "SELECT id, description FROM role";
	$result = mysqli_query($link, $sql);
	if (!$result)
	{
		$error = 'Error fetching list of roles.';
		include 'error.html.php';
		exit();
	}

	while ($row = mysqli_fetch_array($result))
	{
		$roles[] = array(
				'id' => $row['id'],
				'description' => $row['description'],
				'selected' => FALSE);
	}

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

	$authorid = mysqli_insert_id($link);

	if ($_POST['password'] != '')
	{
		$password = md5($_POST['password'] . 'ijdb');
		$password = mysqli_real_escape_string($link, $password);
		$sql = "UPDATE author SET
				password = '$password'
				WHERE id = '$authorid'";
		if (!mysqli_query($link, $sql))
		{
			$error = 'Error setting author password.';
			include 'error.html.php';
			exit();
		}
	}

	if (isset($_POST['roles']))
	{
		foreach ($_POST['roles'] as $role)
		{
			$roleid = mysqli_real_escape_string($link, $role);
			$sql = "INSERT INTO authorrole SET
					authorid='$authorid',
					roleid='$roleid'";
			if (!mysqli_query($link, $sql))
			{
				$error = 'Error assigning selected role to author.';
				include 'error.html.php';
				exit();
			}
		}
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

	// Get list of roles assigned to this author
	$sql = "SELECT roleid FROM authorrole WHERE authorid='$id'";
	$result = mysqli_query($link, $sql);
	if (!$result)
	{
		$error = 'Error fetching list of assigned roles.';
		include 'error.html.php';
		exit();
	}

	$selectedRoles = array();
	while ($row = mysqli_fetch_array($result))
	{
		$selectedRoles[] = $row['roleid'];
	}

	// Build the list of all roles
	$sql = "SELECT id, description FROM role";
	$result = mysqli_query($link, $sql);
	if (!$result)
	{
		$error = 'Error fetching list of roles.';
		include 'error.html.php';
		exit();
	}

	while ($row = mysqli_fetch_array($result))
	{
		$roles[] = array(
				'id' => $row['id'],
				'description' => $row['description'],
				'selected' => in_array($row['id'], $selectedRoles));
	}

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

	if ($_POST['password'] != '')
	{
		$password = md5($_POST['password'] . 'ijdb');
		$password = mysqli_real_escape_string($link, $password);
		$sql = "UPDATE author SET
				password = '$password'
				WHERE id = '$id'";
		if (!mysqli_query($link, $sql))
		{
			$error = 'Error setting author password.';
			include 'error.html.php';
			exit();
		}
	}

	$sql = "DELETE FROM authorrole WHERE authorid='$id'";
	if (!mysqli_query($link, $sql))
	{
		$error = 'Error removing obsolete author role entries.';
		include 'error.html.php';
		exit();
	}

	if (isset($_POST['roles']))
	{
		foreach ($_POST['roles'] as $role)
		{
			$roleid = mysqli_real_escape_string($link, $role);
			$sql = "INSERT INTO authorrole SET
					authorid='$id',
					roleid='$roleid'";
			if (!mysqli_query($link, $sql))
			{
				$error = 'Error assigning selected role to author.';
				include 'error.html.php';
				exit();
			}
		}
	}

	header('Location: .');
	exit();
}

if (isset($_POST['action']) and $_POST['action'] == 'Delete')
{
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
	$id = mysqli_real_escape_string($link, $_POST['id']);

	// Delete role assignments for this author
	$sql = "DELETE FROM authorrole WHERE authorid='$id'";
	if (!mysqli_query($link, $sql))
	{
		$error = 'Error removing author from roles.';
		include 'error.html.php';
		exit();
	}

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
