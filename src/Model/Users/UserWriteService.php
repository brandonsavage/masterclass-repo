<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 8/25/17
 * Time: 1:51 PM
 */

namespace Masterclass\Model\Users;


use Masterclass\Command\CommandBus;
use Masterclass\Command\Commands\CreateUser;
use Masterclass\Forms\ChangePasswordForm;
use Masterclass\Forms\FormFactory;
use Masterclass\Forms\UserCreateForm;

class UserWriteService
{
    /**
     * @var UserGateway
     */
    private $gateway;
    /**
     * @var CommandBus
     */
    private $commandBus;

    public function __construct(UserGateway $gateway, CommandBus $commandBus)
    {

        $this->gateway = $gateway;
        $this->commandBus = $commandBus;
    }

    public function createUser($username, $password, $password_verify, $email)
    {
        $form = FormFactory::create(UserCreateForm::class);

        $form->populateData([
            'username' => $username,
            'password' => $password,
            'password_verify' => $password_verify,
            'email' => $email,
        ]);

        if (!$form->validate()) {
            //TODO
            return;
        }

//        $this->gateway->createUser(
//            $form->getValue('username'),
//            $form->getValue('password'),
//            $form->getValue('email')
//        );

        $createUser = new CreateUser(
            $form->getValue('username'),
            $form->getValue('password'),
            $form->getValue('email')
        );

        $this->commandBus->perform($createUser);


    }

    public function changePassword($username, $password, $password_verify)
    {
        $form = FormFactory::create(ChangePasswordForm::class);

        $form->populateData([
            'password' => $password,
            'password_verify' => $password_verify,
        ]);

        if (!$form->validate()) {
            // TODO
            return;
        }

        $this->gateway->changePassword($username, $password);
    }
}