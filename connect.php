<?php
define('DB_NAME', 'u0605727_test');
define('DB_USER', 'u0605_test');
define('DB_PASSWORD', 'u0605_test');
define('DB_HOST', 'localhost');

$pdo = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME."; charset=utf8mb4;", DB_USER, DB_PASSWORD);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

//$pdo->set_charset("utf8mb4");




//$img = file_get_contents($_FILES["foto"]["tmp_name"]); //Превратим файл в строку
//$img = mysql_escape_string($img); //Без этой функции не работает
//$q = "INSERT INTO `".$baz."`.`photo` (`id`, `name`, `con`) VALUES (NULL, '".$nam."', '".$img."');";
//mysql_query($q);