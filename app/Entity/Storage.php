<?php
/**
 * The class describes a storage entity
 */

declare(strict_types=1);

namespace Aviprotest\Entity;

class Storage 
{
    /** 
     * @var int id of entity 
     */
    public $id;

    /** 
     * @var string value of entity
     */
    public $value;

    /**
     * It fills an antity with random value
     */
    public function fillRandom()
    {
        $this->value = random_int(PHP_INT_MIN, PHP_INT_MAX);
    }
}
