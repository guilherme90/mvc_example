<?php

namespace Database\CustomMessages;

/**
 * @author Guilherme Pereira Nogueira <guilhermenogueira90@gmail.com>
 */
interface CustomMessageInterface
{
    /**
     * @param string $entry
     * @return string
     */
    public static function fromString(string $entry = '') : string;
}
