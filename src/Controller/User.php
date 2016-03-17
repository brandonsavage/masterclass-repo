<?php
namespace Masterclass\Controller;

use Masterclass\Model\User as Model_User;

class User
{
    /**
     * @var Model_User
     */
    public $user_model;

    public function __construct(Model_User $user_model)
    {
        $this->user_model = $user_model;
    }

    public function create()
    {
        $error = null;

        // Do the create
        if (isset($_POST['create'])) {
            if (empty($_POST['username']) || empty($_POST['email']) ||
                empty($_POST['password']) || empty($_POST['password_check'])
            ) {
                $error = 'You did not fill in all required fields.';
            }

            if (is_null($error)) {
                if (!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
                    $error = 'Your email address is invalid';
                }
            }

            if (is_null($error)) {
                if ($_POST['password'] != $_POST['password_check']) {
                    $error = "Your passwords didn't match.";
                }
            }

            if (is_null($error)) {
                $user = $this->user_model->getUserByUsername($_POST['username']);
                if (!empty($user)) {
                    $error = 'Your chosen username already exists. Please choose another.';
                }
            }

            if (is_null($error)) {
                $this->user_model->postNewUser($_POST['username'], $_POST['email'], $_POST['password']);
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

        require_once __DIR__ . '/../../layout.phtml';

    }

    public function account()
    {
        $error = null;
        if (!isset($_SESSION['AUTHENTICATED'])) {
            header("Location: /user/login");
            exit;
        }

        if (isset($_POST['updatepw'])) {
            if (!isset($_POST['password']) || !isset($_POST['password_check']) ||
                $_POST['password'] != $_POST['password_check']
            ) {
                $error = 'The password fields were blank or they did not match. Please try again.';
            } else {
                $this->user_model->updatePassword($_SESSION['username'], $_POST['password']);
                $error = 'Your password was changed.';
            }
        }

        $details = $this->user_model->getUserByUserName($_SESSION['username']);
        $content = '
        ' . $error . '<br />
        
        <label>Username:</label> ' . $details['username'] . '<br />
        <label>Email:</label>' . $details['email'] . ' <br />
        
         <form method="post">
                ' . $error . '<br />
            <label>Password</label> <input type="password" name="password" value="" /><br />
            <label>Password Again</label> <input type="password" name="password_check" value="" /><br />
            <input type="submit" name="updatepw" value="Create User" />
        </form>';

        require_once __DIR__ . '/../../layout.phtml';
    }

    public function login()
    {
        $error = null;
        // Do the login
        if (isset($_POST['login'])) {
            $username = $_POST['user'];
            $password = $_POST['pass'];
            $data = $this->user_model->getUserByUserName($username);
            $password = md5($username . $password); // THIS IS NOT SECURE. DO NOT USE IN PRODUCTION.
            if (!empty($data) && $data['password'] == $password) {
                session_regenerate_id();
                $_SESSION['username'] = $data['username'];
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

        require_once(__DIR__ . '/../../layout.phtml');

    }

    public function logout()
    {
        // Log out, redirect
        session_destroy();
        header("Location: /");
    }
}
