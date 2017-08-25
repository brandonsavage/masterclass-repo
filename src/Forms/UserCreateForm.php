<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 8/25/17
 * Time: 1:57 PM
 */

namespace Masterclass\Forms;


use Modus\Forms\FormBase;

class UserCreateForm extends FormBase
{
    protected $fields = [
        'username',
        'password',
        'password_verify',
        'email',
    ];

    public function configureValidations()
    {
        $filter = $this->filter;
        $filter->validate('username')->is('alnum');
        $filter->validate('email')->is('email');
        $filter->validate('password')->is('alnum')->isNotBlank();
        $filter->validate('password_verify')->is('equalToField', 'password');

        $filter->useFieldMessage('password_verify', 'The passwords don\'t match');
    }
}