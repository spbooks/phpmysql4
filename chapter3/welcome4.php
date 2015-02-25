<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Form Example</title>
		<meta http-equiv="content-type"
				content="text/html; charset=utf-8"/>
	</head>
	<body>
		<p>
			<?php
			$firstname = $_GET['firstname'];
			$lastname = $_GET['lastname'];
			echo 'Welcome to our web site, ' .
					htmlspecialchars($firstname, ENT_QUOTES, 'UTF-8') . ' ' .
					htmlspecialchars($lastname, ENT_QUOTES, 'UTF-8') . '!';
			?>
		</p>
	</body>
</html>