<?php include_once $_SERVER['DOCUMENT_ROOT'] .
		'/includes/helpers.inc.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Manage Jokes</title>
		<meta http-equiv="content-type"
				content="text/html; charset=utf-8"/>
	</head>
	<body>
		<h1>Manage Jokes</h1>
		<p><a href="?add">Add new joke</a></p>
		<form action="" method="get">
			<p>View jokes satisfying the following criteria:</p>
			<div>
				<label for="author">By author:</label>
				<select name="author" id="author">
					<option value="">Any author</option>
					<?php foreach ($authors as $author): ?>
						<option value="<?php htmlout($author['id']); ?>"><?php
								htmlout($author['name']); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div>
				<label for="category">By category:</label>
				<select name="category" id="category">
					<option value="">Any category</option>
					<?php foreach ($categories as $category): ?>
						<option value="<?php htmlout($category['id']); ?>"><?php
								htmlout($category['name']); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div>
				<label for="text">Containing text:</label>
				<input type="text" name="text" id="text"/>
			</div>
			<div>
				<input type="hidden" name="action" value="search"/>
				<input type="submit" value="Search"/>
			</div>
		</form>
		<p><a href="..">Return to JMS home</a></p>
	</body>
</html>
