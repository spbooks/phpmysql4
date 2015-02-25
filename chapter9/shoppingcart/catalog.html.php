<?php include_once $_SERVER['DOCUMENT_ROOT'] .
		'/includes/helpers.inc.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Product catalog</title>
		<meta http-equiv="content-type"
				content="text/html; charset=utf-8" />
		<style type="text/css">
		table {
			border-collapse: collapse;
		}
		td, th {
			border: 1px solid black;
		}
		</style>
	</head>
	<body>
		<p>Your shopping cart contains <?php
				echo count($_SESSION['cart']); ?> items.</p>
		<p><a href="?cart">View your cart</a></p>
		<table border="1">
			<thead>
				<tr>
					<th>Item Description</th>
					<th>Price</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($items as $item): ?>
					<tr>
						<td><?php htmlout($item['desc']); ?></td>
						<td>
							$<?php echo number_format($item['price'], 2); ?>
						</td>
						<td>
							<form action="" method="post">
								<div>
									<input type="hidden" name="id" value="<?php
											htmlout($item['id']); ?>"/>
									<input type="submit" name="action" value="Buy"/>
								</div>
							</form>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<p>All prices are in imaginary dollars.</p>
	</body>
</html>