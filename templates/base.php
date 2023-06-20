<?php
use function htmlspecialchars as e;
header( 'Content-Type: text/html; charset=UTF-8', true );
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<base href="<?=$config->get( 'site_base' )?>">
	<title><?=e($page_title)?></title>
	<?=$page->buildHead()?>
</head>
<body>
	<?php require $page_tpl; ?>
	<?=$page->buildBody()?>
</body>
</html>
