<?php
class DB
{
    var $db;

    static $userId = 1;

    function addUser($login, $name, $password, $email)
    {
        $userId = self::$userId;

        $usersTable = $this->db->Users;
        $newUser = $usersTable->addChild('User');

        $newUser->addChild('id', $userId);
        $newUser->addChild('name', $name);
        $newUser->addChild('email', $email);
        $newUser->addChild('login', $login);
        $newUser->addChild('password', $password);

        $hash = md5($login . $email . $name);

        $this->addAuthData($userId, $hash);
        $this->db->asXML('DataBase.xml');

        self::$userId++;

        return $hash;
    }

    function addAuthData($userId, $hash) {
        $authTable = $this->db->AuthTable;
        $newAuthData = $authTable->addChild('AuthData');
        
        $newAuthData->addChild('cookie_hash', $hash);
        $newAuthData->addChild('user_id', $userId);
    }

    function getAuthHash($userId) {
        foreach ($this->db->AuthTable->children() as $AuthData) {
            if ((int)$AuthData->user_id != (int)$userId) { continue; } 
            
            return $AuthData->cookie_hash;
        }
    }

    function checkUser($login, $password)
    {
        foreach ($this->db->Users->children() as $User) {
            if ($User->login != $login) { continue; } 
            
            if ($User->password != $password) { return false; }
            else { return true; }
        }

        return false;
    }

    function checkUnique($nameTable, $nameField, $value)
    {
        foreach ($this->db->{$nameTable}->children() as $element) {
            if ($element->{$nameField} == $value) {
                return false;
            }
        }

        return True;
    }

    function getUserId($login) {
        foreach ($this->db->Users->children() as $User) {
            if ($User->login != $login) { continue; } 
            
            return $User->id;
        }
    }

    function getUserName($id) {
        foreach ($this->db->Users->children() as $User) {
            if ($User->id != $id) { continue; } 
            
            return $User->name;
        }
    }

    function DB()
    {
        if (file_exists('DataBase.xml')) {
            $this->db = simplexml_load_file('DataBase.xml');
        } else {
            $this->db = simplexml_load_string(
                '<?xml version="1.0" encoding="UTF-8"?><DataBase><Users></Users><AuthTable></AuthTable></DataBase>'
            );
        }

        self::$userId = count($this->db->Users->children());
    }
}

$DB = new DB();
