<?php
include_once $_SERVER['DOCUMENT_ROOT'] .
		'/includes/magicquotes.inc.php';

if (isset($_GET['add']))
{
	$pagetitle = 'New Category';
	$action = 'addform';
	$name = '';
	$id = '';
	$button = 'Add category';

	include 'form.html.php';
	exit();
}

if (isset($_GET['addform']))
{
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

	$name = mysqli_real_escape_string($link, $_POST['name']);
	$sql = "INSERT INTO category SET
			name='$name'";
	if (!mysqli_query($link, $sql))
	{
		$error = 'Error adding submitted category.';
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
	$sql = "SELECT id, name FROM category WHERE id='$id'";
	$result = mysqli_query($link, $sql);
	if (!$result)
	{
		$error = 'Error fetching category details.';
		include 'error.html.php';
		exit();
	}
	$row = mysqli_fetch_array($result);

	$pagetitle = 'Edit Category';
	$action = 'editform';
	$name = $row['name'];
	$id = $row['id'];
	$button = 'Update category';

	include 'form.html.php';
	exit();
}

if (isset($_GET['editform']))
{
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

	$id = mysqli_real_escape_string($link, $_POST['id']);
	$name = mysqli_real_escape_string($link, $_POST['name']);
	$sql = "UPDATE category SET
			name='$name'
			WHERE id='$id'";
	if (!mysqli_query($link, $sql))
	{
		$error = 'Error updating submitted category.' .
				mysqli_error($link);
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

	// Delete joke associations with this category
	$sql = "DELETE FROM jokecategory WHERE categoryid='$id'";
	if (!mysqli_query($link, $sql))
	{
		$error = 'Error removing jokes from category.';
		include 'error.html.php';
		exit();
	}

	// Delete the category
	$sql = "DELETE FROM category WHERE id='$id'";
	if (!mysqli_query($link, $sql))
	{
		$error = 'Error deleting category.';
		include 'error.html.php';
		exit();
	}

	header('Location: .');
	exit();
}

// Display category list
include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
$result = mysqli_query($link, 'SELECT id, name FROM category');
if (!$result)
{
	$error = 'Error fetching categories from database!';
	include 'error.html.php';
	exit();
}

while ($row = mysqli_fetch_array($result))
{
	$categories[] = array('id' => $row['id'], 'name' => $row['name']);
}

include 'categories.html.php';
?>
