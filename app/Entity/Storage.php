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

    /**
     * It fills an entity with random value
     */
    public function fillRandom(string $type, int $length): void
    {
        switch ($type) {
            case Storage::TYPE_INT:
                $value = random_int(0, $length);
                break;
                
            case Storage::TYPE_GUID:
                $value = \com_create_guid(); 
                break;

            case Storage::TYPE_STRING:
                $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
                $value = substr(str_shuffle($chars), 0, $length);
                break;
                
            case Storage::TYPE_TEXT:
                $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
                $value = substr(str_shuffle($chars), 0, $length);
                break;
        }

        $this->value = $value;
    }

    /**
     * Generates random string
     */
    private function randomString($chars, $length)
    {
        $charsLength = strlen($chars);
        $output = '';
        for($i = 0; $i < $charsLength; $i++) {
            $random_character = $chars[mt_rand(0, $charsLength - 1)];
            $output .= $random_character;
        }
     
        return $output;
    }
}
