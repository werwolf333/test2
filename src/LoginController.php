<?php

namespace Werwolf\Test2;

use Werwolf\Test2\Http\Controller;
use Werwolf\Test2\Http\Request;
use Werwolf\Test2\Http\Response;

class LoginController extends Controller
{
    public function get(Request $request): Response
    {
        session_start();
        if (!empty($_SESSION['user_login'])) {
            return $this->redirect('/index');
        }

        return $this->render('login.html.twig');
    }

    public function post(Request $request): Response
    {
        $errors = array();

        $errors["errors"] = false;

        $errors["user_login"] = '';
        if (empty($_POST["user_login"])) {
            $errors["user_login"] = $errors["user_login"] . "login is blank; ";
            $errors["errors"] = true;
        }

        $errors["user_password"] = '';
        if (empty($_POST["user_password"])) {
            $errors["user_password"] = $errors["user_password"] . "password is blank; ";
            $errors["errors"] = true;
        }

        if (empty($errors["user_login"])) {
            $db = new DB();
            $db = $db->getAll();
            if ($db != '') {
                $errors["user_login"] = 'login or password do not match; ';
                $errors["errors"] = true;
                foreach ($db as $row) {
                    if ($row["login"] == $_POST["user_login"] && $row["password"] == md5($_POST["user_password"])) {
                        $errors["user_login"] = '';
                        $errors["errors"] = false;
                    }
                }
            }
        }
        if ($errors["errors"] == false) {
            session_start();
            $_SESSION['user_login'] = $_POST["user_login"];
        }
        return $this->json($errors);
    }
}
