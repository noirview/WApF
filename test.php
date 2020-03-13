<?php

session_start();

require("db.php");
require("cookie_session_db.php");

if (parse_url($_SERVER['HTTP_REFERER'])['path'] == "/registration") {
    $error_message = registration($_POST);
    
    $response = array(
        'error' => $error_message
    );

    echo json_encode($response);

} else if (parse_url($_SERVER['HTTP_REFERER'])['path'] == "/authorization") {
    $error_message = authorization($_POST);
    
    $response = array(
        'error' => $error_message
    );

    echo json_encode($response);
    
} else if (parse_url($_SERVER['HTTP_REFERER'])['path'] == "/user_page") {
    session_destroy();
    setcookie("hash", '', time());
    setcookie("id", '', time());
}

function registration($formData)
{
    if (
        !isset($formData['login']) &&
        !isset($formData['name']) &&
        !isset($formData['email']) &&
        !isset($formData['password']) &&
        !isset($formData['confirm_password'])
    ) {
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

    $sessionId = $DB->addUser($_POST['login'], $_POST['name'], $_POST['password'], $_POST['email']);
    $_SESSION['id'] = $sessionId;

    return '';
}

function authorization($formData)
{
    if (
        !isset($formData['login']) &&
        !isset($formData['password'])
    ) {

        return "Заполните пустые поля";
    }

    global $DB;

    if (!$DB->checkUser($formData['login'], $formData['password'])) {
        return 'Неверный логин или пароль';
    }

    $userId = $DB->getUserId($formData['login']);
    $name = $DB->getUserName($userId);
    $hash = (string)$DB->getAuthHash($userId);

    $_SESSION['name'] = (string)$name;
    $_SESSION['id'] = $hash;

    setcookie("id", $userId, time() + 60 * 60 * 24 * 30);
    setcookie("hash", $_SESSION['id'], time() + 60 * 60 * 24 * 30);

    return '';
}