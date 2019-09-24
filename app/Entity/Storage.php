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
     * Below are constants that desribe type of random value
     */
    const TYPE_STRING = 'string';
    const TYPE_INT = 'int';
    const TYPE_GUID = 'guid';
    const TYPE_TEXT = 'text';
}
