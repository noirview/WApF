<?php
require("db.php");

if (parse_url($_SERVER['HTTP_REFERER'])['path'] == "/registration" || '/') {
    $response = array(
        'error' => registration($_POST)
    );

    echo json_encode($response);
}

function registration($formData)
{
    if (!isset($formData['login']) &&
        !isset($formData['name']) &&
        !isset($formData['email']) &&
        !isset($formData['password']) &&
        !isset($formData['confirm_password'])) {
        
        return "Заполните пустые поля";
    }

    if ($formData['password'] != $formData['confirm_password']) {
        return "Не совпадают пароли";
    }

    global $DB;

    if (!$DB->checkUnique('Users', 'login', $formData['login'])) {
        return "Выберите другой логин";
    }

    if (!$DB->checkUnique('Users', 'email', $formData['email'])) {
        return "Данный email уже используется";
    }

    $DB->addUser($_POST['login'], $_POST['name'], $_POST['password'], $_POST['email']);

    return '';
}
