<?php

namespace Database\CustomMessages;

/**
 * @author Guilherme P. Nogueira <guilhermenogueira90@gmail.com>
 */
class DuplicateEntry implements CustomMessageInterface
{
    /**
     * @inheritDoc
     */
    public static function fromString(string $entry = '') : string
    {
        if ($entry) {
            preg_match("/1062 Duplicate entry '(.*)' for.*key ((')(.*)(')|.*)/", $entry, $matches);

            if (! isset($matches[4]) || ! isset($matches[1])) {
                throw new \Exception('Mensagem com formato inválido');
            }

            return sprintf('O campo "%s" com valor \'%s\' já está cadastrado.', $matches[4], $matches[1]);
        }

        return '';
    }
}
