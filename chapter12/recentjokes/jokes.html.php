<?php include_once $_SERVER['DOCUMENT_ROOT'] .
		'/includes/helpers.inc.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Recent Jokes</title>
		<meta http-equiv="content-type"
				content="text/html; charset=utf-8"/>
	</head>
	<body>
		<p>Here are the most recent jokes in the database:</p>
		<?php foreach ($jokes as $joke): ?>
			<div>
				<?php bbcodeout($joke['text']); ?>
			</div>
		<?php endforeach; ?>
	</body>
</html>
