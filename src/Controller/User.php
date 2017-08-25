<?php

namespace Masterclass\Controller;

use Aura\Session\Session;
use Aura\View\View;
use Masterclass\Model\Users\Exceptions\InvalidPasswordMatch;
use Masterclass\Model\Users\Exceptions\UsernameNotProvided;
use Masterclass\Model\Users\Exceptions\UserNotFound;
use Masterclass\Model\Users\Exceptions\UserNotLoggedIn;
use Masterclass\Model\Users\UserReadService;
use Masterclass\Model\Users\UserWriteService;
use Zend\Diactoros\ServerRequest;

class User {

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var ServerRequest
     */
    protected $request;

    /**
     * @var View
     */
    protected $view;

    /**
     * @var UserReadService
     */
    private $readService;

    /**
     * @var UserWriteService
     */
    private $writeService;

    public function __construct(
        Session $session,
        ServerRequest $request,
        UserReadService $readService,
        UserWriteService $writeService,
        View $view
    ) {
        $this->session = $session;
        $this->request = $request;
        $this->view = $view;
        $this->readService = $readService;
        $this->writeService = $writeService;
    }

    public function create() {
        $error = null;

        $post = $this->request->getParsedBody();
        // Do the create
        if(isset($post['create'])) {
            try {
                $this->writeService->createUser(
                    $post['username'],
                    $post['password'],
                    $post['password_check'],
                    $post['email']
                );
            } catch (\Exception $e) {
                $error = $e->getMessage();
            }
        }
        // Show the create form

        $this->view->addData(['error' => $error]);
        $this->view->setLayout('layout');
        $this->view->setView('userCreate');
        return $this->view->__invoke();


    }

    public function account() {

        try {
            $user = $this->readService->findLoggedInUser();
        } catch (UserNotLoggedIn | UsernameNotProvided $e) {
            header("Location: /user/login");
        }

        $post = $this->request->getParsedBody();

        $error = null;

        if(isset($post['updatepw'])) {
            try {
                $this->writeService->changePassword(
                    $user->username,
                    $post['password'],
                    $post['password_check']
                );
            } catch (\Exception $e) {
                $error = $e->getMessage();
            }
        }

        $details = $user->toArray();

        $this->view->setData(['details' => $details, 'error' => $error]);
        $this->view->setLayout('layout');
        $this->view->setView('userAccount');
        return $this->view->__invoke();
    }

    public function login() {

        $error = null;
        $post = $this->request->getParsedBody();
        if (isset($post['login'])) {
            try {
                $user = $this->readService->authenticateUser(
                    $post['user'],
                    $post['pass']
                );
                header("Location: /");
                return;
            } catch (UserNotFound | InvalidPasswordMatch $e) {
                $error = $e->getMessage();
            }
        }

        $this->view->setData(['error' => $error]);
        $this->view->setLayout('layout');
        $this->view->setView('userLogin');
        return $this->view->__invoke();

    }

    public function logout() {
        // Log out, redirect
        $this->session->destroy();
        header("Location: /");
    }
}