<?php
/**
 * It validates request query params such as id, length and so on...
 */

declare(strict_types=1);

namespace Aviprotest\Service;

use Aviprotest\Exception\ValidatorException;

class QueryValidator
{
    /**
     * Checks if id value is valid
     */
    public function isIdValid($id): bool
    {
        if($id < 1) {
            throw new ValidatorException('ID must be an integer value and can not be less than 1');

        } else {
            return true;
        }
    }
}
