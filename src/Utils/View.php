<?php

namespace Masterclass\Utils;

use Masterclass\Exceptions\BadViewDataException;

class View
{
    /**
     * @param string $__view__ The name of the view
     * @param array $__data__ an array of data
     * @return mixed
     * @throws BadViewDataException
     */
    public static function make($__view__, $__data__ = [])
    {
        $__view__ = str_replace('.', '/', $__view__);
        if (strrpos($__view__, '.phtml', -strlen('.phtml')) === false) {
            $__view__ = $__view__ . '.phtml';
        }
        extract($__data__, EXTR_SKIP);
        foreach ($__data__ as $__key__ => $__value__) {
            if (!isset($$__key__)) {
                throw new BadViewDataException('You can\'t have a variable named ' . $__key__);
            }
        }
        require_once __BASE_DIR__ . 'src/Views/' . $__view__;
    }

}
