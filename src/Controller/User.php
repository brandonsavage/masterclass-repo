<?php
namespace Masterclass\Controller;

use Masterclass\Model\User as Model_User;
use Aura\View\View as Aura_View;
use Aura\Web\Response as Web_Response;
use Aura\Web\Request as Web_Request;

class User
{
    /**
     * @var Model_User
     */
    public $user_model;

    /**
     * @var Web_Response
     */
    protected $response;

    /**
     * @var Web_Request
     */
    protected $request;

    /**
     * @var Aura_View
     */
    protected $view;

    public function __construct(
        Model_User $user_model,
        Web_Request $request,
        Web_Response $response,
        Aura_View $view
    )
    {
        $this->user_model = $user_model;
        $this->response = $response;
        $this->request = $request;
        $this->view = $view;
    }

    public function create()
    {
        $error = null;

        // Do the create
        if ($this->request->post->get('create')) {
            $username = $this->request->post->get('username');
            $email = $this->request->post->get('email');
            $password = $this->request->post->get('password');
            $password2 = $this->request->post->get('password_check');

            if (
                empty($username)
                || empty($email)
                || empty($password)
                || empty($password2)
            ) {
                $error = 'You did not fill in all required fields.';
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Your email address is invalid';
            } else if($password != $password2) {
                $error = "Your passwords didn't match.";
            }
            if (is_null($error)) {
                $user = $this->user_model->getUserByUsername($username);
                if (!empty($user)) {
                    $error = 'Your chosen username already exists. Please choose another.';
                } else {
                    $id = $this->user_model->postNewUser($username, $email, $password);
                    if ($id) {
                        $this->response->redirect->to('/user/login');
                        return $this->response;
                    }
                    $error = "Unable to save the user";
                }
            }
        }
        $this->view->setView('user_create');
        $this->view->setLayout('layout');
        $this->view->setData(['error' => $error]);
        $this->response->content->set($this->view->__invoke());
        return $this->response;
    }

    public function account()
    {
        $error = null;
        if (!isset($_SESSION['AUTHENTICATED'])) {
            $this->response->redirect->to('/user/login');
            return $this->response;
        }

        if ($this->request->post->get('updatepw')) {
            $password = $this->request->post->get('password');
            $password2 = $this->request->post->get('password_check');
            if (
            !$password
            || !$password2
            || $password != $password2
            ) {
                $error = 'The password fields were blank or they did not match. Please try again.';
            } else {
                $this->user_model->updatePassword($_SESSION['username'], $password);
                $error = 'Your password was changed.';
            }
        }

        $details = $this->user_model->getUserByUserName($_SESSION['username']);
        $this->view->setLayout('layout');
        $this->view->setView('user_account');
        $this->view->setData(['details' => $details, 'error' => $error]);
        $this->response->content->set($this->view->__invoke());
        return $this->response;
    }

    public function login()
    {
        $error = null;
        // Do the login
        if ($this->request->post->get('login')) {
            $username = $this->request->post->get('user');
            $password = $this->request->post->get('pass');
            $data = $this->user_model->getUserByUserName($username);
            $password = md5($username . $password); // THIS IS NOT SECURE. DO NOT USE IN PRODUCTION.
            if (!empty($data) && $data['password'] == $password) {
                session_regenerate_id();
                $_SESSION['username'] = $data['username'];
                $_SESSION['AUTHENTICATED'] = true;
                $this->response->redirect->to('/');
                return $this->response;
            } else {
                $error = 'Your username/password did not match.';
            }
        }
        $this->view->setLayout('layout');
        $this->view->setView('user_login');
        $this->view->setData(['error' => $error]);
        $this->response->content->set($this->view->__invoke());
        return $this->response;
    }

    public function logout()
    {
        // Log out, redirect
        session_destroy();
        $this->response->redirect->to('/');
        return $this->response;
    }
}
