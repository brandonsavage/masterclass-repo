<?php

namespace Masterclass\Controller;

use Masterclass\Model\UserMysqlDataStore as UserModel;
use Masterclass\Request;

class User
{

    protected $userModel;
    protected $request;

    public function __construct(UserModel $model, Request $request)
    {
        $this->userModel = $model;
        $this->request = $request;
    }

    public function create()
    {
        $error = null;

        // Do the create
        if ($this->request->getPostParam('create')) {

            $username = $this->request->getPostParam('username');
            $password = $this->request->getPostParam('password'); $_POST['password'];
            $passwordCheck = $this->request->getPostParam('password_check');
            $email = $this->request->getPostParam('email');

            if (empty($username)
                || empty($email)
                || empty($password)
                || empty($passwordCheck)
            ) {
                $error = 'You did not fill in all required fields.';
            }

            if (is_null($error)) {
                if (!$this->request->validateEmail($email)) {
                    $error = 'Your email address is invalid';
                }
            }

            if (is_null($error)) {
                if ($password != $passwordCheck) {
                    $error = "Your passwords didn't match.";
                }
            }

            if (is_null($error)) {
                if ($this->userModel->userExists($username)) {
                    $error = 'Your chosen username already exists. Please choose another.';
                }
            }

            if (is_null($error)) {
                $this->userModel->createUser($username, $email, $password);
                header("Location: /user/login");
                exit;
            }
        }
        // Show the create form

        $content = '
            <form method="post">
                ' . $error . '<br />
                <label>Username</label> <input type="text" name="username" value="" /><br />
                <label>Email</label> <input type="text" name="email" value="" /><br />
                <label>Password</label> <input type="password" name="password" value="" /><br />
                <label>Password Again</label> <input type="password" name="password_check" value="" /><br />
                <input type="submit" name="create" value="Create User" />
            </form>
        ';

        require_once '/vagrant/layout.phtml';

    }

    public function account()
    {
        $error = null;
        if (!isset($_SESSION['AUTHENTICATED'])) {
            header("Location: /user/login");
            exit;
        }

        $username = $_SESSION['username'];
        $password = $this->request->getPostParam('password') ?? null;

        if ($this->request->getPostParam('updatepw') !== null) {
            $passwordCheck = $this->request->getPostParam('password_check');
            if (empty($password)
                || empty($passwordCheck)
                || $password != $passwordCheck
            ) {
                $error = 'The password fields were blank or they did not match. Please try again.';
            } else {
                $this->userModel->updatePassword($username, $password);
                // @TODO: odd, there is no error.
                $error = 'Your password was changed.';
            }
        }

        $userModel = $this->userModel->loadUserByUsername($username);

        $content = '
        ' . $error . '<br />
        
        <label>Username:</label> ' . $username . '<br />
        <label>Email:</label>' . $userModel->getEmail() . ' <br />

         <form method="post">
                ' . $error . '<br />
            <label>Password</label> <input type="password" name="password" value="" /><br />
            <label>Password Again</label> <input type="password" name="password_check" value="" /><br />
            <input type="submit" name="updatepw" value="Create User" />
        </form>';

        require_once '/vagrant/layout.phtml';
    }

    public function login()
    {
        $error = null;
        // Do the login
        if (isset($_POST['login'])) {
            $username = $this->request->getPostParam('user');
            $password = $this->request->getPostParam('pass');

            if ($this->userModel->checkCredentials($username, $password)) {
                session_regenerate_id();
                $_SESSION['username'] = $username;
                $_SESSION['AUTHENTICATED'] = true;
                header("Location: /");
                exit;
            } else {
                $error = 'Your username/password did not match.';
            }
        }

        $content = '
            <form method="post">
                ' . $error . '<br />
                <label>Username</label> <input type="text" name="user" value="" />
                <label>Password</label> <input type="password" name="pass" value="" />
                <input type="submit" name="login" value="Log In" />
            </form>
        ';

        require_once('/vagrant/layout.phtml');

    }

    public function logout()
    {
        // Log out, redirect
        session_destroy();
        header("Location: /");
    }
}
