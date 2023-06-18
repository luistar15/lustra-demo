<?php
use function htmlspecialchars as e;
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html>
<head>
	<base href="<?=e($config['site_base'])?>">
	<title><?=e($page_title)?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/kimeiga/bahunya/dist/bahunya.min.css">
</head>
<body>
	<?php require $page_tpl; ?>
</body>
</html>
