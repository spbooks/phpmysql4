<?php
include_once $_SERVER['DOCUMENT_ROOT'] .
		'/includes/magicquotes.inc.php';

if (isset($_POST['action']) and $_POST['action'] == 'upload')
{
	// Bail out if the file isn't really an upload
	if (!is_uploaded_file($_FILES['upload']['tmp_name']))
	{
		$error = 'There was no file uploaded!';
		include $_SERVER['DOCUMENT_ROOT'] . '/includes/error.html.php';
		exit();
	}
	$uploadfile = $_FILES['upload']['tmp_name'];
	$uploadname = $_FILES['upload']['name'];
	$uploadtype = $_FILES['upload']['type'];
	$uploaddesc = $_POST['desc'];
	$uploaddata = file_get_contents($uploadfile);

	include 'db.inc.php';

	// Prepare user-submitted values for safe database insert
	$uploadname = mysqli_real_escape_string($link, $uploadname);
	$uploadtype = mysqli_real_escape_string($link, $uploadtype);
	$uploaddesc = mysqli_real_escape_string($link, $uploaddesc);
	$uploaddata = mysqli_real_escape_string($link, $uploaddata);

	$sql = "INSERT INTO filestore SET
			filename = '$uploadname',
			mimetype = '$uploadtype',
			description = '$uploaddesc',
			filedata = '$uploaddata'";
	if (!mysqli_query($link, $sql))
	{
		$error = 'Database error storing file!';
		include $_SERVER['DOCUMENT_ROOT'] . '/includes/error.html.php';
		exit();
	}

	header('Location: .');
	exit();
}

if (isset($_GET['action']) and
		($_GET['action'] == 'view' or $_GET['action'] == 'download') and
		isset($_GET['id']))
{
	include 'db.inc.php';

	$id = mysqli_real_escape_string($link, $_GET['id']);

	$sql = "SELECT filename, mimetype, filedata
			FROM filestore
			WHERE id = '$id'";
	$result = mysqli_query($link, $sql);
	if (!$result)
	{
		$error = 'Database error fetching requested file.';
		include $_SERVER['DOCUMENT_ROOT'] . '/includes/error.html.php';
		exit();
	}

	$file = mysqli_fetch_array($result);
	if (!$file)
	{
		$error = 'File with specified ID not found in the database!';
		include $_SERVER['DOCUMENT_ROOT'] . '/includes/error.html.php';
		exit();
	}

	$filename = $file['filename'];
	$mimetype = $file['mimetype'];
	$filedata = $file['filedata'];
	$disposition = 'inline';

	if ($_GET['action'] == 'download')
	{
		$mimetype = 'application/octet-stream';
		$disposition = 'attachment';
	}

	// Content-type must come before Content-disposition
	header("Content-type: $mimetype");
	header("Content-disposition: $disposition; filename=$filename");
	header('Content-length: ' . strlen($filedata));

	echo $filedata;
	exit();
}

if (isset($_POST['action']) and $_POST['action'] == 'delete' and
		isset($_POST['id']))
{
	include 'db.inc.php';

	$id = mysqli_real_escape_string($link, $_POST['id']);

	$sql = "DELETE FROM filestore
			WHERE id = '$id'";
	if (!mysqli_query($link, $sql))
	{
		$error = 'Database error deleting requested file.';
		include $_SERVER['DOCUMENT_ROOT'] . '/includes/error.html.php';
		exit();
	}

	header('Location: .');
	exit();
}

include 'db.inc.php';

$sql = 'SELECT id, filename, mimetype, description
		FROM filestore';
$result = mysqli_query($link, $sql);
if (!$result)
{
	$error = 'Database error fetching stored files.';
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/error.html.php';
	exit();
}

$files = array();
while ($row = mysqli_fetch_array($result))
{
	$files[] = array(
			'id' => $row['id'],
			'filename' => $row['filename'],
			'mimetype' => $row['mimetype'],
			'description' => $row['description']);
}

include 'files.html.php';
?>
