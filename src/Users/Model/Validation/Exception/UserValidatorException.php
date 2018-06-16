<?php

namespace Usere\Model\Validation\Exception;

/**
 * @author Guilherme P. Nogueira <guilhermenogueira@univicosa.com.br>
 */
class UserValidatorException extends \Exception
{
    /**
     * @param string $fieldName
     * @param int    $codeField
     *
     * @return UserValidatorException
     */
    public static function quantityInvalidChars(string $fieldName, int $codeField) : self
    {
        return new self($fieldName . ' Deve conter no mínimo 3 e no máximo 50 caracteres.', $codeField);
    }

    /**
     * @return UserValidatorException
     */
    public static function quantityInvalidGroups() : self
    {
        return new self('Você deve informar no mínimo 2 grupos.');
    }
}
