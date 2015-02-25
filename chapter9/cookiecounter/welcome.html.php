<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Cookie counter</title>
		<meta http-equiv="content-type"
				content="text/html; charset=utf-8"/>
	</head>
	<body>
		<p>
			<?php
			if ($visits > 1)
			{
				echo "This is visit number $visits.";
			}
			else
			{
				// First visit
				echo 'Welcome to my web site! Click here for a tour!';
			}
			?>
		</p>
	</body>
</html>
