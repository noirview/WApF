<?php
class DB
{
    var $db;

    function addUser($login, $name, $password, $email)
    {
        $usersTable = $this->db->Users;
        $newUser = $usersTable->addChild('User');

        $newUser->addChild('name', $name);
        $newUser->addChild('email', $email);
        $newUser->addChild('login', $login);
        $newUser->addChild('password', $password);

        $this->db->asXML('DataBase.xml');
    }

    function checkUnique($nameTable, $nameField, $value)
    {
        foreach ($this->db->{$nameTable}->children() as $element) {
            if ($element->{$nameField} == $value) { return false; }
        }

        return True;
    }

    function DB()
    {
        if (file_exists('DataBase.xml')) {
            $this->db = simplexml_load_file('DataBase.xml');
        } else {
            $this->db = simplexml_load_string(
                '<?xml version="1.0" encoding="UTF-8"?>
                    <DataBase></DataBase>'
            );

            $dataBase = $this->db;
            $dataBase->addChild('Users');
            $dataBase->addChild('Cockies');
        }
    }
}

$DB = new DB();
