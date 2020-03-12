<?php
require_once("db.php");

$fd = fopen("hello.txt", 'w') or die("не удалось создать файл");

if (parse_url($_SERVER['HTTP_REFERER'])['path'] == "/registration" || '/'){
    $DB->addUser($_POST['login'], $_POST['name'], $_POST['password']);
}

fclose($fd);