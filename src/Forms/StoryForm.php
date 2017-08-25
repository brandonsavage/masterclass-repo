<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 8/25/17
 * Time: 11:04 AM
 */

namespace Masterclass\Forms;


use Modus\Forms\FormBase;

class StoryForm extends FormBase
{
    protected $fields = [
        'created_by',
        'headline',
        'url',
    ];

    public function configureValidations()
    {
        $this->filter->validate('created_by')->is('alnum');
        $this->filter->validate('headline')->isNotBlank();
        $this->filter->validate('url')->is('url');
    }
}