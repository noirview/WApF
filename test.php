<?php
$fd = fopen("hello.txt", 'w') or die("не удалось создать файл");

fwrite($fd, $_POST['login'] . "\n");
fwrite($fd, $_POST['password'] . "\n");

if (parse_url($_SERVER['HTTP_REFERER'])['path'] == "/registration"){
    fwrite($fd, $_POST['confirm_password'] . "\n");
    fwrite($fd, $_POST['name'] . "\n");
    fwrite($fd, $_POST['email'] . "\n");
}

fclose($fd);