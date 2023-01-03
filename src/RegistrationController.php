<?php

namespace Werwolf\Test2;

use Werwolf\Test2\Http\Controller;
use Werwolf\Test2\Http\Request;
use Werwolf\Test2\Http\Response;

class RegistrationController extends Controller
{
    public function get(Request $request): Response
    {
        session_start();
        if(!empty($_SESSION['user_login'])){
            return $this->redirect('/');
        }
        return $this->render('registration.html.twig');
    }

    public function post(Request $request): Response
    {
        $errors = array();

        $errors["user_login"] = '';
        $errors["errors"] = false;
        if (empty($_POST["user_login"])) {
            $errors["user_login"] = $errors["user_login"] . "login is blank; ";
            $errors["errors"] = true;
        }
        if (preg_match('/\s/', $_POST["user_login"])) {
            $errors["user_login"] = $errors["user_login"] . "you can't use a space; ";
            $errors["errors"] = true;
        }
        if (!preg_match('/\w{6,}/', $_POST["user_login"])) {
            $errors["user_login"] = $errors["user_login"] . "minimum 6 symbols in login; ";
            $errors["errors"] = true;
        }
        $errors["user_password"] = '';
        if (empty($_POST["user_password"])) {
            $errors["user_password"] = $errors["user_password"] . "password is blank; ";
            $errors["errors"] = true;
        }
        if (preg_match('/\[|\]|\\|\^|\$|\.|\||\?|\*|\+|\(|\)/',$_POST["user_password"])) {
            $errors["user_password"] = $errors["user_password"] . "special characters cannot be used [ ] \ ^ $ . | ? * + ( ); ";
            $errors["errors"] = true;
        }
        if (preg_match('/\s/', $_POST["user_password"])) {
            $errors["user_password"] = $errors["user_password"] . "you can't use a space; ";
            $errors["errors"] = true;
        }
        if (!preg_match('/\w{6,}/', $_POST["user_password"])) {
            $errors["user_password"] = $errors["user_password"] . "minimum 6 symbols in password; ";
            $errors["errors"] = true;
        }
        if (!preg_match('/[0-9]/', $_POST["user_password"]) || !preg_match('/[a-zA-Z]/', $_POST["user_password"])) {
            $errors["user_password"] = $errors["user_password"] . "must be numbers and letters in password; ";
            $errors["errors"] = true;
        }
        $errors["user_password_repeat"] = '';
        if (empty($_POST["user_password_repeat"])) {
            $errors["user_password_repeat"] = $errors["user_password_repeat"] . "password_repeat is blank; ";
            $errors["errors"] = true;
        }
        if ($_POST["user_password_repeat"] != $_POST["user_password"]) {
            $errors["user_password_repeat"] = $errors["user_password_repeat"] . "password and password_repeat does not match; ";
            $errors["errors"] = true;
        }
        $errors["user_email"] = '';
        if (empty($_POST["user_email"])) {
            $errors["user_email"] = $errors["user_email"] . "email is blank; ";
            $errors["errors"] = true;
        }
        if (!filter_var($_POST["user_email"], FILTER_VALIDATE_EMAIL)) {
            $errors["user_email"] = $errors["user_email"] . "invalid email; ";
            $errors["errors"] = true;
        }
        $errors["user_name"] = '';
        if (empty($_POST["user_name"])) {
            $errors["user_name"] = $errors["user_name"] . "name is blank; ";
            $errors["errors"] = true;
        }
        if (!preg_match('/[a-zA-Z]{2,}/', $_POST["user_name"], $matches)) {
            $errors["user_name"] = $errors["user_name"] . "minimum 2 letters in name; ";
            $errors["errors"] = true;
        }
        if (preg_match('/\s/', $_POST["user_name"])) {
            $errors["user_name"] = $errors["user_name"] . "you can't use a space; ";
            $errors["errors"] = true;
        }
        $db = new DB();
        $rows = $db->getAll();
        if ($rows != '') {
            foreach ($rows as $row) {
                if ($row["login"] == $_POST["user_login"]) {
                    $errors["user_login"] = 'this login is busy; ';
                    $errors["errors"] = true;
                }
                if ($row["email"] == $_POST["user_email"]) {
                    $errors["user_email"] = 'this mail is busy; ';
                    $errors["errors"] = true;
                }
            }
        }
        if($errors["errors"] == false){
            $db->addRow($_POST["user_login"], $_POST["user_password"], $_POST["user_email"], $_POST["user_name"]);
        }
        
        return $this->json($errors);
    }
}
