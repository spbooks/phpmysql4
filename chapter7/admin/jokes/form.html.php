<?php include_once $_SERVER['DOCUMENT_ROOT'] .
		'/includes/helpers.inc.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title><?php htmlout($pagetitle); ?></title>
		<meta http-equiv="content-type"
				content="text/html; charset=utf-8"/>
		<style type="text/css">
		textarea {
			display: block;
			width: 100%;
		}
		</style>
	</head>
	<body>
		<h1><?php htmlout($pagetitle); ?></h1>
		<form action="?<?php htmlout($action); ?>" method="post">
			<div>
				<label for="text">Type your joke here:</label>
				<textarea id="text" name="text" rows="3" cols="40"><?php
						htmlout($text); ?></textarea>
			</div>
			<div>
				<label for="author">Author:</label>
				<select name="author" id="author">
					<option value="">Select one</option>
					<?php foreach ($authors as $author): ?>
						<option value="<?php htmlout($author['id']); ?>"<?php
								if ($author['id'] == $authorid)
									echo ' selected="selected"';
								?>><?php htmlout($author['name']); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<fieldset>
				<legend>Categories:</legend>
				<?php foreach ($categories as $category): ?>
					<div><label for="category<?php htmlout($category['id']);
							?>"><input type="checkbox" name="categories[]"
							id="category<?php htmlout($category['id']); ?>"
							value="<?php htmlout($category['id']); ?>"<?php
							if ($category['selected'])
							{
								echo ' checked="checked"';
							}
							?>/><?php htmlout($category['name']); ?></label></div>
				<?php endforeach; ?>
			</fieldset>
			<div>
				<input type="hidden" name="id" value="<?php
						htmlout($id); ?>"/>
				<input type="submit" value="<?php htmlout($button); ?>"/>
			</div>
		</form>
	</body>
</html>
