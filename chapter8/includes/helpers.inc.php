<?php
function html($text)
{
	return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function htmlout($text)
{
	echo html($text);
}

function bbcode2html($text)
{
	$text = html($text);

	// [B]old
	$text = preg_replace('/\[B](.+?)\[\/B]/i',
			'<strong>$1</strong>', $text);

	// [I]talic
	$text = preg_replace('/\[I](.+?)\[\/I]/i', '<em>$1</em>', $text);

	// Convert Windows (\r\n) to Unix (\n)
	$text = str_replace("\r\n", "\n", $text);
	// Convert Macintosh (\r) to Unix (\n)
	$text = str_replace("\r", "\n", $text);

	// Paragraphs
	$text = '<p>' . str_replace("\n\n", '</p><p>', $text) . '</p>';
	// Line breaks
	$text = str_replace("\n", '<br/>', $text);

	// [URL]link[/URL]
	$text = preg_replace(
			'/\[URL]([-a-z0-9._~:\/?#@!$&\'()*+,;=%]+)\[\/URL]/i',
			'<a href="$1">$1</a>', $text);

	// [URL=url]link[/URL]
	$text = preg_replace(
			'/\[URL=([-a-z0-9._~:\/?#@!$&\'()*+,;=%]+)](.+?)\[\/URL]/i',
			'<a href="$1">$2</a>', $text);

	return $text;
}

function bbcodeout($text)
{
	echo bbcode2html($text);
}

?>
