<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 8/25/17
 * Time: 2:13 PM
 */

namespace Masterclass\Forms;


use Modus\Forms\FormBase;

class ChangePasswordForm extends FormBase
{
    protected $fields = [
        'password',
        'password_verify',
    ];

    protected function configureValidations()
    {
        $filter = $this->filter;
        $filter->validate('password')->is('alnum')->isNotBlank();
        $filter->validate('password_verify')->is('equalToField', 'password');

        $filter->useFieldMessage('password_verify', 'The passwords don\'t match');
    }
}