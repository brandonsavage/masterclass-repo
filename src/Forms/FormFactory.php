<?php

namespace Masterclass\Forms;

use Aura\Filter\FilterFactory;
use Modus\Forms\FormBase;

abstract class FormFactory
{
    /**
     * @param $formName
     * @return FormBase
     */
    public static function create($formName)
    {
        $filterFactory = new FilterFactory();
        return new $formName($filterFactory->newSubjectFilter());
    }
}