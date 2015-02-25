<?php

function userIsLoggedIn()
{
	if (isset($_POST['action']) and $_POST['action'] == 'login')
	{
		if (!isset($_POST['email']) or $_POST['email'] == '' or
			!isset($_POST['password']) or $_POST['password'] == '')
		{
			$GLOBALS['loginError'] = 'Please fill in both fields';
			return FALSE;
		}

		$password = md5($_POST['password'] . 'ijdb');

		if (databaseContainsAuthor($_POST['email'], $password))
		{
			session_start();
			$_SESSION['loggedIn'] = TRUE;
			$_SESSION['email'] = $_POST['email'];
			$_SESSION['password'] = $password;
			return TRUE;
		}
		else
		{
			session_start();
			unset($_SESSION['loggedIn']);
			unset($_SESSION['email']);
			unset($_SESSION['password']);
			$GLOBALS['loginError'] =
					'The specified email address or password was incorrect.';
			return FALSE;
		}
	}

	if (isset($_POST['action']) and $_POST['action'] == 'logout')
	{
		session_start();
		unset($_SESSION['loggedIn']);
		unset($_SESSION['email']);
		unset($_SESSION['password']);
		header('Location: ' . $_POST['goto']);
		exit();
	}

	session_start();
	if (isset($_SESSION['loggedIn']))
	{
		return databaseContainsAuthor($_SESSION['email'], $_SESSION['password']);
	}
}

function databaseContainsAuthor($email, $password)
{
	include 'db.inc.php';

	$email = mysqli_real_escape_string($link, $email);
	$password = mysqli_real_escape_string($link, $password);

	$sql = "SELECT COUNT(*) FROM author
			WHERE email='$email' AND password='$password'";
	$result = mysqli_query($link, $sql);
	if (!$result)
	{
		$error = 'Error searching for author.';
		include 'error.html.php';
		exit();
	}
	$row = mysqli_fetch_array($result);

	if ($row[0] > 0)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}

function userHasRole($role)
{
	include 'db.inc.php';

	$email = mysqli_real_escape_string($link, $_SESSION['email']);
	$role = mysqli_real_escape_string($link, $role);

	$sql = "SELECT COUNT(*) FROM author
			INNER JOIN authorrole ON author.id = authorid
			INNER JOIN role ON roleid = role.id
			WHERE email = '$email' AND role.id='$role'";
	$result = mysqli_query($link, $sql);
	if (!$result)
	{
		$error = 'Error searching for author roles.';
		include 'error.html.php';
		exit();
	}
	$row = mysqli_fetch_array($result);

	if ($row[0] > 0)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}

?>
