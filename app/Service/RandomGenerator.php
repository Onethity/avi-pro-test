<?php
/**
 * The class generates a random value with requested type
 */

declare(strict_types=1);

namespace Aviprotest\Service;

use Aviprotest\Entity\Storage;

class RandomGenerator
{
    /**
     * Returns a random value
     * You must validate a $type before use this function
     * @param string type of value must be one of Storage::const
     * @param int lenght of string value or maximum integer value
     */
    public function getRandom(string $type, int $length)
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
                $value = $this->randomString($chars, $length);
                break;
                
            case Storage::TYPE_TEXT:
                $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
                $value = $this->randomString($chars, $length);
                break;
        }

        return $value;
    }

    /**
     * Generates random string
     * @param string available chars
     * @param int length of string
     */
    protected function randomString(string $chars, int $length): string
    {
        $charsLength = mb_strlen($chars);
        $output = '';

        for($i = 0; $i < $length; $i++) {
            $random_character = $chars[mt_rand(0, $charsLength - 1)];
            $output .= $random_character;
        }
     
        return $output;
    }
}
