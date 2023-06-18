<?php
use function htmlspecialchars as e;
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html>
<head>
	<title><?=$http_status?> <?=e($message)?></title>
	<style>html { font-family: "Segoe UI", Roboto, sans-serif; }</style>
</head>
<body>
	<h1><?=$http_status?> <?=e($message)?></h1>
	<hr>
	<p><?=e($error_message)?></p>
	<p><a href="/">Go to home page</a></p>
</body>
</html>
