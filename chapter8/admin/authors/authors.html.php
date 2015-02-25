<?php include_once $_SERVER['DOCUMENT_ROOT'] .
		'/includes/helpers.inc.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Manage Authors</title>
		<meta http-equiv="content-type"
				content="text/html; charset=utf-8"/>
	</head>
	<body>
		<h1>Manage Authors</h1>
		<p><a href="?add">Add new author</a></p>
		<ul>
			<?php foreach ($authors as $author): ?>
				<li>
					<form action="" method="post">
						<div>
							<?php htmlout($author['name']); ?>
							<input type="hidden" name="id" value="<?php
									echo $author['id']; ?>"/>
							<input type="submit" name="action" value="Edit"/>
							<input type="submit" name="action" value="Delete"/>
						</div>
					</form>
				</li>
			<?php endforeach; ?>
		</ul>
		<p><a href="..">Return to JMS home</a></p>
	</body>
</html>
