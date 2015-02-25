<?php include_once $_SERVER['DOCUMENT_ROOT'] .
		'/includes/helpers.inc.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Manage Jokes: Search Results</title>
		<meta http-equiv="content-type"
				content="text/html; charset=utf-8"/>
	</head>
	<body>
		<h1>Search Results</h1>
		<?php if (isset($jokes)): ?>
			<table>
				<tr><th>Joke Text</th><th>Options</th></tr>
				<?php foreach ($jokes as $joke): ?>
				<tr valign="top">
					<td><?php htmlout($joke['text']); ?></td>
					<td>
						<form action="?" method="post">
							<div>
								<input type="hidden" name="id" value="<?php
										htmlout($joke['id']); ?>"/>
								<input type="submit" name="action" value="Edit"/>
								<input type="submit" name="action" value="Delete"/>
							</div>
						</form>
					</td>
				</tr>
				<?php endforeach; ?>
			</table>
		<?php endif; ?>
		<p><a href="?">New search</a></p>
		<p><a href="..">Return to JMS home</a></p>
	</body>
</html>
