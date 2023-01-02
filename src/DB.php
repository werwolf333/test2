<?php

namespace Werwolf\Test2;

class DB
{
    public function getAll(): ?array
    {
        return json_decode(file_get_contents(dirname(__DIR__) . '/db.json'), true);
    }
    public function addRow(string $login, string $password, string $email, string $name): bool
    {
        if ($this->getRow($login) != null) {
            return false;
        }
        $db = json_decode(file_get_contents(dirname(__DIR__) . '/db.json'), true);
        $arrayRow = array(
            'login' => $login,
            'password' => md5($password),
            'email' => $email,
            'name' => $name
        );
        if ($db == '') {
            $db[0] = $arrayRow;
        } else {
            $db[count($db)] = $arrayRow;
        }
        file_put_contents(dirname(__DIR__) . '/db.json', json_encode($db));
        return true;
    }
    public function getRow(string $login): ?array
    {
        $db = json_decode(file_get_contents(dirname(__DIR__) . '/db.json'), true);
        foreach ($db as $row) {
            if ($row['login'] == $login) {
                return $row;
            }
        }
        return null;
    }
    public function editRow(string $login, string $newLogin, string $password, string $email, string $name): bool
    {
        if ($this->getRow($newLogin) == null) {
            return false;
        }
        $db = json_decode(file_get_contents(dirname(__DIR__) . '/db.json'), true);
        foreach ($db as $row) {
            if ($row['login'] == $login) {
                $row['login'] = $newLogin;
                $row['password'] = md5($password);
                $row['email'] = $email;
                $row['name'] = $name;
            }
        }
        file_put_contents(dirname(__DIR__) . '/db.json', json_encode($db));
        return true;
    }
    public function deleteRow(string $login): bool
    {
        if ($this->getRow($login) == null) {
            return false;
        }
        $db = json_decode(file_get_contents(dirname(__DIR__) . '/db.json'), true);
        foreach ($db as $key => $row) {
            if ($row['login'] == $login) {
                unset($db[$key]);
            }
        }
        file_put_contents(dirname(__DIR__) . '/db.json', json_encode($db));
        return true;
    }
}
